<?php
require_once('../../../config.php');
require_once('../hub/NavBar.php');

require_login();

$PAGE->set_url(new moodle_url('/mod/livequiz/quizstats.php'));

$PAGE->requires->css(new moodle_url('/mod/livequiz/styles.css'));

$PAGE->set_context(context_system::instance());
$PAGE->set_title("View quiz statistics");
$PAGE->set_heading("Statistics");

echo $OUTPUT->header();

<<<<<<< HEAD
if (class_exists('createNavbar')) {
    $Navbar = new createNavbar(); // Create an instance of the Navbar class
    $Navbar->display($activeTab); // Call the display method with the active tab
} else {
    // Handle the error if the class does not exist
    echo "Navbar class does not exist.";
}

//query to get the questions for the given quiz.
$sql_questions = " "; // insert sql query for geting the questions for the given quiz inside " ".
$params = ['quizid' => $quizid];
$questins = $DB->get_records_sql($spl_questions, $params);
=======
// example data.
$questionData = [
    [10, 20, 30, 40],
    [15, 5, 25],
    [22, 13],
    [18, 12, 20, 10, 5]
];
>>>>>>> parent of 156aeba6 (added sql querie setup for retrieveing quiz, questions, answer options and student responses for the quiz statistics pages (still needs the actual query questions))



// imports moodles own charting liberay.
use core\chart_bar;
use core\chart_series;

foreach ($questionData as $index => $questionAnswers) {
    // Create a new bar chart for each question.
    $chart = new chart_bar();
    $chart->set_title('Question ' . ($index + 1) . ' Performance');

    // Generate labels for the number of options (need to be changed to include answer and not just option x).
    $labels = [];
    for ($i = 1; $i <= count($questionAnswers); $i++) {
        $labels[] = "Option " . $i;
    }

    $chart->set_labels($labels);

    // Add the data series for the number of users who chose each option.
    $answerSeries = new chart_series('Responses', $questionAnswers);
    $chart->add_series($answerSeries);

    // Display each chart.
    echo '<div style="width:100%;">';
    echo '<div class="quiz-stats-chart" style="width:70%; margin:auto;">';
    echo $OUTPUT->render($chart);
    echo '</div><br>';
}




// Vis formularen

echo $OUTPUT->footer();