<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Module functions definitions.
 *
 * @package    local_uca_mycourses
 * @author     Université Clermont Auvergne - Anthony Durif
 * @copyright  2018 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//======================================================================
// MY COURSES FUNCTIONS
//======================================================================

/**
 * Returns our courses list on json format.
 * @param $all boolean to indicate if we want all the courses or not (some roles has to be excluded).
 * @return string json of courses.
 */
function get_my_courses_json_tree($all = true) {
    return json_encode(get_my_courses_tree($all));
}

/**
 * Returns our courses list on a 'tree' format with course categories.
 * @param $all boolean to indicate if we want all the courses or not.
 * @return array the tree of courses.
 */
function get_my_courses_tree($all = true) {
    global $CFG;
    include_once($CFG->dirroot.'/enrol/locallib.php');

    $courses = get_my_courses_list($all);

    $categories = array();
    $root = array();

    foreach ($courses as $course) {
        //We create the parent course categories
        $cat = core_course_category::get($course->category, MUST_EXIST,true);
        $parents = array_reverse($cat->get_parents());

        if (!isset($categories[$course->category])) {
            $categorie = new stdClass();
            $categorie->id = $course->category;
            $categorie->text = $cat->get_formatted_name();
            $categorie->type = 'category';
            $categorie->courses = array();
            $categorie->children = array();

            $categories[$course->category] = $categorie;

            for ($i=0; $i < count($parents); $i++) {
                if (!isset($categories[$parents[$i]])) {
                    $parent = core_course_category::get($parents[$i], MUST_EXIST,true);

                    $categorie = new StdClass();
                    $categorie->id = $parents[$i];
                    $categorie->text = $parent->get_formatted_name();
                    $categorie->type = 'category';
                    $categorie->courses = array();
                    $categorie->children = array();
                    $categories[$parents[$i]] = $categorie;
                }
            }
        }

        $parents = array_reverse($parents);
        $parents[] = $course->category;

        //Children course categories
        for ($i=0; $i < count($parents)-1; $i++) {
            if (!in_array($parents[$i+1], $categories[$parents[$i]]->children)) {
                $categories[$parents[$i]]->children[] = $parents[$i + 1];
            }
        }

        //Where is the root node of the tree
        $rootCat = (0 == count($parents)) ? $course->category : $parents[0];

        if (!in_array($rootCat, $root)) {
            $root[] = $rootCat;
        }

        $course_node = new stdClass();
        $course_node->text = $course->fullname;
        $course->is_bookmarked = course_bookmarked($course);
        $course_node->type = 'course';
        $course_node->data = json_encode($course);
        $course_node->children = [];

        $categories[$course->category]->courses[$course->fullname] = $course;
//        ksort($categories[$course->category]->courses);
    }

    $listeCategories = array();
    foreach ($root as $cat) {
        $listeCategories[] = get_category($cat, $categories);
    }

    foreach ($listeCategories as $cate) {
        put_courses_in_tree($cate);
    }

    return array_values($listeCategories);
}

/**
 * Returns the list of the current user courses.
 * @param $all boolean to indicate if we want all the courses or not.
 * @return array the courses.
 */
function get_my_courses_list($all = true) {
    global $USER;

    //Get courses from a core moodle function
    $my_courses = enrol_get_my_courses(null, 'fullname ASC,visible DESC,sortorder ASC');
    $to_exclude = explode(',', get_config('block_uca_mycourses', 'roles_to_exclude'));

    foreach($my_courses as $key => $course) {
        $to_unset = false;
        if(!$course->visible && !can_manage_course($course) && !$all) {
            $to_unset = true;
        }

        $course->is_bookmark = course_bookmarked($course);

        //We don't want all user courses
        if(!$all && count($to_exclude) > 0) {
            $context = context_course::instance($course->id, true);
            $roles = get_user_roles($context, $USER->id, true);
            foreach($roles as $role) {
                if(in_array($role->roleid, $to_exclude)) {
                    $to_unset = true;
                    break;
                }
            }
        }

        if($to_unset) {
            unset($my_courses[$key]);
        }
    }

    return $my_courses;
}

/**
 * Constructs a course category available in the course tree.
 * @param $id the id of the category.
 * @param $categories list of the course category.
 * @return array the category we create in the tree.
 */
function get_category($id, $categories) {
    $category = $categories[$id];
    $children = array();

    if ($category->children) {
        foreach ($category->children as $child_id) {
            $children[$categories[$child_id]->text . $child_id] = get_category($child_id, $categories);
        }
    }

    ksort($children);
    $category->children = array_values($children);

    return $category;
}

/**
 * Puts our courses in the course categories tree we just create.
 * @param $category the current course category.
 */
function put_courses_in_tree($category) {
    if (isset($category->courses)) {
        foreach ($category->courses as $course) {
            $cc = new stdClass();
            $cc->text = $course->fullname;
            $cc->data = json_encode($course);
            $cc->type = 'course';
            $cc->children = [];
            $category->children[] = $cc;
        }

        foreach ($category->children as $child) {
            put_courses_in_tree($child);
        }
    }
}

/**
 * Returns if the current user has rights to manage the course given in parameters.
 * @param $course the course we test.
 * @return bool true if the user has necessary rights and false in other cases.
 */
function can_manage_course($course) {
    $context = context_course::instance($course->id);

    return has_capability('moodle/course:update', $context);
}

//======================================================================
// COURSE BOOKMARKS FUNCTIONS
//======================================================================

/**
 * Check if the current user has course bookmarks json defined in the database.
 * @return boolean true if the current user has bookmarks and false in other cases.
 */
function user_has_bookmarks() {
    return (get_user_preferences('uca_mycourses_bookmarks') != null);
}

/**
 * Check if the current user has course bookmarks json defined in the database with active bookmarks (at least one course has been added to the bookmarks).
 * @return boolean true if the current user has bookmarks and false in other cases.
 */
function has_active_bookmarks() {
    if(user_has_bookmarks()) {
        $json_default = sprintf('[{"text":"%s", "type":"root","children":[]}]', get_string('bookmarks_root_folder', 'local_uca_mycourses'));
        $bookmarks_bdd = get_user_preferences('uca_mycourses_bookmarks');

        //The json equals the default json used as model <=> no active bookmark
        if($bookmarks_bdd === $json_default) {
            return false;
        }

        $array = json_decode($bookmarks_bdd);
        foreach ($array[0]->children as $child) {
            if($child->type == 'bookmark') {
                return true;
            }
        }

        if(isset($child->children)) {
            foreach ($child->children as $grandchild) {
                if ($grandchild->type == 'bookmark') {
                    return true;
                }
            }
        }

        return false;
    } else {
        return false;
    }
}

/**
 * Check if we display or not the user's bookmarks in the block. We display them if bookmarks exist and the user has not given cons-indications.
 * @return boolean true if the bookmarks can be display (true by default) and false in other cases
 */
function show_bookmarks() {
    if (!has_active_bookmarks()) {
        return false;
    }

    return (get_user_preferences('uca_mycourses_show_bookmarks', '?') == '?') ? true
        : (get_user_preferences('uca_mycourses_show_bookmarks') != null && get_user_preferences('uca_mycourses_show_bookmarks') != "0");
}

/**
 * Returns the user's bookmarks on a json format used by the jstree plugin.
 * @return string json string which represents the user's bookmarks used by the jstree plugin.
 *                  (or a default json if the user has no bookmarks).
 */
function get_mybookmarks_json_tree() {
    $json_default = sprintf('[{"text":"%s", "type":"root","children":[]}]', get_string('bookmarks_root_folder', 'local_uca_mycourses'));

    return (user_has_bookmarks()) ? get_user_preferences('uca_mycourses_bookmarks') : $json_default;
}

/**
 * Check if the course in parameters is in the current user's list of bookmarks.
 * @param $course the course to test.
 * @return boolean true if the given course is in the bookmarks' list of the current user.
 */
function course_bookmarked($course) {
    if(!user_has_bookmarks()) {
        return false;
    }

    $bookmarks = json_decode(get_user_preferences('uca_mycourses_bookmarks'));

    foreach($bookmarks[0]->children as $b) {
        if($b->type == 'bookmark') {
            if($b->data->id == $course->id) {
                return true;
            }
        }

        if($b->type == 'folder') {
            foreach ($b->children as $c) {
                if ($c->data->id == $course->id) {
                    return true;
                }
            }
        }
    }

    return false;
}

//======================================================================
// UCA_MYCOURSES BLOCK FUNCTIONS
//======================================================================

/**
 * Returns the type of view for the part 'My courses' of the block according to the user preferences.
 * By default if we have more than x courses then we use the "tree" view else we use the "list" view.
 * @return string the view type
 */
function get_uca_mycourses_block_view() {
    return (!is_null(get_user_preferences('uca_mycourses_view'))) ? get_user_preferences('uca_mycourses_view')
        : ((count(get_my_courses_list()) > get_config('block_uca_mycourses', 'list_view_limit')) ? 'tree' : 'list');
}

/**
 * Returns the content of the block "My courses".
 * @return string the content of the block.
 */
function local_uca_mycourses_render_block_output($page) {
    global $CFG;
    require_once($CFG->dirroot.'/local/uca_mycourses/classes/uca_renderer.php');
    require_once($CFG->dirroot.'/local/uca_mycourses/classes/uca_url_helper.php');
    $renderer = new uca_renderer($page);
    $page->requires->jquery();
    $page->requires->css('/local/uca_mycourses/styles.css');

    $show_bookmarks = show_bookmarks();
    $json_my_bookmarks = get_mybookmarks_json_tree();

    $page->requires->css('/local/uca_mycourses/jstree/dist/themes/default/style.min.css');
    $page->requires->js('/local/uca_mycourses/jstree/dist/jstree.js', true);

    if(get_uca_mycourses_block_view() == 'tree') {
        $json_my_courses = get_my_courses_json_tree(false);
        $my_courses = array();
    } else {
        $my_courses = get_my_courses_list(false);
        $json_my_courses = '';
    }

    $content = $renderer->render_from_template('local_uca_mycourses/render_block', array(
        'show_bookmarks'    => $show_bookmarks,
        'visible'           => (count($my_courses) > 0 || $json_my_courses != null) ? true : null,
        'json_courses'      => $json_my_courses,
        'courses'           => array_values($my_courses),
        'json_bookmarks'    => $json_my_bookmarks,
    ));

    return $content;
}