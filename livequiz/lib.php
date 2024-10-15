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
defined('MOODLE_INTERNAL') || die();

/**
 * @param $quizdata
 * @return bool|int
 * @throws dml_exception
 */
function livequiz_add_instance($quizdata){
    global $DB;

    $quizdata->timecreated = time();
    $quizdata->timemodified = time();

    $quizdata->id = $DB->insert_record('livequiz', $quizdata);

    return $quizdata->id;
}

/**
 * @param $quizdata
 * @return bool
 * @throws dml_exception
 */
function livequiz_update_instance($quizdata){
    global $DB;

    $quizdata->timemodified = time();
    //$quizdata->id = $quizdata->instance;

    $DB->update_record('livequiz', $quizdata);

    return true;
}

/**
 * @param $id
 * @return bool
 * @throws dml_exception
 */
function livequiz_delete_instance($id){
    global $DB;

    $DB->delete_records('livequiz', ['id' => $id]);

    return true;
}