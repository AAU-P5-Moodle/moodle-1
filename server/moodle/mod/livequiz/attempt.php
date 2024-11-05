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
 * This displays when attempting a quiz.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir . '/accesslib.php');
require_once('readdemodata.php');

use mod_livequiz\services\livequiz_services;

global $PAGE, $OUTPUT, $testdataset;

// Get submitted parameters.
$cmid = required_param('cmid', PARAM_INT); // Course module id.
$questionid = optional_param('questionid', 0, PARAM_INT); // Question id, default to 0 if not provided.
[$course, $cm] = get_course_and_cm_from_cmid($cmid, 'livequiz');
$instance = $DB->get_record('livequiz', ['id' => $cm->instance], '*', MUST_EXIST);

// Read demo data - REMOVE WHEN PUSHING TO STAGING.
$livequizservice = livequiz_services::get_singleton_service_instance();
$currentquiz = $livequizservice->get_livequiz_instance($instance->id);
if (empty($currentquiz->get_questions())) {
    $demodatareader = new \mod_livequiz\readdemodata();
    $demoquiz = $demodatareader->insertdemodata($currentquiz);
} else {
    $demoquiz = $currentquiz;
}

// Insert demo data if the site is running in behat mode.
if (defined('BEHAT_SITE_RUNNING') && BEHAT_SITE_RUNNING) {
    $demodatareader = new \mod_livequiz\readdemodata();
    $demoquiz = $demodatareader->insertdemodata($currentquiz);
}

/*
// Params for storage in session.
$nextquestionid = optional_param('nextquestionid', 0, PARAM_INT);
$quizid = optional_param('quizid', 0, PARAM_INT);
$numberofquestions = optional_param('numberofquestions', 0, PARAM_INT);
$questiontitle = optional_param('questiontitle', 0, PARAM_TEXT);
*/
if (!$cm) { // If course module is not set, throw an exception.
    throw new moodle_exception('invalidcoursemodule', 'error');
}
if ($cm->course !== $course->id) { // Check if the course module matches the course.
    throw new moodle_exception('coursemismatch', 'error', '', null, 'The course module does not match the course');
}

require_login($course, false, $cm);
$PAGE->set_cacheable(false);

if (!isset($_SESSION['completed'])) { // If the session variable is not set, set it to false.
    $_SESSION['completed'] = false;
}
if ($_SESSION['completed']) { // If the quiz has been submitted, the user is not allowed to go back.
    $text = 'You are not allowed to go back after submitting the quiz';
    echo $text;
    die();
}

echo "<pre>";
print_r($_SESSION['quiz_answers']);
echo "</pre>";

$context = context_module::instance($cmid); // Get the context.

$PAGE->set_context($context); // Make sure to set the page context.

/*
if ($quizid) { // If quizid is set, answers have been stored for the question, thus next question is to be displayed.
    $PAGE->set_url(new moodle_url('/mod/livequiz/attempt.php', ['cmid' => $cmid, 'questionid' => $nextquestionid]));
} else { // If quizid is not set, the current question is to be displayed.
    $PAGE->set_url(new moodle_url('/mod/livequiz/attempt.php', ['cmid' => $cmid, 'questionid' => $questionid]));
}
*/
$PAGE->set_url(new moodle_url('/mod/livequiz/attempt.php', ['cmid' => $cmid, 'questionid' => $questionid]));


$PAGE->set_title(get_string('modulename', 'mod_livequiz'));
$PAGE->set_heading(get_string('modulename', 'mod_livequiz'));


// Rendering.
$output = $PAGE->get_renderer('mod_livequiz');
$takelivequiz = new \mod_livequiz\output\take_livequiz_page($cmid, $demoquiz, $questionid);

// Output.
echo $OUTPUT->header();
echo $output->render($takelivequiz); // Render the page.
echo $OUTPUT->footer();
