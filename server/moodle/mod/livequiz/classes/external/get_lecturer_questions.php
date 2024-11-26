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
use mod_livequiz\models\livequiz_questions_lecturer_relation;
use mod_livequiz\models\question;
use stdClass;

/**
 * Class get_lecturer_questions
 *
 * This class extends the core_external\external_api and is used to handle
 * the external API for saving questions to a livequiz.
 *
 * @return     external_function_parameters The parameters required for the execute function.
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package    mod_livequiz
 */
class get_lecturer_questions extends external_api {
    /**
     * Returns the description of the execute_parameters function.
     * @return external_function_parameters The parameters required for the execute function.
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'lecturerid' => new external_value(PARAM_INT, 'Lecturer ID'),
        ]);
    }

    /**
     * Summary of execute
     * Retrieves a question by its ID
     * @param int $lecturerid
     * @return array
     * @throws invalid_parameter_exception
     * @throws dml_exception
     */
    public static function execute(int $lecturerid): array {
        self::validate_parameters(self::execute_parameters(), [
            'lecturerid' => $lecturerid,
        ]);
        $rawquestions = livequiz_questions_lecturer_relation::get_lecturer_questions_relation_by_lecturer_id($lecturerid);
        //$rawquestions = self::filter_unique_questions($rawquestions);
        $questions = [];
        foreach ($rawquestions as $rawquestion) {
            $questions[] = $rawquestion->question_id;
        }
        return self::filter_unique_questions($questions);
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
     */
    private static function filter_unique_questions(array $questions): array {
        $uniquequestions = [];
        foreach ($questions as $questionid) {
            $question = question::get_question_with_answers_from_id($questionid);
            $unique = true;
            foreach ($uniquequestions as $uniquequestion) {
                // Check if the questions are identical.
                if (
                    $question->get_title() == $uniquequestion->get_title()
                    && $question->get_description() == $uniquequestion->get_description()
                    && $question->get_timelimit() == $uniquequestion->get_timelimit()
                    && $question->get_explanation() == $uniquequestion->get_explanation()
                    && count($question->get_answers()) == count($uniquequestion->get_answers())
                ) {
                    // If the questions are identical, then we check the answers to see if they are identical.
                    $identicalanswercount = 0;
                    foreach ($uniquequestion->get_answers() as $uniqueanswer) {
                        foreach ($question->get_answers() as $answer) {
                            if (
                                $answer->get_correct() == $uniqueanswer->get_correct()
                                && $answer->get_description() == $uniqueanswer->get_description()
                                && $answer->get_explanation() == $uniqueanswer->get_explanation()
                            ) {
                                $identicalanswercount++;
                                // If there are as many identical answers as there are answers.
                                // Then we won't include it in the list, as it is identical to another question.
                                if ($identicalanswercount == count($question->get_answers())) {
                                    $unique = false;
                                    break 3;
                                }
                            }
                        }
                    }
                }
            }
            if ($unique) {
                $uniquequestions[] = $question;
            }
        }
        $returningquestions = [];
        foreach ($uniquequestions as $uniquequestion) {
            $returningquestions[] = $uniquequestion->prepare_for_template(new stdClass());
        }
        return $returningquestions;
    }
}
