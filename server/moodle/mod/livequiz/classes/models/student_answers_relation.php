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
 * Class representing the relationship between students and answers.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_livequiz\models;

use dml_exception;
use mod_livequiz\repositories\answer_repository;

/**
 * Class student_answers_relation
 * @package mod_livequiz\student_answers_relation
 */
class student_answers_relation {
    /**
     *  Insert student answer relation. Represents an answer given by a student in a participation.
     *
     * @param int $studentid
     * @param int $answerid
     * @param int $participationid
     * @return int
     * @throws dml_exception
     */
    public static function insert_student_answer_relation(int $studentid, int $answerid, int $participationid): int {
        global $DB;
        return $DB->insert_record('livequiz_students_answers', [
            'student_id' => $studentid,
            'answer_id' => $answerid,
            'participation_id' => $participationid,
        ]);
    }

    /**
     * Get all answers for a student in a given participation
     *
     * @param int $studentid
     * @param int $participationid
     * @return array An array of answer id's
     * @throws dml_exception
     */
    public static function get_answersids_from_student_in_participation(int $studentid, int $participationid): array {
        global $DB;

        $answerrecords = $DB->get_records(
            'livequiz_students_answers',
            ['student_id' => $studentid, 'participation_id' => $participationid],
            '',
            'answer_id'
        );
        return array_column($answerrecords, 'answer_id');
    }

    /**
     * Check if an answer has any participations.
     * Returns amount of participations.
     *
     * @param int $answerid
     * @return int
     * @throws dml_exception
     */
    public static function get_answer_participation_count(int $answerid): int {
        global $DB;

        return $DB->count_records(
            'livequiz_students_answers',
            ['answer_id' => $answerid]
        );
    }

    /**
     * Get all answers for a given participation
     *
     * @param int $participationid
     * @return array An array of answer objects
     * @throws dml_exception
     */
    public static function get_answers_from_participation(int $participationid): array {
        global $DB;
        $answerrepository = new answer_repository();

        $answerrecords = $DB->get_records(
            'livequiz_students_answers',
            ['participation_id' => $participationid],
            '',
            'answer_id'
        );

        $answers = [];
        foreach ($answerrecords as $record) {
            $id = $record->answer_id;
            $answers[] = $answerrepository->get_answer_from_id($id);
        }

        return $answers;
    }

    /**
     * Deletes all records in student_answer_relations by participation id
     * @param int $participationid
     * @return bool
     * @throws dml_exception
     */
    public static function delete_student_answers_relation_by_participationid(int $participationid): bool {
        global $DB;
        return $DB->delete_records(
            'livequiz_students_answers',
            ['participation_id' => $participationid],
        );
    }
}
