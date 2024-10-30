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

global $PAGE, $OUTPUT;

// Get submitted parameters.
$cmid = required_param('cmid', PARAM_INT); // Course module id.
$questionid = optional_param('questionid', 0, PARAM_INT); // Question id, default to 0 if not provided.
[$course, $cm] = get_course_and_cm_from_cmid($cmid, 'livequiz');

$nextquestionid = optional_param('nextquestionid', 0, PARAM_INT);
$quizid = optional_param('quizid', 0, PARAM_INT);
$numberofquestions = optional_param('numberofquestions', 0, PARAM_INT);
$questiontitle = optional_param('questiontitle', 0, PARAM_TEXT);
$answers = optional_param_array('answers_for_question_' . $questionid, [], PARAM_INT);

session_start();
if ($quizid !== 0) {
    if (!isset($_SESSION['quiz_answers'])) {
        $_SESSION['quiz_answers'] = [];
    }
    $_SESSION['quiz_answers'][$questionid] = [
        'question_id' => $questionid,
        'answers' => $answers,
    ];
}

if (!$cm) {
    throw new moodle_exception('invalidcoursemodule', 'error');
}
if ($cm->course !== $course->id) {
    throw new moodle_exception('coursemismatch', 'error', '', null, 'The course module does not match the course');
}

// $instance = $DB->get_record('livequiz', ['id' => $cm->instance], '*', MUST_EXIST);
require_login($course, false, $cm);
// $page = optional_param('page', -1, PARAM_INT); // Page to jump to in the attempt.

$context = context_module::instance($cmid);

$PAGE->set_context($context); // Make sure to set the page context.

if ($quizid){
    $PAGE->set_url(new moodle_url('/mod/livequiz/attempt.php', ['cmid' => $cmid, 'questionid' => $nextquestionid]));
}
else {
    $PAGE->set_url(new moodle_url('/mod/livequiz/attempt.php', ['cmid' => $cmid, 'questionid' => $questionid]));
}
$PAGE->set_title(get_string('modulename', 'mod_livequiz'));
$PAGE->set_heading(get_string('modulename', 'mod_livequiz'));

// Read demo data.
$demodatareader = new \mod_livequiz\readdemodata();
$demoquiz = $demodatareader->getdemodata();

// Rendering.
$output = $PAGE->get_renderer('mod_livequiz');
$takelivequiz = new \mod_livequiz\output\take_livequiz_page($cmid, $demoquiz, $questionid);


// $forcenew = optional_param('forcenew', false, PARAM_BOOL); // Used to force a new preview.

echo $OUTPUT->header();
echo $output->render($takelivequiz);
echo $OUTPUT->footer();
