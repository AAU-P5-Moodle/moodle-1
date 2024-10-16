<?php
require_once('../../../config.php');
require_once('../form/createquizform.php');
require_once('../hub/NavBar.php');
require_login();

$PAGE->set_url(new moodle_url('/mod/livequiz/quizcreator'));
 
$PAGE->requires->css(new moodle_url('/mod/livequiz/quizcreator/CreatorStyles.css'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title("Make a quiz");
$PAGE->set_heading("Create a quiz");

echo $OUTPUT->header();

if (class_exists('createNavbar')) {
    $Navbar = new createNavbar(); // Create an instance of the Navbar class
    $Navbar->display($activeTab); // Call the display method with the active tab
} else {
    // Handle the error if the class does not exist
    echo "Navbar class does not exist.";
}


// Opret formular
$mform = new createquizform();



// Vis formularen
$mform->display();
$PAGE->requires->js(new moodle_url('../amd/src/quizcreator.js'));
echo $OUTPUT->footer();
