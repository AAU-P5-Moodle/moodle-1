<?php
require_once('../../../config.php');

require_login();

$PAGE->set_url(new moodle_url('/mod/livequiz/quizstats.php'));

$PAGE->requires->css(new moodle_url('/mod/livequiz/styles.css'));

$PAGE->set_context(context_system::instance());
$PAGE->set_title("View quiz statistics");
$PAGE->set_heading("Statistics");

echo $OUTPUT->header();

// Display the statistics chart
echo '<div style="width:100%;">';
echo '<div class="quiz-stats-chart" style="width:30%; margin:auto;">';
echo '<h2>Quiz Performance Overview</h2>';
echo '<img src="https://via.placeholder.com/600x400?text=Demo+Chart+1" alt="Demo Chart 1">';
echo '<br>';
echo '<img src="https://via.placeholder.com/600x400?text=Demo+Chart+2" alt="Demo Chart 2">';
echo '<br>';
echo '<img src="https://via.placeholder.com/600x400?text=Demo+Chart+3" alt="Demo Chart 3">';
echo '<br>';
echo '<img src="https://via.placeholder.com/600x400?text=Demo+Chart+4" alt="Demo Chart 4">';
echo '<br>';
echo '</div>';




// Vis formularen

echo $OUTPUT->footer();