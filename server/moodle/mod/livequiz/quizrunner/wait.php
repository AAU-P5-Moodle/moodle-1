<?php
require_once('../../../config.php');
$PAGE->set_url(new moodle_url('/mod/livequiz/quizrunner'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title("Play quiz");
$PAGE->set_heading("Join a quiz");



echo $OUTPUT->header();
?> 

<h2>Please Wait!</h2>

<?php
echo "Your answer was '" . $_POST["answer"] . "'";
echo $OUTPUT->footer();
