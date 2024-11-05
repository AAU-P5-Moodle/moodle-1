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

$q1 = new question("title", 'descr', 1, "fordi du er en bøv");
$q1->add_answer(new answer(1, "svar1", "forklaring1"));
$q1->add_answer(new answer(0, "svar2", "forklaring2"));

$q2 = new question("title2", 'descr2', 31, "fordi du er en mega bøv");
$q2->add_answer(new answer(1, "svar1", "forklaring1"));
$q2->add_answer(new answer(0, "svar2", "forklaring2"));

$testquiz->add_question($q1);
$testquiz->add_question($q2);

$livequizservice->submit_quiz($testquiz);

$questions = $testquiz->get_questions();


echo $OUTPUT->header();
echo $OUTPUT->heading('Fuck diiiig page2');
echo "<p><strong>Number of questions:</strong> " . count($questions) . "</p>";

echo $OUTPUT->footer();
