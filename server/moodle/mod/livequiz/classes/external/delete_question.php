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
use core_external\external_single_structure;
use dml_exception;
use invalid_parameter_exception;
use mod_livequiz\services\livequiz_services;
use PhpXmlRpc\Exception;

/**
 * Class delete_question
 *
 * This class extends the core_external\external_api and is used to handle
 * the external API for deleting questions from a livequiz.
 *
 * @return     external_function_parameters The parameters required for the execute function.
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package    mod_livequiz
 */
class delete_question extends external_api {
    /**
     * Returns the description of the execute_parameters function.
     * @return external_function_parameters The parameters required for the execute function.
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'questionid' => new external_value(PARAM_INT, 'Question ID'),
            'lecturerid' => new external_value(PARAM_INT, 'Lecturer ID'),
            'quizid' => new external_value(PARAM_INT, 'Quiz ID'),
        ]);
    }

    /**
     * Summary of execute
     * Deletes a question from the DB
     * @param int $questionid
     * @param int $lecturerid
     * @param int $quizid
     * @return array
     * @throws invalid_parameter_exception|Exception
     */
    public static function execute(int $questionid, int $lecturerid, int $quizid): array {
        self::validate_parameters(self::execute_parameters(), [
            'questionid' => $questionid,
            'lecturerid' => $lecturerid,
            'quizid' => $quizid,
        ]);
        $services = livequiz_services::get_singleton_service_instance();
        try {
            $livequiz = $services->get_livequiz_instance($quizid); // Get livequiz object and remove a question from it.
            $livequiz->remove_question_by_id($questionid);
            $services->submit_quiz($livequiz, $lecturerid); // Submit the quiz after removing the question.
            return ["success" => true, "message" => "Question was deletes"];
        } catch (dml_exception $e) {
            debugging('Error deleting question: ' . $e->getMessage());
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
    /**
     * Part of the webservice processing flow. Not called directly here,
     * but is in moodle's web service framework.
     * @return external_single_structure
     */
    public static function execute_returns(): external_single_structure {
        return new external_single_structure([
            'success' => new external_value(PARAM_BOOL, 'success'),
            'message' => new external_value(PARAM_TEXT, 'message'),
        ]);
    }
}
