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
 * Privacy Subsystem implementation for local_uca_mycourses.
 *
 * @package    local_uca_mycourses
 * @author     Université Clermont Auvergne - Anthony Durif
 * @copyright  2018 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_uca_mycourses\privacy;

use \core_privacy\local\metadata\collection;

defined('MOODLE_INTERNAL') || die();

/**
 * The local_uca_mycourses plugin stores some user preferences datas.
 *
 * @copyright  2018 Université Clermont Auvergne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
    // This plugin has data.
    \core_privacy\local\metadata\provider,
    // This plugin has some sitewide user preferences to export.
    \core_privacy\local\request\user_preference_provider {

    /** The user preference for the display of his bookmarks. */
    const BOOKMARKS_SHOW = 'uca_mycourses_show_bookmarks';
    /** The user preference corresponding to the user bookmarks' list. */
    const BOOKMARKS_LIST = 'uca_mycourses_bookmarks';
    /** The user preference corresponding to the user choice to update bookmarks names or not. */
    const BOOKMARKS_UPDATE_NAMES = 'uca_mycourses_update_bookmarks_names';

    /**
     * Returns meta data about this system.
     *
     * @param  collection $items The initialised item collection to add items to.
     * @return collection A listing of user data stored through this system.
     */
    public static function get_metadata(collection $items) : collection {
        $items->add_user_preference(self::BOOKMARKS_SHOW, 'privacy:metadata:preference:bookmarksshow');
        $items->add_user_preference(self::BOOKMARKS_LIST, 'privacy:metadata:preference:bookmarkslist');
        $items->add_user_preference(self::BOOKMARKS_LIST, 'privacy:metadata:preference:bookmarksupdatenames');
        return $items;
    }

    /**
     * Store all user preferences for the plugin.
     *
     * @param int $userid The userid of the user whose data is to be exported.
     */
    public static function export_user_preferences(int $userid) {
        $showpref = get_user_preferences(self::BOOKMARKS_SHOW, null, $userid);
        if (isset($showpref)) {
            $showprefstring = ($showpref == 'true') ? get_string('privacy:bookmarksshow:yes', 'local_uca_mycourses') : get_string('privacy:bookmarksshow:no', 'local_uca_mycourses');
            \core_privacy\local\request\writer::export_user_preference(
                'local_uca_mycourses',
                self::BOOKMARKS_SHOW,
                $showpref,
                $showprefstring
            );
        }

        $listpref = get_user_preferences(self::BOOKMARKS_LIST, null, $userid);
        if (isset($listpref)) {
            $listprefstring = get_string('privacy:bookmarkslist', 'local_uca_mycourses', array('json' => $listpref));
            \core_privacy\local\request\writer::export_user_preference(
                'local_uca_mycourses',
                self::BOOKMARKS_LIST,
                $listpref,
                $listprefstring
            );
        }

        $updatepref = get_user_preferences(self::BOOKMARKS_UPDATE_NAMES, null, $userid);
        if (isset($updatepref)) {
            $updateprefstring = ($updatepref == 'true') ? get_string('privacy:bookmarksupdatenames:yes', 'local_uca_mycourses') : get_string('privacy:bookmarksupdatenames:no', 'local_uca_mycourses');
            \core_privacy\local\request\writer::export_user_preference(
                'local_uca_mycourses',
                self::BOOKMARKS_SHOW,
                $updatepref,
                $updateprefstring
            );
        }
    }
}
