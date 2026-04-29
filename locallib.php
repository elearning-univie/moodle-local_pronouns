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
 * Private page module utility functions
 *
 * @package     local_pronouns
 * @copyright   2026 University of Vienna
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function pronouns_setup_user_info() : void {
    global $DB;

    if (!$DB->get_record('user_info_field', ['shortname' => 'pronouns'])) {
        $pronomencategoryid = get_or_create_category(get_string('categoryname', 'local_pronouns'));
        create_user_info_field('pronouns', get_string('userinfofieldname', 'local_pronouns'),
            'menu', $pronomencategoryid, 0, 1, '-sie/ihr | she/herer/ihm | he/himdey/dem | they/them');
    }

    purge_caches();
}

function get_or_create_category($categoryname) {
    global $DB;
    $category = $DB->get_record('user_info_category', ['name' => $categoryname]);

    if (!$category) {
        $record = new stdClass();
        $record->name = $categoryname;
        $record->sortorder = $DB->count_records('user_info_category') + 1;
        $categoryId = $DB->insert_record('user_info_category', $record);
    } else {
        $categoryId = $category->id;
    }

    return $categoryId;
}

function create_user_info_field($shortname, $name, $datatype, $categoryid, $sortorder = 0, $visible = 1, $param1 = '', $param2 = null) {
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

    $DB->insert_record('user_info_field', $record);
}
