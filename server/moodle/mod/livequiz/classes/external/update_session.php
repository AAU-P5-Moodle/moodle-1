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
use core_external\external_value;
use invalid_parameter_exception;

/**
 * Class update_session
 *
 * This class extends the core_external\external_api and is used to handle
 * the external API for updating the session with currently checked answers in the live quiz module.
 *
 * @return     external_function_parameters The parameters required for the execute function.
 * @package    mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class update_session extends external_api {
    /**
     * Returns the description of the execute_parameters function.
     * @return external_function_parameters The parameters required for the execute function.
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'quizid' => new external_value(PARAM_INT, 'quizid'),
            'questionid' => new external_value(PARAM_INT, 'questionid'),
            'answers' => new external_value(PARAM_TEXT, 'answers'),
        ]);
    }

    /**
     * Summary of execute
     * @param $quizid
     * @param $questionid
     * @param $answervalue
     * @return bool
     * @throws invalid_parameter_exception
     */
    public static function execute($quizid, $questionid, $answervalue): bool {
        self::validate_parameters(
            self::execute_parameters(),
            ['quizid' => $quizid, 'questionid' => $questionid, 'answers' => $answervalue]
        );
        return self::update_answers_in_session($quizid, $questionid, $answervalue);
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
     * Update the session with the currently checked answers.
     * @param $quizid
     * @param $questionid
     * @param $answervalue
     * @return bool
     */
    public static function update_answers_in_session($quizid, $questionid, $answervalue): bool {
        $answers = [];
        $decodeanswer = json_decode($answervalue, true);
        foreach ($decodeanswer as $value) {
            $answers[] = $value;
        }
        // The array[$quizid][$questionid][answers] will give an array of the answers for that specific question id.
        $_SESSION['quiz_answers'][$quizid][$questionid] = [
            'quizid' => $quizid,
            'questionid' => $questionid,
            'answers' => $answers,
        ];
        return isset($_SESSION['quiz_answers']); // Return true if the session variable is set.
    }
}
