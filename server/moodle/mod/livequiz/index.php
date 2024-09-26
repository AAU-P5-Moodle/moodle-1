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

global $OUTPUT, $PAGE, $COURSE;
require_once(__DIR__ . '/../../config.php');

// Course ID.
$id = required_param('id', PARAM_INT);
$course = get_course($id);
$courseid = $course->id;

$PAGE->set_url('/mod/livequiz/index.php', ['id' => $id]);
$PAGE->set_context(\context_course::instance($id));


$PAGE->set_title(get_string('modulename', 'mod_livequiz'));
$PAGE->set_heading(get_string('modulename', 'mod_livequiz'));

echo $OUTPUT->header();
echo $OUTPUT->heading('Live Quiz');
echo $OUTPUT->footer();
