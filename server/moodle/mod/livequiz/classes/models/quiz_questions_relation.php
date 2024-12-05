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
 * Displays the livequiz view page.
 *
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_livequiz\models;

use dml_exception;
use mod_livequiz\repositories\question_repository;

/**
 * Class quiz_questions_relation
 * @package mod_livequiz\quiz_questions_relation
 */
class quiz_questions_relation {
    /**
     *  Append a question object to a quiz, given its id.
     *
     * @param int $questionid
     * @param int $quizid
     * @return void
     * @throws dml_exception
     */
    public static function insert_quiz_question_relation(int $questionid, int $quizid): void {
        global $DB;
        $DB->insert_record('livequiz_quiz_questions', ['quiz_id' => $quizid, 'question_id' => $questionid]);
    }

    /**
     * Get all questions from a quiz, given its id.
     *
     * @param $quizid int
     * @return array // An array of question objects.
     * @throws dml_exception
     */
    public static function get_questions_from_quiz_id(int $quizid): array {
        global $DB;
        $questionrepository = new question_repository();

        $questionrecords = $DB->get_records('livequiz_quiz_questions', ['quiz_id' => $quizid], '', 'question_id');
        $questionids = array_column($questionrecords, 'question_id');
        $questions = [];

        foreach ($questionids as $questionid) {
            $questions[] = $questionrepository->get_question_from_id($questionid);
        }

        return $questions;
    }

    /**
     * Takes the ID of a question and deletes all relations between the question and quizzes.
     *
     * @param int $questionid
     * @return bool
     * @throws dml_exception
     */
    public static function delete_question_quiz_relation(int $questionid): bool {
        global $DB;
        return $DB->delete_records('livequiz_quiz_questions', ['question_id' => $questionid]);
    }
}
