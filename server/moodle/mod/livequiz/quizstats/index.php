<?php
// This file is part of Moodle - http://moodle.org/.
//
// Moodle is free software: you can redistribute it and/or modify.
// it under the terms of the GNU General Public License as published by.
// the Free Software Foundation, either version 3 of the License, or.
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
 * Displays the livequiz quizstats page.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_once('../hub/NavBar.php');

require_login();

$PAGE->set_url(new moodle_url('/mod/livequiz/quizstats.php'));

$PAGE->set_url(new moodle_url('/mod/livequiz/quizstats.php'));

$PAGE->requires->css(new moodle_url('/mod/livequiz/hub/navbar_style.css'));


$PAGE->set_context(context_system::instance());
$PAGE->set_title("View quiz statistics");
$PAGE->set_heading("Statistics");

echo $OUTPUT->header();

if (class_exists('createNavbar')) {
    $navbar = new createNavbar(); // Create an instance of the Navbar class.
    $navbar->display($activetab); // Call the display method with the active tab.
} else {
    // Handle the error if the class does not exist.
    echo "Navbar class does not exist.";
}


$questiondata = [
    [10, 20, 30, 40],
    [15, 5, 25],
    [22, 13],
    [18, 12, 20, 10, 5],
];


// Imports moodles own charting liberay.
use core\chart_bar;
use core\chart_series;

foreach ($questiondata as $index => $questionanswers) {
    // Create a new bar chart for each question.
    $chart = new chart_bar();
    $chart->set_title('Question ' . ($index + 1) . ' Performance');

    // Generate labels for the number of options (need to be changed to include answer and not just option x).
    $labels = [];
    for ($i = 1; $i <= count($questionanswers); $i++) {
        $labels[] = "Option " . $i;
    }

    $chart->set_labels($labels);

    // Add the data series for the number of users who chose each option.
    $answerseries = new chart_series('Responses', $questionanswers);
    $chart->add_series($answerseries);

    // Display each chart.
    echo '<div style="width:100%;">';
    echo '<div class="quiz-stats-chart" style="width:70%; margin:auto;">';
    echo $OUTPUT->render($chart);
    echo '</div><br>';
}




// Shows formula.

echo $OUTPUT->footer();
