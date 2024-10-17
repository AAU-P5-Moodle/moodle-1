<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

global $OUTPUT, $PAGE, $DB;
require_once('../../config.php');
require_once('hub/NavBar.php');

$id = required_param('id', PARAM_INT); // Course module ID
[$course, $cm] = get_course_and_cm_from_cmid($id, 'livequiz');
$instance = $DB->get_record('livequiz', ['id'=> $cm->instance], '*', MUST_EXIST);
$PAGE->requires->css(new moodle_url('/mod/livequiz/hub/navbar_style.css'));
$PAGE->set_url('/mod/livequiz/view.php', array('id' => $id));
$PAGE->set_title(get_string('modulename', 'mod_livequiz'));
$PAGE->set_heading(get_string('modulename', 'mod_livequiz'));


$activeTab = optional_param('tab', 'normal', PARAM_ALPHA);

echo $OUTPUT->header();

if (class_exists('createNavbar')) {
    // Create an instance of the Navbar class, passing the active tab
    $Navbar = new createNavbar($activeTab);
    $Navbar->display(); // Call the display method
} else {
    echo "Navbar class does not exist.";
}
echo $OUTPUT->footer();