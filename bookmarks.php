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
 * Bookmarks management interface.
 *
 * @package    local_uca_mycourses
 * @author     Université Clermont Auvergne - Anthony Durif, Pierre Raynaud
 * @copyright  2018 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('./lib.php');
require_once($CFG->dirroot.'/enrol/locallib.php');
require_once('./classes/uca_renderer.php');
require_once('./classes/uca_url_helper.php');

require_login();

$userctx = context_user::instance($USER->id);
//require_capability('local/uca_mycourses:manage_bookmarks', $userctx);

$PAGE->set_context($userctx);
$PAGE->set_pagelayout('admin');
$PAGE->set_url(new moodle_url('/local/uca_mycourses/bookmarks.php'));
$PAGE->set_title(fullname($USER).' - '.get_string('bookmarks:pluginname', 'local_uca_mycourses'));
$PAGE->set_heading($PAGE->title);
$PAGE->navbar->add(get_string('mycourses', 'moodle'));
$action = optional_param('action', null, PARAM_TEXT);

$PAGE->requires->css('/local/uca_mycourses/jstree/dist/themes/default/style.min.css');
$PAGE->requires->css('/local/uca_mycourses/styles.css');
$PAGE->requires->jquery_plugin('ui-css');
$PAGE->requires->jquery();
$PAGE->requires->jquery_plugin('ui');
$PAGE->requires->js('/local/uca_mycourses/jstree/dist/jstree.js', true);

$message = null;
$json = optional_param('bookmarks_tree_json', null, PARAM_TEXT);
//Form is valid
if(isset($json)) {
    try {
        $message = new stdClass();
        //We save the json as a user preference in the database
        set_user_preference('uca_mycourses_bookmarks', $json);
        //We save if the user wants to see his bookmarks in the block or not
        $show = optional_param('show_bookmarks', '', PARAM_ALPHANUMEXT);
        set_user_preference('uca_mycourses_show_bookmarks', ($show == 'on'));
        $message->type = 'success';
        $message->text = get_string('bookmarks:validation_ok', 'local_uca_mycourses');
    }
    catch (Exception $exc) {
        $message->type = 'danger';
        $message->text = $exc->getMessage();
    }
}

echo $OUTPUT->header();

$renderer = new uca_renderer($PAGE);

echo $renderer->render_from_template('local_uca_mycourses/bookmarks', array(
        'has_courses'       => (count(json_decode(get_my_courses_json_tree())) > 0),
        'json_courses'      => get_my_courses_json_tree(),
        'json_bookmarks'    => get_mybookmarks_json_tree(),
        'show_bookmarks'    => get_user_preferences('uca_mycourses_show_bookmarks'),
        'message'           => $message,
    )
);

echo $OUTPUT->footer();
