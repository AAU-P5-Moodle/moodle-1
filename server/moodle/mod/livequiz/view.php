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
 * Displays the livequiz view page.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir . '/accesslib.php'); // Include the access library for context_module.
require_once('readdemodata.php');

use mod_livequiz\services\livequiz_services;
use mod_livequiz\output\index_page;

global $OUTPUT, $PAGE, $DB;

$cmid = required_param('id', PARAM_INT); // Course module ID.
[$course, $cm] = get_course_and_cm_from_cmid($cmid, 'livequiz');
$instance = $DB->get_record('livequiz', ['id' => $cm->instance], '*', MUST_EXIST);

require_login($course, true, $cm); // Ensure the user is logged in and can access this module.
$context = context_module::instance($cm->id); // Set the context for the course module.
$PAGE->set_cacheable(false);
$PAGE->set_context($context); // Make sure to set the page context.

$PAGE->set_url(new moodle_url('/mod/livequiz/view.php', ['cmid' => $cmid]));
$PAGE->set_title(get_string('modulename', 'mod_livequiz'));
$PAGE->set_heading(get_string('modulename', 'mod_livequiz'));

// Rendering.
$output = $PAGE->get_renderer('mod_livequiz');
$renderable = new \mod_livequiz\output\index_page('THIS IS THE INDEXPAGE OF ' . $instance->name, $cmid, $USER->id);

unset($_SESSION['completed']);

echo $OUTPUT->header();
echo $output->render($renderable);
echo $OUTPUT->footer();
