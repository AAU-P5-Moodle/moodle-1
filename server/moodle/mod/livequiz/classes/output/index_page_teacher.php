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

namespace mod_livequiz\output;

use core\exception\moodle_exception;
use mod_livequiz\models\livequiz;
use renderable;
use renderer_base;
use templatable;
use stdClass;
use moodle_url;

/**
 * Class index_page_teacher
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class index_page_teacher implements renderable, templatable {
    /** @var int $quizid the livequiz to take or retake*/
    private int $quizid;
    /** @var int $teacherid the id of the teacher who is interacting with the quiz. */
    private int $teacherid;
    /** @var int $cmid the course module id */
    protected int $cmid;

    /**
     * index_page_teacher constructor.
     * @param int $quizid
     * @param int $teacherid
     * @param int $courseid
     */
    public function __construct(int $quizid, int $teacherid, int $courseid) {
        $this->quizid = $quizid;
        $this->teacherid = $teacherid;
        $this->cmid = $courseid;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output
     * @return stdClass
     * @throws moodle_exception
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = new stdClass();
        $data->pagename = "Quiz editor page";
        $data->teacherid = $this->teacherid;
        $data->quizid = $this->quizid;
        $data->url = new moodle_url('/mod/livequiz/attempt.php', ['cmid' => $this->cmid]);
        $data->isteacher = true;
        return $data;
    }
}