<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Handles saving of quizzes for the Live Quiz module.
 *
 * @package    mod_livequiz
 * @copyright  2024 Software AAU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/livequiz/classes/services/livequiz_services.php');
require_once($CFG->dirroot . '/mod/livequiz/classes/models/livequiz.php');

use mod_livequiz\services\livequiz_services;
use mod_livequiz\models\livequiz;
use mod_livequiz\models\question;
use mod_livequiz\models\answer;

global $DB;

// Get course ID from parameters.
$id = required_param('id', PARAM_INT); // Course module ID.
[$course, $cm] = get_course_and_cm_from_cmid($id, 'livequiz');

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputdata = file_get_contents("php://input");
    $data = json_decode($inputdata);
    // Check if the data is valid and contains required properties.
    if ($data && isset($data->name, $data->questions) && !empty($data->questions)) {
        try {
            $livequizservice = livequiz_services::get_singleton_service_instance();
            $livequiz = $livequizservice->get_livequiz_instance($cm->instance);
            $livequiz->set_name($data->name);
            $livequiz->set_intro($data->intro);
            $livequiz->set_introformat($data->introformat);
            $questionsarray = [];
            // Add questions and their answers to the livequiz object.
            foreach ($data->questions as $question) {
                    $newquestion = new question($question->title, $question->description, $question->timelimit, $question->explanation);
                    $answersarray = [];
                foreach ($question->answers as $answer) {
                    $newanswer = new answer($answer->correct, $answer->description, $answer->explanation);
                    array_push($answersarray, $newanswer);
                }
                    $newquestion->add_answers($answersarray);
                    array_push($questionsarray, $newquestion);
            }
            $livequiz->set_questions($questionsarray);
            // Submit the quiz using the service.
            $livequizservice->submit_quiz($livequiz, 0);// Todo get lector id somehow.

            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'message' => 'Quiz saved successfully.',
                'quiz_id' => $livequiz->get_id(),
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to save quiz: ' . $e->getMessage(),
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid data format or missing questions',
        ]);
    }
} else {
    http_response_code(405); // Method Not Allowed.
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method',
    ]);
}
