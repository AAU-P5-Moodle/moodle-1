<?php
require_once('../../../config.php');
require_once('../form/createquizform.php');
require_login();

$PAGE->set_url(new moodle_url('/mod/livequiz/quizcreator'));

$PAGE->requires->css(new moodle_url('/mod/livequiz/quizcreator/styles.css'));

$PAGE->set_context(context_system::instance());
$PAGE->set_title("Make a quiz");
$PAGE->set_heading("Create a quiz");

echo $OUTPUT->header();

// Opret formular
$mform = new createquizform();



// Vis formularen
$mform->display();

echo '<div class="quiz_modal_buttons">';
echo '<label for="imageUpload">Upload Image:</label>';
echo '<input type="file" id="imageUpload" name="quizImage" accept="image/png" />';
echo '<button id="uploadImage" class="save_button">Upload</button>';
echo '<button id="saveQuiz" class="save_button">Save</button>';
echo '<button id="cancelQuiz" class="discard_question_button">Cancel</button>';
echo '</div>';
$PAGE->requires->js_call_amd('mod_livequiz/quizcreator', 'init');
echo $OUTPUT->footer();
