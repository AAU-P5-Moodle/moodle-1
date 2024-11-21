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

require_login();
global $DB;

$data = json_decode(file_get_contents('php://input'), true);

$quizid = required_param('quizid', PARAM_INT); // Required for associating the question with a quiz.
$questionData = json_decode($data['questiondata'], true);
$answersData = json_decode($data['answersdata'], true);

// Validate quiz context.
$context = context_module::instance($quizid);
require_capability('mod/livequiz:edit', $context);

// Prepare the question object.
$question = (object)[
    'id' => $questionData['id'] ?? null, // Null for new questions.
    'quizid' => $quizid,
    'title' => $questionData['title'],
    'description' => $questionData['description'],
    'timelimit' => $questionData['timelimit'] ?? 0, // Optional.
    'explanation' => $questionData['explanation'] ?? '', // Optional.
];

if (empty($question->id)) {
    $question->id = $DB->insert_record('livequiz_questions', $question);
} else {
    $DB->update_record('livequiz_questions', $question);
}

// Save answers.
foreach ($answersData as $answer) {
    $answer = (object)$answer;
    $answer->questionid = $question->id;

    if (empty($answer->id)) {
        $DB->insert_record('livequiz_answers', $answer);
    } else {
        $DB->update_record('livequiz_answers', $answer);
    }
}

// Return success response.
header('Content-Type: application/json');
echo json_encode(['success' => true]);
