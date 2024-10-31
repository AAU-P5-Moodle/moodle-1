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
 * Retrieves required parameters, validates user authentication,
 * and saves quiz questions to the database.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');

global $DB;



// Get course ID from parameters.
$id = required_param('id', PARAM_INT);

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputdata = file_get_contents("php://input");
    $data = json_decode($inputdata);

    if ($data && !empty($data->questions)) {
        $quizdata = new stdClass();
        $quizdata->id = $data->id;
        $quizdata->name = $data->name;
        $quizdata->intro = $data->intro;
        $quizdata->introformat = FORMAT_HTML; // Assuming its HTML, change if I am wrong.
        $quizdata->timemodified = $data->timemodified;
        $quizdata->timecreated = $data->timecreated;

        try {
            $quizid = $DB->insert_record('livequiz', $quizdata);

            foreach ($data->questions as $question) {
                $questiondata = new stdClass();
                $questiondata->id = $quizid; // Links question to the quiz.
                $questiondata->title = $question->title;
                $questiondata->description = $question->description;
                $questiondata->timelimit = $question->timelimit ?? 0;
                $questiondata->explanation = $question->explanation ?? null;

                $questionid = $DB->insert_record('livequiz_questions', $questiondata);

                foreach ($question->answers as $answer) {
                    $answerdata = new stdClass();
                    $answerdata->id = $questionid; // Links answer to question.
                    $answerdata->correct = $answer->correct;
                    $answerdata->description = $answer->description;
                    $answerdata->explanation = $answer->explanation ?? null;

                    $DB->insert_record('livequiz_answers', $answerdata);
                }
            }
            echo json_encode(['status' => 'success', 'message' => 'Quiz saved succesfully.']);
        } catch (exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save quiz: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format or missing questions']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
