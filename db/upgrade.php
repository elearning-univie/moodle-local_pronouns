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
 * Upgrade steps for local_pronouns.
 *
 * @package   local_pronouns
 * @copyright 2026 University of Vienna
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../locallib.php');

/**
 * Upgrade the local_pronouns plugin.
 *
 * @param int $oldversion The version we are upgrading from.
 * @return bool
 */
function xmldb_local_pronouns_upgrade($oldversion) {
    global $DB;

    if ($oldversion < 2026092801) {
        // Earlier versions created the menu options of the pronouns field in one single line.
        // Split them into one option per line and repair data saved with the broken option.
        $brokenoptions = '-sie/ihr | she/herer/ihm | he/himdey/dem | they/them';
        $field = $DB->get_record('user_info_field', ['shortname' => 'pronouns', 'datatype' => 'menu']);

        if ($field && $field->param1 === $brokenoptions) {
            $DB->set_field('user_info_field', 'param1', local_pronouns_get_menu_options(), ['id' => $field->id]);

            $select = 'fieldid = :fieldid AND ' . $DB->sql_compare_text('data') . ' = ' . $DB->sql_compare_text(':data');
            $params = ['fieldid' => $field->id, 'data' => $brokenoptions];
            $userids = $DB->get_fieldset_select('user_info_data', 'userid', $select, $params);
            $DB->set_field_select('user_info_data', 'data', '-', $select, $params);

            foreach ($userids as $userid) {
                $DB->set_field('user', 'alternatename', '', ['id' => $userid, 'alternatename' => ' (' . $brokenoptions . ')']);
            }
        }

        upgrade_plugin_savepoint(true, 2026092801, 'local', 'pronouns');
    }

    return true;
}
