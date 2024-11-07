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

require_once('../../../config.php');
require_once($CFG->dirroot . '/mod/livequiz/classes/services/livequiz_services.php');
require_once($CFG->dirroot . '/mod/livequiz/classes/models/livequiz.php');

use mod_livequiz\services\livequiz_services;
use mod_livequiz\models\livequiz;

global $DB;

// Get course ID from parameters.
$id = required_param('id', PARAM_INT);

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputdata = file_get_contents("php://input");
    $data = json_decode($inputdata);

    // Check if the data is valid and contains required properties.
    if ($data && isset($data->name, $data->questions) && !empty($data->questions)) {
        try {
            // Create a new livequiz instance.
            $livequiz = livequiz::create_instance(
                $data->name ?? 'Untitled Quiz', // Name of the quiz.
                $id, // Course ID from the request parameter.
                $data->intro ?? '', // Introduction text.
                FORMAT_HTML, // Intro format (assuming HTML).
                time(), // Time created (current timestamp).
                time() // Time modified (current timestamp).
            );

            // Add questions and their answers to the livequiz object.
            foreach ($data->questions as $question) {
                if (isset($question->title, $question->answers) && !empty($question->answers)) {
                    $questionobj = livequiz_services::get_singleton_service_instance()->new_question(
                        $livequiz,
                        $question->title,
                        $question->description ?? '',
                        $question->timelimit ?? 0,
                        $question->explanation ?? ''
                    );

                    foreach ($question->answers as $answer) {
                        if (isset($answer->description, $answer->correct)) {
                            livequiz_services::get_singleton_service_instance()->new_answer(
                                $questionobj,
                                $answer->correct ? 1 : 0,
                                $answer->description,
                                $answer->explanation ?? ''
                            );
                        } else {
                            throw new Exception('Invalid answer format: missing required fields.');
                        }
                    }
                } else {
                    throw new Exception('Invalid question format: missing title or answers.');
                }
            }

            // Submit the quiz using the service.
            $submittedquiz = livequiz_services::get_singleton_service_instance()->submit_quiz($livequiz);

            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'message' => 'Quiz saved successfully.',
                'quiz_id' => $submittedquiz->get_id(),
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
