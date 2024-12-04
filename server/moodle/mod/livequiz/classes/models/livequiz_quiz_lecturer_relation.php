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
 * Class for relation between quiz and lecturer
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class livequiz_quiz_lecturer_relation {
    /**
     *
     * Append a relation between af lecturer_id and the quiz id. For easy access
     *
     * @param int $quizid
     * @param int $lecturerid
     * @return void
     * @throws dml_exception
     * @throws dml_transaction_exception
     *
     */
    public static function append_lecturer_quiz_relation(int $quizid, int $lecturerid): void {
        global $DB;
        $DB->insert_record('livequiz_quiz_lecturer', ['lecturer_id' => $lecturerid, 'quiz_id' => $quizid]);
    }

    /**
     *
     * Gets lecturer relation by lecturer id. Will be used to get all the quizes that relates to that teacher
     *
     *
     * @param int $lecturerid
     * @return array
     * @throws dml_exception
     * @throws dml_transaction_exception
     *
     */
    public static function get_lecturer_quiz_relation_by_lecturer_id(int $lecturerid): array {
        global $DB;
        return $DB->get_record('livequiz_quiz_lecturer', ['lecturer_id' => $lecturerid]);
    }
    /**
     *
     * Gets lecturer relation by quizid and lecturerid.
     * Used to see if a relation exists.
     *
     * @param int $quizid
     * @param int $lecturerid
     * @return bool
     * @throws dml_exception
     * @throws dml_transaction_exception
     *
     */
    public static function check_lecturer_quiz_relation_exists(int $quizid, int $lecturerid): bool {
        global $DB;
        return $DB->record_exists('livequiz_quiz_lecturer', ['lecturer_id' => $lecturerid, 'quiz_id' => $quizid]);
    }
    /**
     *
     * Gets lecturer relations by lecturer id. Will be used to get all the quizes that relates to that teacher
     *
     *
     * @param int $lecturerid
     * @return array
     * @throws dml_exception
     * @throws dml_transaction_exception
     *
     */
    public static function get_lecturer_quiz_relations_by_lecturer_id(int $lecturerid): array {
        global $DB;
        return $DB->get_records('livequiz_quiz_lecturer', ['lecturer_id' => $lecturerid]);
    }

    /**
     *
     * Gets lecturer relation by quiz id. Will be used to get all the teachers that have made that quiz.
     *
     *
     * @param int $quizid
     * @return array
     * @throws dml_exception
     * @throws dml_transaction_exception
     *
     */
    public static function get_lecturer_quiz_relation_by_quiz_id(int $quizid): array {
        global $DB;
        return (array) $DB->get_record('livequiz_quiz_lecturer', ['quiz_id' => $quizid]);
    }
    /**
     * returns array with data from livequiz_quiz_lecturer based on relation id
     * @param int $id
     * @return array
     * @throws dml_exception
     */
    public static function get_lecturer_quiz_relation_by_id(int $id): array {
        global $DB;
        return (array) $DB->get_record('livequiz_quiz_lecturer', ['id' => $id]);
    }

    /**
     *
     * Deletes  lecturer_quiz_relation by the relation id
     *
     *
     * @param int $id
     * @return void
     * @throws dml_exception
     * @throws dml_transaction_exception
     *
     */
    public static function delete_lecturer_quiz_relation_by_id(int $id): void {
        global $DB;
        $DB->delete_records('livequiz_quiz_lecturer', ['id' => $id]);
    }
}
