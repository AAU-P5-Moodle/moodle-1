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
 * This is functionlity for submitting answers to a live quiz.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_login();

session_start();

$questionid = required_param('questionid', PARAM_INT);
$answervalue = required_param('answervalue', PARAM_TEXT);

$answers = [];
$decodeanswer = json_decode($answervalue, true);
foreach ($decodeanswer as $key => $value) {
    $answers[] = $value;
}


if (!isset($_SESSION['quiz_answers'])) {
    $_SESSION['quiz_answers'] = [];
}

$_SESSION['quiz_answers'][$questionid] = [
    'question_id' => $questionid,
    'answers' => $answers,
];
// KEPT TEMPORARILY FOR DEVELOPMENT PURPOSES
//echo "<pre>";
//print_r($_SESSION['quiz_answers']);
//echo "</pre>";
//exit;
