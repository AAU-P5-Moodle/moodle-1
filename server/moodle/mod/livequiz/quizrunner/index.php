<?php

/**
 * EXPLANATION STUFF FOR HOW ALL THIS IS SET UP
 * ============================================
 *
 * We've made a object-oriented representation of the quiz runner.
 * 
 * At the top is an interface `answer` (`answer/answer.php`), which
 * only has the method `html()`, which makes the answer form. We
 * expect it to contain a submit button that goes to `wait.php`. 
 *
 * We're not quite sure how we want to structure the overall flow of
 * the program, so that's something we need to figure out.
 *
 * Then we have the more specific classes, so `slider` 
 * (`answer/slider.php`), and `multichoice` (`answer/multichoice.php`),
 * whose file also contains the `multichoice_choice` class. For an 
 * example on how to initialise there, see the code in this file.
 *
 * A couldhave to-do is to make an image labelling answer class.
 *
 * Best regards,
 * Team Lennart.
 *
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
    $Navbar = new createNavbar(); // Create an instance of the Navbar class
    $Navbar->display($activeTab); // Call the display method with the active tab
} else {
    // Handle the error if the class does not exist
    echo "Navbar class does not exist.";
}


$question = new question();
$question->image = 'fish.png';
$question->prompt = 'Is fish fishing????';
$question->answer = new multichoice(
	array(
		new multichoice_choice("Yes!!!!", "yes"),
		new multichoice_choice("No!!!!!", "no"),
		new multichoice_choice("Mayhaps...", "maybe")
	)
);
//$question->answer = new slider(0, 10);

$question->display();

// Din indholdskode her (HTML eller noget andet indhold).
echo $OUTPUT->footer();
