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
 * Plugin lang file: English.
 *
 * @package    local_uca_mycourses
 * @author     Université Clermont Auvergne - Pierre Raynaud, Anthony Durif
 * @copyright  2018 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//======================================================================
// COURSES TRADUCTIONS
//======================================================================
$string['pluginname'] = 'Local plugin "My Courses"';
$string['my_courses_all'] = 'All my courses';
$string['my_courses_bookmarks'] = 'My bookmarks';

//======================================================================
// COURSE BOOKMARKS TRADUCTIONS
//======================================================================
$string['uca_mycourses:manage_bookmarks'] = 'Manage my bookmarks list';
$string['bookmarks_pluginname'] = 'Bookmarks plugin';
$string['bookmarks_root_folder'] = 'My bookmarks';
$string['bookmarks_manage'] = 'Manage my bookmarks';
$string['bookmarks_add'] = 'Add to my bookmarks';
$string['bookmarks_add_folder'] = 'New folder';
$string['bookmarks_new_folder'] = 'New folder';
$string['bookmarks_delete'] = 'Delete from my bookmarks';
$string['bookmarks_delete_folder'] = 'Delete this folder';
$string['bookmarks_my_courses'] = 'My courses';
$string['bookmarks_no_course'] = 'You are not enrolled in any course.';
$string['bookmarks_list'] = 'Bookmarked courses';
$string['bookmarks_info'] = 'Changes on your bookmarks will not be considered until you save the tree.';
$string['bookmarks_confirm'] = 'Save these bookmarks ?';
$string['bookmarks_validation'] = 'Bookmarks validation';
$string['bookmarks_validation_ok'] = 'Bookmarks list updated.';
$string['bookmarks_show_in_block'] = 'Show bookmarks in my courses block';
$string['bookmarks_access_course'] = 'Go to the course page';
$string['bookmarks:update_names'] = 'Update bookmark names if course name change';
$string['bookmarks:update_names_help'] = 'If selected, bookmarks names will be automatically updated if courses names changed.
                                        Be careful if you had custom bookmarks names they will be lost. This update is daily so it can take some time to see these changes.';


//======================================================================
// TASKS TRADUCTIONS
//======================================================================
$string['taskcleanuplocallogs'] = 'Clean standard and Talend logs from the daily synchronization';
$string['cleanbookmarks'] = 'Clean "My bookmarks" user preference';
$string['cleanbookmarks_delete'] = 'Course deleted from the bookmarks list.';
$string['cleanbookmarks_update'] = 'User preference updated.';

//======================================================================
// RGPD TRADUCTIONS
//======================================================================
$string['privacy:metadata:preference:bookmarksshow'] = 'This plugin stores if the user displays or not his bookmarks in the "My courses" block';
$string['privacy:bookmarksshow:yes'] = 'The user displays his bookmarks.';
$string['privacy:bookmarksshow:no'] = 'The user does not display his bookmarks.';
$string['privacy:metadata:preference:bookmarkslist'] = 'This plugins store the user bookmarks in a json string.';
$string['privacy:bookmarkslist'] = 'List of the user bookmarks (warning this is a json string) : <br/><pre>{$a->json}</pre>';
$string['privacy:metadata:preference:bookmarksupdatenames'] = 'This plugin stores if the user wants to update his bookmarks\' names if courses\' names changed.';
$string['privacy:bookmarksupdatenames:yes'] = 'The user wants his bookmarks\' names to follow courses\' names.';
$string['privacy:bookmarksupdatenames:no'] = 'The user does not want his bookmarks\' names to follow courses\' names.';