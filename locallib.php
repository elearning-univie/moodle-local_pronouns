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
 * Internal library functions for local_pronouns.
 *
 * @package     local_pronouns
 * @copyright   2026 University of Vienna
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Menu options of the pronouns profile field, one option per line.
 *
 * @return string
 */
function local_pronouns_get_menu_options(): string {
    return implode("\n", [
        '-',
        'sie/ihr | she/her',
        'er/ihm | he/him',
        'dey/dem | they/them',
    ]);
}

/**
 * Creates the pronouns user profile field (and its category) if it does not exist yet.
 *
 * @return void
 */
function local_pronouns_setup_user_info(): void {
    global $DB;

    if (!$DB->record_exists('user_info_field', ['shortname' => 'pronouns'])) {
        $categoryid = local_pronouns_get_or_create_category(get_string('categoryname', 'local_pronouns'));
        local_pronouns_create_user_info_field(
            'pronouns',
            get_string('userinfofieldname', 'local_pronouns'),
            'menu',
            $categoryid,
            0,
            1,
            local_pronouns_get_menu_options()
        );
    }

    purge_caches();
}

/**
 * Returns the id of the user profile field category with the given name, creating it if needed.
 *
 * @param string $categoryname Name of the category.
 * @return int Id of the category.
 */
function local_pronouns_get_or_create_category(string $categoryname): int {
    global $DB;

    $category = $DB->get_record('user_info_category', ['name' => $categoryname]);
    if ($category) {
        return (int) $category->id;
    }

    $record = new stdClass();
    $record->name = $categoryname;
    $record->sortorder = $DB->count_records('user_info_category') + 1;
    return (int) $DB->insert_record('user_info_category', $record);
}

/**
 * Creates a new user profile field.
 *
 * @param string $shortname Short name of the field.
 * @param string $name Display name of the field.
 * @param string $datatype Data type of the field (e.g. menu, text).
 * @param int $categoryid Id of the profile field category.
 * @param int $sortorder Sort order within the category.
 * @param int $visible Visibility of the field.
 * @param string $param1 First parameter of the field (for menus: options, one per line).
 * @param string|null $param2 Second parameter of the field.
 * @return int Id of the new field.
 */
function local_pronouns_create_user_info_field(
    string $shortname,
    string $name,
    string $datatype,
    int $categoryid,
    int $sortorder = 0,
    int $visible = 1,
    string $param1 = '',
    ?string $param2 = null
): int {
    global $DB;

    $record = new stdClass();
    $record->shortname = $shortname;
    $record->name = $name;
    $record->datatype = $datatype;
    $record->categoryid = $categoryid;
    $record->sortorder = $sortorder;
    $record->visible = $visible;
    $record->param1 = $param1;
    $record->param2 = $param2;
    $record->description = '';
    $record->timecreated = time();
    $record->timemodified = time();

    return (int) $DB->insert_record('user_info_field', $record);
}
