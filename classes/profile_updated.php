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
 * Handling events when a user profile gets updated.
 *
 * @package   local_pronouns
 * @copyright 2026 University of Vienna
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_pronouns;

defined('MOODLE_INTERNAL') || die();

/**
 * Handling events when a user profile gets updated.
 *
 * @package   local_univie
 * @copyright 2024 University of Vienna
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class profile_updated {
    /**
     * Handling events when a user profile gets updated.
     *
     * @param object $event
     */
    public static function user_profile_updated($event) {
        global $DB;

        $userid = $event->userid;

        if (is_siteadmin($userid) ){
            if ($event->userid != $event->objectid) {
                $userid = $event->objectid;
            }
        }

        if (!($user = $DB->get_record('user', ['id' => $userid]))) {
            return;
        }

        $sql = "SELECT id FROM {user_info_field} WHERE shortname LIKE 'pronouns'";
        $fieldid = $DB->get_field_sql($sql);
        if ($fieldid) {
            $pronoun = $DB->get_field('user_info_data', 'data', ['userid' => $userid, 'fieldid' => $fieldid]);
            if ($pronoun) {
                if($pronoun != '-' AND ($pronoun != NULL OR $pronoun == "")) {
                    $user->alternatename = " (" . $pronoun . ")";
                    $DB->update_record('user', $user);
                } else {
                    $user->alternatename = "";
                    $DB->update_record('user', $user);
                }
            }
        }
    }
}
