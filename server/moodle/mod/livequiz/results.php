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
 * This displays when viewing results from attempting a quiz.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir . '/accesslib.php');
require_once('readdemodata.php');

global $PAGE, $OUTPUT;

// Get submitted parameters.
$id = required_param('id', PARAM_INT); // Course module id.
$quizid = required_param('livequizid', PARAM_INT);
[$course, $cm] = get_course_and_cm_from_cmid($id, 'livequiz');

require_login($course, false, $cm);

$context = context_module::instance($cm->id);

$PAGE->set_context($context); // Make sure to set the page context.

$PAGE->set_url(new moodle_url('/mod/livequiz/results.php', ['id' => $id, 'quizid' => $quizid ]));
$PAGE->set_title(get_string('modulename', 'mod_livequiz'));
$PAGE->set_heading(get_string('modulename', 'mod_livequiz'));

// Read demo data. -replace with DB query when DB is connected.
$demodatareader = new \mod_livequiz\readdemodata();
$demoquiz = $demodatareader->getdemodata();

// Rendering.
$output = $PAGE->get_renderer('mod_livequiz');
$results = new \mod_livequiz\output\results_page($id, $demoquiz);


echo $OUTPUT->header();
echo $output->render($results);
echo $OUTPUT->footer();
