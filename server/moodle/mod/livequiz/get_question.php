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

require_once('../../../../config.php');

$questionId = required_param('id', PARAM_INT);
$quizid = optional_param('quizid', 0, PARAM_INT); // Optional if needed for validation.

require_login();
global $DB;

// Fetch the question from the database.
$question = $DB->get_record('livequiz_questions', ['id' => $questionId], '*', MUST_EXIST);

// Validate the quiz ID if provided.
if ($quizid && $question->quizid !== $quizid) {
    throw new moodle_exception('invalidquizid', 'mod_livequiz');
}

// Fetch associated answers.
$answers = $DB->get_records('livequiz_answers', ['questionid' => $questionId]);

// Prepare the response data.
$response = [
    'question' => $question,
    'answers' => array_values($answers),
];

// Return the response as JSON.
header('Content-Type: application/json');
echo json_encode($response);
