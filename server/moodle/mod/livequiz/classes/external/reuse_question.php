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
use dml_exception;
use invalid_parameter_exception;
use mod_livequiz\models\question;
use mod_livequiz\services\livequiz_services;
use PhpXmlRpc\Exception;
use stdClass;

/**
 * Class reuse_question
 *
 * This class extends the core_external\external_api and is used to handle
 * the external API for reusing(importing) into an exiting livequiz.
 *
 * @return     external_function_parameters The parameters required for the execute function.
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package    mod_livequiz
 */
class reuse_question extends external_api {
    /**
     * Returns the description of the execute_parameters function.
     * @return external_function_parameters The parameters required for the execute function.
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'quizid' => new external_value(PARAM_INT, 'Quiz ID'),
            'questionids' => new external_multiple_structure(
                new external_value(PARAM_INT, 'Question ID'),
            ),
            'lecturerid' => new external_value(PARAM_INT, 'Lecturer ID'),
        ]);
    }

    /**
     *
     * @param int $quizid
     * @param array $questionids
     * @param int $lecturerid
     * @return array
     * @throws Exception
     * @throws invalid_parameter_exception
     */
    public static function execute(int $quizid, array $questionids, int $lecturerid): array {
        self::validate_parameters(self::execute_parameters(), [
            'quizid' => $quizid,
            'questionids' => $questionids, // These are id's of the questions to be reused, in the new livequiz.
            'lecturerid' => $lecturerid,
        ]);
        $service = livequiz_services::get_singleton_service_instance();
        try {
            $livequiz = $service->get_livequiz_instance($quizid);
            $existingquestions = $livequiz->get_questions(); // These are the questions already present in the livequiz.
            $questionids = self::filter_unique_questions($questionids);
            $questionstoadd = [];
            foreach ($questionids as $id) {
                $unique = true;
                $tempquestion = $service->get_question_with_answers_from_id($id);
                $tempquestion->reset_id();
                foreach ($tempquestion->get_answers() as $answer) {
                    $answer->reset_id();
                }
                // Check if the question already exists in the livequiz.
                // If so, do not include the question in the list of questions to add.
                foreach ($existingquestions as $existingquestion) {
                    if (self::is_identical_question($tempquestion, $existingquestion)) {
                        $unique = false;
                        break;
                    }
                }
                if ($unique) {
                    $questionstoadd[] = $tempquestion;
                }
            }
            $livequiz->add_questions($questionstoadd);
            $livequiz = $service->submit_quiz($livequiz, $lecturerid); // Refresh the livequiz object.
            $returnquestions = [];
            $rawquestions = $livequiz->get_questions();
            foreach ($rawquestions as $rawquestion) {
                $returnquestions[] = $rawquestion->prepare_for_template(new stdClass());
            }
            return $returnquestions;
        } catch (dml_exception $e) {
            debugging('Error reusing question(s): ' . $e->getMessage());
        }
        return []; // Return empty array if an error occurs.
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
     * Filters an array of questions, such that only one copy of each question is kept
     * @param array $questions the questions you want to filter for unique
     * @return array
     * @throws dml_exception
     */
    private static function filter_unique_questions(array $questions): array {
        $service = livequiz_services::get_singleton_service_instance();
        $uniquequestions = [];
        foreach ($questions as $questionid) {
            $question = $service->get_question_with_answers_from_id($questionid);
            $unique = true;
            foreach ($uniquequestions as $uniquequestion) {
                // Check if the questions are identical.
                if (self::is_identical_question($question, $uniquequestion)) {
                    $unique = false;
                    break;
                }
            }
            if ($unique) { // If the question is unique, then we add it to the list.
                $uniquequestions[] = $question;
            }
        }
        $returningquestions = [];
        foreach ($uniquequestions as $uniquequestion) { // Prepare the questions for the template.
            $returningquestions[] = $uniquequestion->get_id();
        }
        return $returningquestions; // Return the prepared questions.
    }

    /**
     * Checks if two questions are identical.
     *
     * @param question $question1 The first question to compare.
     * @param question $question2 The second question to compare.
     * @return bool True if the questions are identical, false otherwise.
     */
    private static function is_identical_question(question $question1, question $question2): bool {
        if (
            $question1->get_title() == $question2->get_title()
            && $question1->get_description() == $question2->get_description()
            && $question1->get_timelimit() == $question2->get_timelimit()
            && $question1->get_explanation() == $question2->get_explanation()
            && count($question1->get_answers()) == count($question2->get_answers())
        ) {
            // If the questions are identical, then we check the answers to see if they are identical.
            $identicalanswercount = 0;
            foreach ($question1->get_answers() as $uniqueanswer) {
                foreach ($question2->get_answers() as $answer) {
                    if (
                         $answer->get_correct() == $uniqueanswer->get_correct()
                         && $answer->get_description() == $uniqueanswer->get_description()
                         && $answer->get_explanation() == $uniqueanswer->get_explanation()
                    ) {
                        $identicalanswercount++;
                        // If there are as many identical answers as there are answers.
                        // Then we won't include it in the list, as it is identical to another question.
                        if ($identicalanswercount == count($question1->get_answers())) {
                                return true;
                        }
                    }
                }
            }
                return false; // If the questions are identical, but the answers are not, then we include it in the list.
        } else {
                return false;
        }
    }
}
