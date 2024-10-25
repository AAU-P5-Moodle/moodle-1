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

require_once('../../../config.php');
require_once('../form/createquizform.php');
require_once('../hub/NavBar.php');

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
    $navbar = new createNavbar($activetab);
    $navbar->display();
} else {
    echo $OUTPUT->notification(get_string('navbarclassmissing', 'mod_livequiz'), 'notifyproblem');
}

// Initialize the form.
$mform = new createquizform();

// Display the form.
$mform->display();

// Additional buttons and image upload section.
echo html_writer::start_div('quiz_modal_buttons');

echo html_writer::start_div('image_upload_container');
echo html_writer::div('<img id="imagePreview" src="#" alt="' . get_string('imagepreview', 'mod_livequiz') . '" />', 'imagePreviewContainer');
echo html_writer::tag('label', get_string('addimage', 'mod_livequiz'), ['for' => 'imageUpload', 'class' => 'custom-file-upload']);
echo html_writer::empty_tag('input', ['type' => 'file', 'id' => 'imageUpload', 'name' => 'quizImage', 'accept' => 'image/png']);
echo html_writer::end_div();

// Add the Save and Cancel buttons.
echo html_writer::tag('button', get_string('savequiz', 'mod_livequiz'), ['id' => 'saveQuiz', 'class' => 'save_button']);
echo html_writer::tag('button', get_string('cancelquiz', 'mod_livequiz'), ['id' => 'cancelQuiz', 'class' => 'cancel_button']);
echo html_writer::end_div();

// Include custom JavaScript for the page.
$PAGE->requires->js(new moodle_url('/mod/livequiz/amd/src/quizcreator.js'));

// Output page footer.
echo $OUTPUT->footer();
