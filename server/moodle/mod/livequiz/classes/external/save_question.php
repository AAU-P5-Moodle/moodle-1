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
use PhpXmlRpc\Exception;

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
     * @param array $questiondata
     * @param int $lecturerid
     * @param int $quizid
     * @return bool
     * @throws Exception
     * @throws \invalid_parameter_exception
     * @throws dml_exception
     */
    public static function execute(array $questiondata, int $lecturerid, int $quizid): bool {
        self::validate_parameters(self::execute_parameters(), [
            'question' => $questiondata,
            'lecturerid' => $lecturerid,
            'quizid' => $quizid,
        ]);
        $services = livequiz_services::get_singleton_service_instance();

        // Get livequiz object and add the new question to it.
        $livequiz = $services->get_livequiz_instance($quizid);
        $question = self::new_question($questiondata);
        $livequiz->add_question($question);

        try {
            $services->submit_quiz($livequiz, $lecturerid);// Submit the livequiz to the database.
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
     * Create new question from intermediate array-representation
     * @param array $questiondata
     * @return question
     */
    private static function new_question(array $questiondata): question {
        $question = new question($questiondata['title'], $questiondata['description'], 0, $questiondata['explanation']);

        if (!empty($questiondata['answers'])) { // Loop through answers and add them to the question.
            foreach ($questiondata['answers'] as $answerdata) {
                $answer = new answer(
                    $answerdata['correct'],
                    $answerdata['description'],
                    $answerdata['explanation']
                );
                $question->add_answer($answer);
            }
        }
        return $question;
    }
}
