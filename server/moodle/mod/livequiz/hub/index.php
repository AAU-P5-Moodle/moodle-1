<?php
require_once('../../../config.php');
require_login();

$PAGE->set_url(new moodle_url('/mod/livequiz/hub/'));



$PAGE->set_context(context_system::instance());
$PAGE->set_title("livequiz Hub");
$PAGE->set_heading("Livequiz Page Selector");

echo $OUTPUT->header();



echo "<p href= 'http://localhost/mod/livequiz/quizcreator/' title='Creator'>Creator</p>";
echo "<p href= 'http://localhost/mod/livequiz/quizrunner/' title='Runner'>Runner</p>";
echo "<p href= 'http://localhost/mod/livequiz/quizstats' title='Stats'>Stats</p>";



echo $OUTPUT->footer();

?>
