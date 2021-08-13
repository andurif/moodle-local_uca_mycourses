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
 * AJAX methods definitions.
 *
 * File used to execute function made with an AJAX call.
 *
 * @package    local_uca_mycourses
 * @author     Université Clermont Auvergne - Anthony Durif
 * @copyright  2008 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('AJAX_SCRIPT', true);

require_once('../../config.php');
require_once('./lib.php');

$action  = required_param('action', PARAM_ALPHANUMEXT);
$PAGE->set_url(new moodle_url('/local/uca_mycourses/ajax.php', array('action' => $action)));

$response = new stdClass();

try {
    switch ($action) {
        case 'change_my_course_view':
            // We want to change the view of our courses in the block.
            $default_view = get_uca_mycourses_block_view();
            $target  = optional_param('target', $default_view, PARAM_ALPHANUMEXT);
            set_user_preference('uca_mycourses_view', $target);
            $response->type = 'success';
            break;

        default:
            break;
    }
} catch (Exception $exc) {
    $response->type = 'error';
    $response->message = $exc->getMessage();
}

echo json_encode($response);
exit;