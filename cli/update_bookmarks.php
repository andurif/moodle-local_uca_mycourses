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
 * Custom script made to update bookmarks. It will check if courses added as bookmark still exist.
 * If not courses will be removed from the list.
 *
 * @package    local_uca_mycourses
 * @author     Université Clermont Auvergne - Pierre Raynaud, Anthony Durif
 * @copyright  2018 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require('../../../config.php');

$jsons = $DB->get_records('user_preferences', array('name' => 'uca_mycourses_bookmarks'), 'userid asc');

foreach ($jsons as $json) {
    $update = false;
    $bookmarks = json_decode($json->value);
    foreach ($bookmarks[0]->children as $key => $child) {
        if ($child->type == "bookmark") {
            // We have bookmarks under root node.
            $delete = false;
            $c = $DB->get_record('course', array('id' => $child->data->id));
            if (!$c) {
                // The course does not exist anymore => we remove it form the bookmarks list.
                $delete = true;
            } else {
                // The course still exists: we check if the user has rights on this course (or his roles are not in the list of roles to exclude).
                $role = $DB->record_exists('role_assignments',
                    array('userid' => $json->userid, 'contextid' => context_course::instance($c->id)->id));
                $delete = (!$role);
            }

            if ($delete) {
                // The course must be removed from the boookmarks.
                array_splice($bookmarks[0]->children, $key, 1);
                $update = true;
            }
        } else {
            // There are folders in the tree.
            foreach ($child->children as $key2 => $grandchild) {
                if ($grandchild->type == "bookmark") {
                    $delete = false;
                    $c = $DB->get_record('course', array('id' => $grandchild->data->id));
                    if (!$c) {
                        // The course does not exist anymore => we remove it form the bookmarks list.
                        $delete = true;
                    } else {
                        // The course still exists: we check if the user has rights on this course (or his roles are not in the list of roles to exclude).
                        $role = $DB->record_exists('role_assignments',
                            array('userid' => $json->userid, 'contextid' => context_course::instance($c->id)->id));
                        $delete = (!$role);
                    }

                    if ($delete) {
                        // the bookmark has to be deleted.
                        array_splice($child->children, $key2, 1);
                        $update = true;
                    }
                }
            }
        }
    }

    if ($update) {
        // We save possibles changes.
        $json->value = json_encode($bookmarks);
        $DB->update_record('user_preferences', $json);
    }
}
