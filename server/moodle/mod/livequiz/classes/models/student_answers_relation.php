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
use Exception;

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
     * @return void
     * @throws dml_exception
     */
    public static function insert_student_answer_relation(int $studentid, int $answerid, int $participationid): void {
        global $DB;
        $DB->insert_record('livequiz_students_answers', [
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

        $answerids = $DB->get_records(
            'livequiz_students_answers',
            ['student_id' => $studentid, 'participation_id' => $participationid],
            '',
            'answer_id'
        );
        return $answerids;
    }
}
