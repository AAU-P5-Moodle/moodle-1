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

require_once('../../config.php');
require_once($CFG->libdir . '/accesslib.php'); // Include the access library for context_module.

use mod_livequiz\output\index_page_student;
use mod_livequiz\output\index_page_teacher;
use mod_livequiz\services\livequiz_services;

global $OUTPUT, $PAGE, $DB, $USER;

$cmid = required_param('id', PARAM_INT); // Course module ID. (the param has to be named "id" as moodle will send id and not cmid).
[$course, $cm] = get_course_and_cm_from_cmid($cmid, 'livequiz');
$instance = $DB->get_record('livequiz', ['id' => $cm->instance], '*', MUST_EXIST);

require_login($course, true, $cm); // Ensure the user is logged in and can access this module.
// Debugging: Check if $USER is defined and contains the id.
if (!isset($USER->id)) {
    throw new moodle_exception('usernotauthenticated', 'error', '', null, 'User is not logged in or user data is missing.');
}

$context = context_module::instance($cm->id); // Set the context for the course module.
$PAGE->set_cacheable(false);
$PAGE->set_context($context); // Make sure to set the page context.
$PAGE->requires->css('/mod/livequiz/style.css'); // Adds styling to the page.

$PAGE->set_url(new moodle_url('/mod/livequiz/view.php', ['id' => $cmid]));
$PAGE->set_title(get_string('modulename', 'mod_livequiz'));
$PAGE->set_heading(get_string('modulename', 'mod_livequiz'));

// Rendering.
$output = "";
$renderer = $PAGE->get_renderer('mod_livequiz');
// Checks if the user has edit privileges. If they do they are a teacher and the teacher page is rendered.
if (has_capability('moodle/course:manageactivities', $context)) {
    // Don't save the student_answers_relation and student_quiz_relation for the teacher.
    // Otherwise, they won't be able to edit questions after taking their own quiz.
    $livequizservice = livequiz_services::get_singleton_service_instance();
    $livequizservice->delete_student_participations_and_answers_by_quizid_and_studentid($instance->id, $USER->id);
    $renderable = new index_page_teacher($instance->id, $USER->id, $cmid);
    $output = $renderer->render_index_page_teacher($renderable);
} else { // User does not have edit capabilities.
    $renderable = new index_page_student($cmid, $instance->id, $USER->id);
    $output = $renderer->render_index_page_student($renderable);
}

unset($_SESSION['completed']);

echo $OUTPUT->header();
echo $output;
echo $OUTPUT->footer();
