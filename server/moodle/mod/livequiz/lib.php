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
 * Functions for managing livequiz instances in the Moodle database.
 *
 * @package    mod_livequiz
 * @copyright  2024 Software AAU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Adds a new instance of the livequiz to the database.
 *
 * @param object $quizdata Quiz data object
 * @return bool|int The ID of the new quiz instance or false on failure
 * @throws dml_exception When a database error occurs
 */
function livequiz_add_instance(object $quizdata): bool|int {
    global $DB;

    $modulerecord = $DB->get_records( // Get the course module records.
        'course_modules',
        ['course' => $quizdata->course, 'module' => $quizdata->module, 'section' => $quizdata->section],
        'id DESC',
        'id'
    );

    if ($modulerecord) { // Check if a record is found.
        $firstrecord = reset($modulerecord); // Get the latest record.
        $quizdata->activity_id = $firstrecord->id; // Set the activity ID.
    } else {
        $quizdata->activity_id = 0; // Handle the case where no record is found.
    }

    $quizdata->timecreated = time();
    $quizdata->timemodified = time();

    $quizdata->id = $DB->insert_record('livequiz', $quizdata);

    return $quizdata->id;
}

/**
 * Updates an existing livequiz instance in the database.
 *
 * @param object $quizdata Quiz data object
 * @return bool True on success
 * @throws dml_exception When a database error occurs
 */
function livequiz_update_instance(object $quizdata): bool {
    global $DB;

    $quizdata->timemodified = time();
    $quizdata->id = $quizdata->instance;

    $DB->update_record('livequiz', $quizdata);

    return true;
}

/**
 * Deletes a livequiz instance from the database.
 *
 * @param int $id ID of the quiz instance
 * @return bool True on success
 * @throws dml_exception When a database error occurs
 * @throws dml_exception|\PhpXmlRpc\Exception When a database error occurs
 */
function livequiz_delete_instance(int $id): bool {
    global $DB;
    $DB->delete_records('livequiz', ['id' => $id]);
    return true;
}
