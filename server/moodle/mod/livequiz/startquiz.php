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

/**
 * This displays when attempting a quiz.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

global $PAGE, $OUTPUT;

// Get submitted parameters.
$id = required_param('cmid', PARAM_INT); // Course module id.
$forcenew = optional_param('forcenew', false, PARAM_BOOL); // Used to force a new preview.
$page = optional_param('page', -1, PARAM_INT); // Page to jump to in the attempt.
[$course, $cm] = get_course_and_cm_from_cmid($id, 'livequiz');

$context = context_module::instance($cm->id); // Set the context for the course module.
$PAGE->set_context($context); // Make sure to set the page context.
require_login($course, false, $cm);


//$PAGE->set_url('/mod/livequiz/startquiz.php', ['id' => $id]);
$PAGE->set_heading($course->fullname);

$jsonobject = file_get_contents("demodata.json");
$jsondata = json_decode($jsonobject, true);

/*
 *  temp console log to check if data is fetched
 */
echo '<script>';
echo 'console.log(1: ' . $jsondata['name'] . ');';
echo 'console.log(2: ' . $jsonobject . ');';
echo '</script>';

echo $OUTPUT->header();
echo $OUTPUT->heading('This is the livequiz startquiz page');

//TODO: change if else chain
if ($jsondata === null) {
    echo $OUTPUT->heading('den er helt gal');
}
else {
    echo $OUTPUT->heading($jsondata);
}
echo $OUTPUT->footer();
