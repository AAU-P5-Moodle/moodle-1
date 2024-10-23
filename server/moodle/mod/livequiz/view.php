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

/**
 * Displays the livequiz view page.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//TODO Delete
use mod_livequiz\livequiz\livequiz;
use mod_livequiz\question\question;

global $OUTPUT, $PAGE, $DB, $CFG;

require_once('../../config.php');
require_once($CFG->libdir . '/accesslib.php'); // Include the access library for context_module.

$id = required_param('id', PARAM_INT); // Course module ID.
[$course, $cm] = get_course_and_cm_from_cmid($id, 'livequiz');
$instance = $DB->get_record('livequiz', ['id' => $cm->instance], '*', MUST_EXIST);

require_login($course, true, $cm); // Ensure the user is logged in and can access this module.
$context = context_module::instance($cm->id); // Set the context for the course module.
$PAGE->set_context($context); // Make sure to set the page context.

$PAGE->set_url('/mod/livequiz/view.php', ['id' => $id]);
$PAGE->set_title(get_string('modulename', 'mod_livequiz'));
$PAGE->set_heading(get_string('modulename', 'mod_livequiz'));


echo $OUTPUT->header();

// TODO Delete
//try {
//    $test_question = new \stdClass();
//    $test_question->title = 'What is the capital of Denmark?';
//    $test_question->description = 'Copenhagen';
//    $test_question->timelimit = 1;
//    $test_question->explanation = 'Copenhagen is the capital of Denmark.';
//
//    $test_questions = [];
//
//    //construct 3 questions
//    $test_questions[] = clone $test_question;
//    $test_questions[] = clone $test_question;
//    $test_questions[] = clone $test_question;
//
//    livequiz::append_questions_to_quiz($test_questions, $instance->id);
    $test_quiz = livequiz::get_livequiz_instance($instance->id);
//} catch (dml_exception $e) {
//    echo $e->getMessage();
//}

// Check if $test_quiz is an object and then display its properties
echo "<h2>Instance ID: {$instance->id}</h2>";

if (true) {

    echo "<h2>Live Quiz Details</h2>";
    echo "<p><strong>ID:</strong> $test_quiz->id</p>";
    echo "<p><strong>Name:</strong> {$test_quiz->name}</p>";
    echo "<p><strong>Course ID:</strong> {$test_quiz->course}</p>";
    echo "<p><strong>Introduction:</strong> {$test_quiz->intro}</p>";
    echo "<p><strong>Time Created:</strong> " . userdate($test_quiz->timecreated) . "</p>";
    echo "<p><strong>Last Modified:</strong> " . userdate($test_quiz->timemodified) . "</p>";
    echo "<p><strong>Questions:</strong>" . print_r($test_quiz->questions) . "</p>";
} else {
    echo "<p>No quiz found.</p>";
}

echo $OUTPUT->footer();
