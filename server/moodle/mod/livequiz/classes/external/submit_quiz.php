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

namespace mod_livequiz\external;

use core_external\external_function_parameters;
use core_external\external_value;
use dml_exception;
use mod_livequiz\services\livequiz_services;

/**
 * Class submit_quiz
 *
 * This class extends the core_external\external_api and is used to handle
 * the external API for appending participation in the live quiz module.
 *
 * @return     external_function_parameters The parameters required for the execute function.
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package    mod_livequiz
 */
class submit_quiz extends \core_external\external_api {
    /**
     * Returns the description of the execute_parameters function.
     * @return external_function_parameters The parameters required for the execute function.
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'quizid' => new external_value(PARAM_INT, 'Quiz ID'),
            'studentid' => new external_value(PARAM_INT, 'Student ID'),
        ]);
    }

    /**
     * Summary of execute
     * Inserts participation and answers into the DB
     * @param int $quizid
     * @param int $studentid
     * @return bool
     */
    public static function execute(int $quizid, int $studentid): bool {
        self::validate_parameters(self::execute_parameters(), ['quizid' => $quizid, 'studentid' => $studentid]);
        $services = livequiz_services::get_singleton_service_instance();
        try {
            // Insert participation into the DB.
            $participation = $services->insert_participation($studentid, $quizid);
            // Insert answers from session into the DB.
            self::insert_answers_from_session($quizid, $studentid, $participation->get_id());
            return true; // Return true if successful.
        } catch (dml_exception $e) {
            debugging('Error inserting participation: ' . $e->getMessage());
            return false; // Return false if unsuccessful.
        }
    }

    /**
     * Part of the webservice processing flow. Not called directly here,
     * but is in moodle's web service framework.
     * @return external_value
     */
    public static function execute_returns(): external_value {
        return new external_value(PARAM_BOOL, 'success');
    }

    /**
     * Insert answers from session in DB.
     * @param int $quizid
     * @param int $studentid
     * @param int $participationid
     * @return void
     * @throws dml_exception
     */
    public static function insert_answers_from_session(int $quizid, int $studentid, int $participationid): void {
        $quizquestions = $_SESSION['quiz_answers'][$quizid]; // Get the questions from the quiz.
        $answers = [];
        $services = livequiz_services::get_singleton_service_instance();
        foreach ($quizquestions as $questionid) { // Loop through each question in the quiz.
            $questionanswers = $questionid['answers']; // Get the answers for the question.
            $answers = array_merge($answers, $questionanswers); // Merge the answers into the answers array.
        }
        foreach ($answers as $answerid) { // Insert each answer choice in the DB.
            $services->insert_answer_choice($studentid, $answerid, $participationid);
        }
    }
}
