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

use mod_livequiz\services\livequiz_services;
use mod_livequiz\models\livequiz;
use mod_livequiz\models\question;
use mod_livequiz\models\answer;

require_once('../../config.php');
require_once($CFG->libdir . '/accesslib.php'); // Include the access library for context_module.

global $OUTPUT, $PAGE, $DB;


$id = required_param('id', PARAM_INT); // Course module ID.
[$course, $cm] = get_course_and_cm_from_cmid($id, 'livequiz');
$instance = $DB->get_record('livequiz', ['id' => $cm->instance], '*', MUST_EXIST);

require_login($course, true, $cm); // Ensure the user is logged in and can access this module.
$context = context_module::instance($cm->id); // Set the context for the course module.
$PAGE->set_context($context); // Make sure to set the page context.

$PAGE->set_url('/mod/livequiz/view.php', ['id' => $id]);
$PAGE->set_title(get_string('modulename', 'mod_livequiz'));
$PAGE->set_heading(get_string('modulename', 'mod_livequiz'));

$livequizservice = livequiz_services::get_singleton_service_instance();

$testquiz = $livequizservice->get_livequiz_instance($instance->id);

$questions = $testquiz->get_questions();

$questions[0]->set_title("new title");
$questions[0]->set_description("new descr");
$questions[0]->set_timelimit(1);
$questions[0]->set_explanation("fordi du er en bøv");

$questions[1]->set_title("new title2");
$questions[1]->set_description("new descr2");
$questions[1]->set_timelimit(31);
$questions[1]->set_explanation("fordi du er en mega bøv");

$q0answers = $questions[0]->get_answers();
$q1answers = $questions[1]->get_answers();

$q0answers[0]->set_description("nyt svar1");
$q0answers[0]->set_explanation("ny forklaring1");

$q0answers[1]->set_description("nyt svar2");
$q0answers[1]->set_explanation("ny forklaring2");

$ret = $livequizservice->submit_quiz($testquiz);

$questions = $testquiz->get_questions();


echo $OUTPUT->header();
echo $OUTPUT->heading('View.php page');
echo "<p><strong>Quiz title:</strong> " . print_r($testquiz->get_questions()[0]->get_answers()[0]) . "</p>";

echo "<p><strong>Number of questions:</strong> " . count($questions) . "</p>";

echo $OUTPUT->footer();
