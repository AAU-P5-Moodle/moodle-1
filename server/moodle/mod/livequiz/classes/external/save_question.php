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
use core_external\external_multiple_structure;
use core_external\external_value;
use core_external\external_single_structure;
use dml_exception;
use mod_livequiz\models\answer;
use mod_livequiz\models\question;
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
class save_question extends \core_external\external_api {
    /**
     * Returns the description of the execute_parameters function.
     * @return external_function_parameters The parameters required for the execute function.
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'question' => new external_single_structure([
                'title' => new external_value(PARAM_TEXT, 'Title'),
                'description' => new external_value(PARAM_TEXT, 'Description of Question'),
                'explanation' => new external_value(PARAM_TEXT, 'Explanation of Question'),
                'answers' => new external_multiple_structure(
                    new external_single_structure([
                        'description' => new external_value(PARAM_TEXT, 'Description of Answer'),
                        'correct' => new external_value(PARAM_BOOL, 'Correctness of Answer'),
                        'explanation' => new external_value(PARAM_TEXT, 'Explanation of Answer'),
                     ]),
                    'Answers'
                ),
            ]),
            'lecturerid' => new external_value(PARAM_INT, 'Lecturer ID'),
            'quizid' => new external_value(PARAM_INT, 'Quiz ID'),
        ]);
    }

    /**
     * Summary of execute
     * Inserts participation and answers into the DB
     * @param ?? $question
     * @param int $studentid
     * @return bool
     */
    public static function execute(array $questionarray, int $lecturerid, int $quizid): bool {
        debugging("execute");
        $params = self::validate_parameters(self::execute_parameters(), [
            'question' => $questionarray,
            'lecturerid' => $lecturerid,
            'quizid' => $quizid,
        ]);
        $services = livequiz_services::get_singleton_service_instance();
        $question = self::new_question($questionarray);

        try {
            $services->insert_question($question, $lecturerid, $quizid);
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

    /**
     * Create new question from intermediate array-representation
     * @param array $questionarray
     * @return question
     */
    private static function new_question(array $questionarray): question {
        $question = new question($questionarray['title'], $questionarray['description'], 0, $questionarray['explanation']);

        if (!empty($questionarray['answers'])) {
            foreach ($questionarray['answers'] as $answerarray) {
                $answer = new answer(
                    $answerarray['description'],
                    $answerarray['correct'],
                    $answerarray['explanation']
                );
                $question->add_answer($answer);
            }
        }
        return $question;
    }
}
