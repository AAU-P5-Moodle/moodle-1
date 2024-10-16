<?php
require_once('../../../config.php');
require_login();

$PAGE->set_url(new moodle_url('/mod/livequiz/hub/'));

$PAGE->requires->css(new moodle_url('/mod/livequiz/hub/styles.css'));


$PAGE->set_context(context_system::instance());
$PAGE->set_title("livequiz Hub");
$PAGE->set_heading("Livequiz Page Selector");

echo $OUTPUT->header();



echo "<p><a href= 'http://localhost/mod/livequiz/quizcreator/' title='Creator'>Creator</a></p>";
echo "<p><a href= 'http://localhost/mod/livequiz/quizrunner/' title='Runner'>Runner</a></p>";
echo "<p><a href= 'http://localhost/mod/livequiz/quizstats' title='Stats'>Stats</a></p>";
echo "<p> Question bank </p>"; //user stories would like this feature



echo $OUTPUT->footer();

?>
