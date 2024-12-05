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

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_multiple_structure;
use core_external\external_value;
use core_external\external_single_structure;
use dml_exception;
use exception;
use invalid_parameter_exception;
use mod_livequiz\models\answer;
use mod_livequiz\models\question;
use mod_livequiz\services\livequiz_services;

/**
 * Class save_question
 *
 * This class extends the core_external\external_api and is used to handle
 * the external API for saving questions to a livequiz.
 *
 * @return     external_function_parameters The parameters required for the execute function.
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package    mod_livequiz
 */
class save_question extends external_api {
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
                'type' => new external_value(PARAM_INT, "Type of the question as integer"),
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
     * @return array
     * @throws Exception
     * @throws invalid_parameter_exception
     * @throws dml_exception
     */
    public static function execute(array $questiondata, int $lecturerid, int $quizid): array {
        self::validate_parameters(self::execute_parameters(), [
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
            // Get the question from the livequiz and set new attributes.
            $question = $livequiz->get_question_by_id($questionid);
            self::set_question_attributes($question, $questiondata);
        }

        try {
            $livequiz = $services->submit_quiz($livequiz, $lecturerid);// Submit the livequiz to the database.
            $templatelivequiz = $livequiz->prepare_for_template();
            $templatequestions = $templatelivequiz->questions;
            return $templatequestions;
        } catch (dml_exception $dmle) {
            debugging('Error inserting livequiz into database: ' . $dmle->getMessage());
            throw $dmle;
        }
    }

    /**
     * Part of the webservice processing flow. Not called directly here,
     * but is in moodle's web service framework.
     * @return external_multiple_structure
     */
    public static function execute_returns(): external_multiple_structure {
        return new external_multiple_structure(data_structure_helper::get_question_structure(), 'List of questions');
    }

    /**
     * Create new question from intermediate array-representation
     * @param array $questiondata
     * @return question
     */
    private static function new_question(array $questiondata): question {
        $question = new question($questiondata['title'], $questiondata['description'], 0, $questiondata['explanation']);
        $question->set_type($questiondata['type']);
        self::add_answers_from_questiondata($question, $questiondata);
        return $question;
    }

    /**
     * Create answer objects based on the question data passed from the front-end, and add them to a question object.
     *
     * @param question $question
     * @param array $questiondata
     * @return void
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
     * @return void
     */
    private static function set_question_attributes(question $question, array $questiondata): void {
        $question->set_title($questiondata['title']);
        $question->set_description($questiondata['description']);
        $question->set_explanation($questiondata['explanation']);
        $question->set_type($questiondata['type']);
        $question->remove_answers();
        self::add_answers_from_questiondata($question, $questiondata);
    }
}
