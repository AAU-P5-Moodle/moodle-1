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
 require_login();
 require_once('question.php');
 require_once('answer/slider.php');
 require_once('answer/multichoice.php');

 
 $PAGE->set_url(new moodle_url('/mod/livequiz/quizrunner'));
 $PAGE->set_context(context_system::instance());
 $PAGE->set_title("Play quiz");
 $PAGE->set_heading("Join a quiz");
 $PAGE->requires->css(new moodle_url('/mod/livequiz/style.css'));
 
 // Prepare context data for the Mustache template.

 
 $questionHtml = $question->html(); // Generate the question's HTML representation.
 
 $templateContext = [
     'navbarHtml' => $navbarHtml,
     'questionHtml' => $questionHtml,
 ];
 
 // Render the template.
 echo $OUTPUT->header();
 echo $OUTPUT->render_from_template('mod_livequiz/quizrunner_page', $templateContext);
 echo $OUTPUT->footer();
