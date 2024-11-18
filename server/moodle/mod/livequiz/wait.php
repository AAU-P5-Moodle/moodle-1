<?php
// This file is part of Moodle - http://moodle.org/.
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
 * Displays the livequiz wait page.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_login(); // Require user login.

// Set up the page.
$PAGE->set_url(new moodle_url('/mod/livequiz/waitpage')); // Updated URL to reflect the wait page.
$PAGE->set_context(context_system::instance());
$PAGE->set_title("Wait for the Quiz");
$PAGE->set_heading("Waiting to Join the Quiz");

// Load the required CSS file.
$PAGE->requires->css(new moodle_url('/mod/livequiz/styles.css'));

// Handle the submitted answer.
$answer = optional_param('answer', null, PARAM_TEXT); // Safely retrieve the 'answer' parameter if it exists.

$templatecontext = [
    'answer' => $answer,
];

// Output the page.
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('mod_livequiz/waitpage', $templatecontext);
echo $OUTPUT->footer();
