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
$id = required_param('id', PARAM_INT); // Course module id.
$questionid = optional_param('questionid', 0, PARAM_INT); // Question id, default to 0 if not provided.
[$course, $cm] = get_course_and_cm_from_cmid($id, 'livequiz');


if (!$cm) {
    throw new moodle_exception('invalidcoursemodule', 'error');
}
if ($cm->course !== $course->id) {
    throw new moodle_exception('coursemismatch', 'error', '', null, 'The course module does not match the course');
}

// $instance = $DB->get_record('livequiz', ['id' => $cm->instance], '*', MUST_EXIST);
require_login($course, false, $cm);
// $page = optional_param('page', -1, PARAM_INT); // Page to jump to in the attempt.
$PAGE->set_cacheable(false);

session_start();

if ($_SESSION['completed']) {
    $text = 'You are not allowed to go back after submitting the quiz';
    echo $text;
    die();
}



$context = context_module::instance($cm->id);

$PAGE->set_context($context); // Make sure to set the page context.

$PAGE->set_url(new moodle_url('/mod/livequiz/attempt.php', ['id' => $id, 'questionid' => $questionid]));
$PAGE->set_title(get_string('modulename', 'mod_livequiz'));
$PAGE->set_heading(get_string('modulename', 'mod_livequiz'));

// Read demo data.
$demodatareader = new \mod_livequiz\readdemodata();
$demoquiz = $demodatareader->getdemodata();

// Rendering.
$output = $PAGE->get_renderer('mod_livequiz');
$takelivequiz = new \mod_livequiz\output\take_livequiz_page($id, $demoquiz, $questionid);

// $forcenew = optional_param('forcenew', false, PARAM_BOOL); // Used to force a new preview.

echo $OUTPUT->header();
echo $output->render($takelivequiz);
echo $OUTPUT->footer();
