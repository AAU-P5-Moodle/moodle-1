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
use renderable;
use renderer_base;
use templatable;
use stdClass;
use moodle_url;
use mod_livequiz\models\livequiz;

/**
 * Class index_page
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class create_quiz_page implements renderable, templatable {
    /** @var object $livequizobject The object we get from the database that we put into the rendered forms*/
    protected livequiz $livequizobject;
    /** @var int $cmid the course module id */
    protected int $cmid;

    /**
     * index_page constructor.
     *
     * @param int $id
     */
    public function __construct(livequiz $dboject, int $id) {
        $this->livequizobject = $dboject;
        $this->cmid = $id;
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
        $data->name = $this->livequizobject->get_name();
        $data->intro = $this->livequizobject->get_intro();
        $navigationbar = new navigationbar($this->cmid);
        $data->tabs = $navigationbar->export_for_template();
        return $data;
    }
}
