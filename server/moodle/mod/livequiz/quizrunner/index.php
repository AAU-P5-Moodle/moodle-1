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
 * Displays the livequiz quizrunner page.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');

require_once('question.php');
require_once('answer/slider.php');
require_once('answer/multichoice.php');
require_once('../hub/NavBar.php');

$PAGE->set_url(new moodle_url('/mod/livequiz/quizrunner'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title("Play quiz");
$PAGE->set_heading("Join a quiz");
$PAGE->requires->css(new moodle_url('/mod/livequiz/quizrunner/RunnerStyles.css'));

echo $OUTPUT->header();

if (class_exists('createNavbar')) {
    $navbar = new createNavbar(); // Create an instance of the Navbar class.
    $navbar->display($activetab); // Call the display method with the active tab.
} else {
    // Handle the error if the class does not exist.
    echo "Navbar class does not exist.";
}


$question = new question(
    'fish.png', 
    'Is fish fishing????', 
    new multichoice(
        [
            new multichoice_choice("Yes!!!!", "yes"),
            new multichoice_choice("No!!!!!", "no"),
            new multichoice_choice("Mayhaps...", "maybe"),
        ]
    )
);


$question->display();

// Your contents here (html etc.).
echo $OUTPUT->footer();
