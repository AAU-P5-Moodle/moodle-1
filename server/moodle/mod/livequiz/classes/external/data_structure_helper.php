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

use core_external\external_single_structure;
use core_external\external_multiple_structure;
use core_external\external_value;

/**
 * Class webservice_helper
 *
 * This class has helper methods for specifying external webservices.
 *
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class data_structure_helper {
    /**
     * Retrieves the quiz structure used in the front-end.
     *
     * @return external_single_structure
     */
    public static function get_quiz_structure(): external_single_structure {
        return new external_single_structure([
            'quizid' => new external_value(PARAM_INT, 'The ID of the livequiz'),
            'quiztitle' => new external_value(PARAM_TEXT, 'The name of the livequiz'),
            'numberofquestions' => new external_value(PARAM_TEXT, 'The course the livequiz is created under'),
            'questions' => new external_multiple_structure(self::get_question_structure(), 'List of questions'),
        ]);
    }
    /**
     * retrieves the question structure used in the front-end.
     *
     * @return external_single_structure
     */
    public static function get_question_structure(): external_single_structure {
        return new external_single_structure(
            [
                'questionid' => new external_value(PARAM_INT, 'The ID of the question'),
                'questiontitle' => new external_value(PARAM_TEXT, 'The title of the question'),
                'questiondescription' => new external_value(PARAM_RAW, 'The description of the question'),
                'questiontimelimit' => new external_value(PARAM_INT, 'The time limit for the question'),
                'questionexplanation' => new external_value(PARAM_RAW, 'Explanation of the question'),
                'questiontype' => new external_value(PARAM_TEXT, 'Type of the question (radio or checkbox)'),
                'answers' => new external_multiple_structure(
                    new external_single_structure(
                        [
                            'answerid' => new external_value(PARAM_INT, 'The ID of the answer'),
                            'answerdescription' => new external_value(PARAM_RAW, 'The description of the answer'),
                            'answerexplanation' => new external_value(PARAM_RAW, 'Explanation of the answer'),
                            'answercorrect' => new external_value(
                                PARAM_BOOL,
                                'Whether the answer is correct (1 for true, 0 for false)'
                            ),
                        ]
                    ),
                    'List of answers for the question'
                ),
            ]
        );
    }
}
