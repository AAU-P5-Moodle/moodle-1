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
use mod_livequiz\models\livequiz;
use mod_livequiz\services\livequiz_services;

/**
 * Class get_lecturer_quiz
 *
 * This class extends the core_external\external_api and is used to handle
 * the external API for saving questions to a livequiz.
 *
 * @return     external_function_parameters The parameters required for the execute function.
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package    mod_livequiz
 */
class get_lecturer_quiz extends external_api {
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
        $service = livequiz_services::get_singleton_service_instance();
        // Get all quizzes from the lecturer.
        $rawquizzes = $service->get_lecturer_quiz_relations_by_lecturer_id($lecturerid);
        $quizzes = [];
        // Loop through all quizzes from the lecturer and find the corresponding questions.
        foreach ($rawquizzes as $rawquiz) {
            $quizobject = livequiz::get_livequiz_instance($rawquiz->quiz_id);
            if (self::quiz_active($quizobject)) { // Check if the quiz is active/deleted.
                $rawquestions = $service->get_questions_from_quiz_id($rawquiz->quiz_id);
                foreach ($rawquestions as $rawquestion) {
                    $question = $service->get_question_from_id($rawquestion->get_id());
                    $quizobject->add_question($question);
                }
                $preparedquiz = $quizobject->prepare_for_template();
                $quizzes[] = $preparedquiz;
            }
        }
        return $quizzes;
    }
    /**
     */

    /**
     * Part of the webservice processing flow. Not called directly here,
     * but is in moodle's web service framework.
     * @return external_multiple_structure
     */
    public static function execute_returns(): external_multiple_structure {
        return new external_multiple_structure(data_structure_helper::get_quiz_structure(), 'List of quizzes');
    }

    /**
     * Checks if a quiz is active.
     * @param livequiz $quizobject
     * @return bool
     * @throws dml_exception
     */
    private static function quiz_active(livequiz $quizobject): bool {
        global $DB;
        // Get the livequiz instance.
        $quizinstance = $DB->get_record('livequiz', ['id' => $quizobject->get_id()]);
        // Get the course module ID.
        $cmid = $quizinstance->activity_id;
        // Get the course module instance.
        $cminstance = $DB->get_record('course_modules', ['id' => $cmid]);
        if ($cminstance->deletioninprogress == 1) { // Check if the course module is deleted.
            return false; // Return false if the course module is deleted.
        }
        return true; // Return true if the course module is not deleted.
    }
}
