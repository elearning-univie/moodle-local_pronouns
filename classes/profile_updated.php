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

namespace local_pronouns;

/**
 * Handling events when a user profile gets updated.
 *
 * Copies the value of the "pronouns" profile field into the user's alternatename.
 *
 * @package   local_pronouns
 * @copyright 2026 University of Vienna
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class profile_updated {
    /**
     * Handling events when a user profile gets updated.
     *
     * @param \core\event\user_updated $event
     * @return void
     */
    public static function user_profile_updated(\core\event\user_updated $event): void {
        global $DB;

        // The updated user is the object of the event; userid is the user who performed the update.
        $userid = $event->relateduserid ?? $event->objectid;

        if (!$DB->record_exists('user', ['id' => $userid])) {
            return;
        }

        $fieldid = $DB->get_field('user_info_field', 'id', ['shortname' => 'pronouns']);
        if (!$fieldid) {
            return;
        }

        $pronoun = $DB->get_field('user_info_data', 'data', ['userid' => $userid, 'fieldid' => $fieldid]);
        if ($pronoun === false || $pronoun === null || $pronoun === '') {
            return;
        }

        $alternatename = ($pronoun !== '-') ? ' (' . $pronoun . ')' : '';
        $DB->set_field('user', 'alternatename', $alternatename, ['id' => $userid]);
    }
}
