<?php
// This file is part of Moodle - http://moodle.org/.
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
 * Quiz creator page for the livequiz module.
 *
 * This page provides a form for creating and customizing quizzes in the livequiz module.
 *
 * @package    mod_livequiz
 * @copyright  2024 Software AAU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Include necessary files.
require_once('../../../config.php');
require_once('../form/createquizform.php');
require_once('../hub/NavBar.php');

$id = required_param('id', PARAM_INT); // Course module ID.
[$course, $cm] = get_course_and_cm_from_cmid($id, 'livequiz');

// Require user to be logged in.
require_login();

// Set up the page.
$PAGE->set_url(new moodle_url('/mod/livequiz/quizcreator'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('createquiz', 'mod_livequiz'));
$PAGE->set_heading(get_string('createquiz', 'mod_livequiz'));
$PAGE->requires->css(new moodle_url('/mod/livequiz/quizcreator/CreatorStyles.css'));

// Output page header.
echo $OUTPUT->header();

// Display the navigation bar if the class exists.
if (class_exists('createNavbar')) {
    $activetab = 'quizcreator'; // Define the active tab.
    $navbar = new createNavbar();
    $navbar->display();
} else {
    echo $OUTPUT->notification(get_string('navbarclassmissing', 'mod_livequiz'), 'notifyproblem');
}

// Initialize the form.
$mform = new createquizform();
global $DB;

try {
    $quizdata = $DB->get_record('livequiz', ['id' => $cm->instance], '*', MUST_EXIST);
    $mform->set_data(['existingquizzes' => $quizdata]);
} catch (Exception $e) {
    echo $OUTPUT->notification('Failed to retrieve quiz data: ' . $e->getMessage(), 'notifyproblem');
}

// Generate HTML for form and saved questions.
$formhtml = $mform->render();  // Assuming you render the form here.
$savedquestionshtml = '';    // Add logic to render saved questions if any.
$filepickerhtml = '';        // You may generate the HTML for file picker here.

// Create and render the page.
$quizcreator = new \mod_livequiz\output\quizcreator_renderable($quizdata, $formhtml, $savedquestionshtml, $filepickerhtml);
echo $OUTPUT->render($quizcreator);

// Output page footer.
echo $OUTPUT->footer();
