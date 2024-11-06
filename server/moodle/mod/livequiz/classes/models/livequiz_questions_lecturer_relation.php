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

namespace mod_livequiz\models;

use dml_exception;
use dml_transaction_exception;

/**
 * 'Static' class, do not instantiate.
 * Displays the livequiz view page.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class livequiz_questions_lecturer_relation {
    /**
     *
     * Append a relation betweeen af lecturer_id and the question_id. For easy access
     *
     * @param int $questionid
     * @param int $lecturerid
     * @return void
     * @throws dml_exception
     * @throws dml_transaction_exception
     *
     */
    public static function append_lecturer_questions_relation(int $questionid, int $lecturerid): void {
        global $DB;
        $DB->insert_record('livequiz_questions_lecturer', ['lecturer_id' => $lecturerid, 'question_id' => $questionid]);
    }

    /**
     *
     * Gets lecturer relations to questions by lecturer id. Will be used to get all the quistions that relates to that teacher
     *
     *
     * @param int $lecturerid
     * @return array
     * @throws dml_exception
     * @throws dml_transaction_exception
     *
     */
    public static function get_lecturer_questions_relation_by_lecturer_id(int $lecturerid): array {
        global $DB;
        return (array) $DB->get_record('livequiz_questions_lecturer', ['lecturer_id' => $lecturerid]);
    }

    /**
     *
     * Gets lecturer relation by quistion id. Will be used to get all the teachers that have made that question.
     *
     *
     * @param int $questionid
     * @return array
     * @throws dml_exception
     * @throws dml_transaction_exception
     *
     */
    public static function get_lecturer_questions_relation_by_questions_id(int $questionid): array {
        global $DB;
        return (array) $DB->get_record('livequiz_questions_lecturer', ['question_id' => $questionid]);
    }
    /**
     * returns array with data from livequiz_questions_lecturer based on relation id
     * @param int $id
     * @return array
     * @throws dml_exception
     */
    public static function get_lecturer_questions_relation_by_id(int $id): array {
        global $DB;
        return $DB->get_record('livequiz_questions_lecturer', ['id' => $id]);
    }

    /**
     *
     * Updates the owner of the question. in the relation. So the lecturerId will be updated.
     *
     *
     * @param int $lecturerid
     * @param int $id
     * @return void
     * @throws dml_exception
     * @throws dml_transaction_exception
     *
     */
    public static function update_lecturer_questions_relation_lecturer_id(int $id, int $lecturerid): void {
        global $DB;
        $DB->update_record('livequiz_questions_lecturer', ['id' => $id, 'lecturer_id' => $lecturerid]);
    }

    /**
     *
     * Updates the question_id using the relation id. Mabey used in the future.
     *
     *
     * @param int $questionid
     * @param int $id
     * @return array
     * @throws dml_exception
     * @throws dml_transaction_exception
     *
     */
    public static function update_lecturer_questions_relation_questions_id(int $id, int $questionid): void {
        global $DB;
        $DB->update_record('livequiz_questions_lecturer', ['id' => $id, 'question_id' => $questionid]);
    }

    /**
     *
     * Updates both question_id and lecturer_id given a lecturer_questions_relation_both id.
     *
     *
     * @param int $lecturerid
     * @param int $id
     * @param int $questionid
     * @return void
     * @throws dml_exception
     * @throws dml_transaction_exception
     *
     */
    public static function update_lecturer_questions_relation_both(int $id, int $questionid, int $lecturerid): void {
        global $DB;
        $DB->update_record('livequiz_questions_lecturer', ['id' => $id, 'question_id' => $questionid,
         'lecturer_id' => $lecturerid]);
    }
    /**
     *
     * Deletes  lecturer_questions_relation by the relation id
     *
     *
     * @param int $id
     * @return void
     * @throws dml_exception
     * @throws dml_transaction_exception
     *
     */
    public static function delete_lecturer_questions_relation_by_id(int $id): void {
        global $DB;
        $DB->delete_records('livequiz_questions_lecturer', ['id' => $id]);
    }
}
