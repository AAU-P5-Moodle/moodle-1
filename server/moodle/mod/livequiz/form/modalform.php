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

// Require user to be logged in.
require_login();

// Set up the page.
$PAGE->set_url(new moodle_url('/mod/livequiz/quizcreator'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('createquiz', 'mod_livequiz'));
$PAGE->set_heading(get_string('createquiz', 'mod_livequiz'));
$PAGE->requires->css(new moodle_url('/mod/livequiz/quizcreator/styles.css'));

// Output page header.
echo $OUTPUT->header();

// Check if the Navbar class exists before using it.
if (class_exists('createNavbar')) {
    $navbar = new createNavbar();
    $activetab = 'createquiz'; // Set the active tab.
    $navbar->display($activetab);
} else {
    echo $OUTPUT->notification(get_string('navbarclassmissing', 'mod_livequiz'), 'notifyproblem');
}

// Initialize the form.
$mform = new createquizform();

// Display the form.
$mform->display();

// Additional buttons and image upload section.
// Start the container div for quiz modal buttons.
echo html_writer::start_div('quiz_modal_buttons');

// Start the container div for image upload.
echo html_writer::start_div('image_upload_container');

// Image preview element.
echo html_writer::div(
    '<img id="imagePreview" src="#" alt="' . get_string('imagepreview', 'mod_livequiz') . '" />',
    'imagePreviewContainer'
);

// Label for the image upload.
echo html_writer::tag(
    'label',
    get_string('addimage', 'mod_livequiz'),
    [
        'for' => 'imageUpload',
        'class' => 'custom-file-upload',
    ]
);

// File input for image upload.
echo html_writer::empty_tag(
    'input',
    [
        'type' => 'file',
        'id' => 'imageUpload',
        'name' => 'quizImage',
        'accept' => 'image/png',
    ]
);

// End the image upload container div.
echo html_writer::end_div();

// Button for saving the quiz.
echo html_writer::tag(
    'button',
    get_string('savequiz', 'mod_livequiz'),
    [
        'id' => 'saveQuiz',
        'class' => 'save_button',
    ]
);

// Button for canceling the quiz.
echo html_writer::tag(
    'button',
    get_string('cancelquiz', 'mod_livequiz'),
    [
        'id' => 'cancelQuiz',
        'class' => 'discard_question_button',
    ]
);

// End the main container div for quiz modal buttons.
echo html_writer::end_div();

// Include custom JavaScript for the page.
$PAGE->requires->js(new moodle_url('/mod/livequiz/amd/src/quizcreator.js'));

// Output page footer.
echo $OUTPUT->footer();
