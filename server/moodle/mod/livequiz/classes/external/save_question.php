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
use mod_livequiz\models\livequiz;

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
                'id' => new external_value(PARAM_INT, 'ID'),
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
    public static function execute(array $questiondata, int $lecturerid, int $quizid): array {
        debugging("execute");
        $params = self::validate_parameters(self::execute_parameters(), [
            'question' => $questiondata,
            'lecturerid' => $lecturerid,
            'quizid' => $quizid,
        ]);
        $services = livequiz_services::get_singleton_service_instance();
        $livequiz = $services->get_livequiz_instance($quizid);// Get livequiz object and add the new question to it.
        $questionid = $questiondata['id'];
        if ($questionid === 0) {// The question is new.
            $livequiz->add_question(self::new_question($questiondata));
        } else if ($questionid > 0) {// The question is already in the database.
            // Get the question from the database and set new attributes.
            $question = question::get_question_from_id($questionid);
            self::set_question_attributes($question, $questiondata);
            // Remove the old version of the question from the livequiz object and add the new version.
            $livequiz->remove_question_by_id($questionid);
            $livequiz->add_question($question);
        }

        try {
            $livequiz = $services->submit_quiz($livequiz, $lecturerid);// Submit the livequiz to the database.
            $templatelivequiz = $livequiz->prepare_for_template();
            $templatequestions = $templatelivequiz->questions;
            return $templatequestions;
        } catch (dml_exception $e) {
            debugging('Error submitting quiz: ' . $e->getMessage());
            return []; // Return empty array if unsucceful.
        }
    }

    /**
     * Part of the webservice processing flow. Not called directly here,
     * but is in moodle's web service framework.
     * @return external_value
     */
    public static function execute_returns(): external_multiple_structure {
        return new external_multiple_structure(
            new external_single_structure(
                [
                    'questionid' => new external_value(PARAM_INT, 'The ID of the question'),
                    'questiontitle' => new external_value(PARAM_TEXT, 'The title of the question'),
                    'questiondescription' => new external_value(PARAM_RAW, 'The description of the question'),
                    'questiontimelimit' => new external_value(PARAM_INT, 'The time limit for the question'),
                    'questionexplanation' => new external_value(PARAM_RAW, 'Explanation of the question'),
                    'answers' => new external_multiple_structure(
                        new external_single_structure(
                            [
                                'answerid' => new external_value(PARAM_INT, 'The ID of the answer'),
                                'answerdescription' => new external_value(PARAM_RAW, 'The description of the answer'),
                                'answerexplanation' => new external_value(PARAM_RAW, 'Explanation of the answer'),
                                'answercorrect' => new external_value(PARAM_BOOL, 'Whether the answer is correct (1 for true, 0 for false)'),
                            ]
                        ),
                        'List of answers for the question'
                    ),
                    'answertype' => new external_value(PARAM_TEXT, 'The type of answers (e.g., checkbox, radio)'),
                ]
            ),
            'List of questions'
        );
    }

    /**
     * Create new question from intermediate array-representation
     * @param array $questiondata
     * @return question
     */
    private static function new_question(array $questiondata): question {
        $question = new question($questiondata['title'], $questiondata['description'], 0, $questiondata['explanation']);
        self::add_answers_from_questiondata($question, $questiondata);
        return $question;
    }

    /**
     * Create answer objects based on the question data passed from the front-end, and add them to a question object.
     *
     * @param question $question
     * @param array $questiondata
     * @return question
     */
    private static function add_answers_from_questiondata(question $question, array $questiondata): void {
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
    }

    /**
     * Set attributes of a question object based on the question data passed from the front-end.
     *
     * @param question $question
     * @param array $questiondata
     * @return question
     */
    private static function set_question_attributes(question $question, array $questiondata): void {
        $question->set_title($questiondata['title']);
        $question->set_description($questiondata['description']);
        $question->set_explanation($questiondata['explanation']);
        $question->remove_answers();
        self::add_answers_from_questiondata($question, $questiondata);
    }
}
