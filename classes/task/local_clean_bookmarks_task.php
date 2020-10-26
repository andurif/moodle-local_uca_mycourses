<?php
/**
 * Created by PhpStorm.
 * User: antdurif
 * Date: 27/09/18
 * Time: 14:21
 */

/**
 * A scheduled task.
 *
 * @package    local_uca_my_courses
 * @author     Université Clermont Auvergne - Anthony Durif
 * @copyright  2018 - Université Clermont Auvergne
 */
namespace local_uca_mycourses\task;

/**
 * Schedule task to clean user bookmarks especially to delete bookmarks for deleted courses.
 *
 * @package    local_uca_create_courses
 * @copyright  2018 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_clean_bookmarks_task extends \core\task\scheduled_task {

    protected $roles_to_exclude;

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('cleanbookmarks', 'local_uca_mycourses');
    }

    /**
     * Do the job.
     * On met à jour les préférences "Mes favoris" des utilisateurs pour ne plus prendre en compte les cours qui ont été supprimés
     * (éviter le lien du favori qui donne une 404) ou auxquels l'utilisateur n'a plus accès.
     */
    public function execute() {
        global $DB;

        $this->roles_to_exclude = explode(',', get_config('block_uca_mycourses', 'roles_to_exclude'));
        $json_default = sprintf('[{"text":"%s", "type":"root","children":[]}]', get_string('bookmarks_root_folder', 'local_uca_mycourses'));
        $json_default_prod = '[{"id":"j2_1","text":"Mes Favoris","icon":"https://ent.uca.fr/moodle/pix/i/info.png","data":{},"children":[],"type":"root"}]';
        $lignes = $DB->get_records_sql('SELECT * FROM {user_preferences} WHERE name = ? AND value != ? AND value != ?', array('uca_mycourses_bookmarks', $json_default, $json_default_prod));

        foreach ($lignes as $ligne) {
            $update = false;
            $bookmarks_json = json_decode($ligne->value);
            $update_names = (get_user_preferences('uca_mycourses_update_bookmarks_names', '?', $ligne->userid) == "1");
            if (isset($bookmarks_json) && isset($bookmarks_json[0])) {
                foreach ($bookmarks_json[0]->children as $key => $child) {
                    if ($child->type == 'bookmark') {
                        // We have a bookmark on root node.
                        $delete = false;
                        $course = $DB->get_record('course', array('id' => $child->data->id));
                        if (!$course) {
                            // This course does not exist anymore so we remote it from the bookmarks list.
                            $delete = true;
                        } else {
                            // Check if user has manager capabilities on this course.
                            $delete = $this->remove_course_from_bookmarks($course, $ligne);
                            // Check if course name changed. In this cas we update json datas.
                            if ($course->fullname != $child->data->fullname) {
                                $child->data->fullname = $course->fullname;
                                $update = true;
                            }
                            // Check if course name changed and if the user wants his bookmarks names to follow courses names.
                            if ($course->fullname != $child->text && $update_names) {
                                $child->text = $course->fullname;
                                $update = true;
                            }
                        }

                        if ($delete) {
                            // Delete this course in the user bookmarks list.
                            //array_splice($bookmarks_json[0]->children, $key, 1);
                            unset($bookmarks_json[0]->children[$key]);
                            $update = true;
                            mtrace(get_string('cleanbookmarks_delete', 'local_uca_mycourses'));
                        }
                    } else {
                        // Folders.
                        foreach ($child->children as $key2 => $grandchild) {
                            if ($grandchild->type == 'bookmark') {
                                $delete = false;
                                $course = $DB->get_record('course', array('id' => $grandchild->data->id));
                                if (!$course) {
                                    // This course does not exist anymore so we remote it from the bookmarks list.
                                    $delete = true;
                                } else {
                                    // Check if user has manager capabilities on this course.
                                    $delete = $this->remove_course_from_bookmarks($course, $ligne);
                                    // Check if course name changed. In this cas we update json datas.
                                    if ($course->fullname != $grandchild->data->fullname) {
                                        $grandchild->data->fullname = $course->fullname;
                                        $update = true;
                                    }
                                    // Check if course name changed and if the user wants his bookmarks names to follow courses names.
                                    if ($course->fullname != $grandchild->text && $update_names) {
                                        $grandchild->text = $course->fullname;
                                        $update = true;
                                    }
                                }

                                if ($delete) {
                                    // Delete this course in the user bookmarks list.
                                    //array_splice($child->children, $key2, 1);
                                    unset($bookmarks_json[0]->children[$key]);
                                    $update = true;
                                    mtrace(get_string('cleanbookmarks_delete', 'local_uca_mycourses'));
                                }
                            }
                        }
                    }
                }
                $bookmarks_json[0]->children = array_values($bookmarks_json[0]->children);
            }
            if ($update) {
                $ligne->value = json_encode($bookmarks_json);
                $DB->update_record('user_preferences', $ligne);
                mtrace(get_string('cleanbookmarks_update', 'local_uca_mycourses') . ' [id=' . $ligne->id . ']');
            }
        }
    }

    /**
     * Fonction permettant de savoir si le cours doit être supprimé ou non des favoris du user
     * @param $course le cours en question
     * @param $ligne l'entrée dans les préférences
     * @return bool true si le course doit être enlevé et false sinon
     */
    function remove_course_from_bookmarks($course, $ligne) {
        $delete = (!is_enrolled(\context_course::instance($course->id), $ligne->userid));

        if ($delete) {
            return true;
        }

        $roles = get_user_roles(\context_course::instance($course->id), $ligne->userid, true);
        foreach ($roles as $role) {
            if (in_array($role->roleid, $this->roles_to_exclude)) {
                return true;
                break;
            }
        }

        return $delete;
    }
}