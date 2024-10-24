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



namespace mod_livequiz\questions_answers_relation;

use dml_exception;
use dml_transaction_exception;
use mod_livequiz\answers\answers;

/**
 * 'Static' class, do not instantiate.
 * Displays the livequiz view page.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class questions_answers_relation
{
    /**
     * Append an answer to a question, given their ids
     *
     * @param int $questionid
     * @param int $answerid
     * @return void
     * @throws dml_exception
     * @throws dml_transaction_exception
     */
    public static function append_answer_to_question(int $questionid, int $answerid) : void {
        global $DB;
        try {
            $transaction = $DB->start_delegated_transaction();

            $DB->insert_record('livequiz_questions_answers', ['question_id' => $questionid, 'answer_id' => $answerid]);

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
            throw $e;
        }

    }

    /**
     * Get all answers from a question, given its id
     *
     * @param $questionid int
     * @return array
     * @throws dml_exception
     */
    public static function get_answers_from_question(int $questionid) : array {
        global $DB;

        $answerrecords = $DB->get_records('livequiz_questions_answers', ['question_id' => $questionid], '', 'question_id');
        $answerids = array_column($answerrecords, 'question_id');
        $answers = [];

        foreach ($answerids as $answerid) {
            $answers[] = answers::get_answer_from_id($answerid);
        }

        return $answers;
    }

    /* TODO discuss deletion.
     public static function remove_answer_from_question ($) {

     }
    */
}
