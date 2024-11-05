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
use mod_livequiz\models\livequiz;

defined('MOODLE_INTERNAL') || die();
require_once(dirname(__DIR__) . '/models/livequiz.php');

/**
 * Class results_page
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class results_page implements renderable, templatable {
    /** @var int $cmid the course module id */
    protected int $cmid;
    /** @var livequiz $livequiz The live quiz instance */
    private livequiz $livequiz;

    /**
     * index_page constructor.
     * @param int $id
     * @param livequiz $livequiz
     */
    public function __construct(int $id, livequiz $livequiz) {
        $this->cmid = $id;
        $this->livequiz = $livequiz;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output
     * @return stdClass
     * @throws moodle_exception
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = $this->livequiz->prepare_for_template();
        $data->isattempting = false; // This is the results page, so the user is not attempting the quiz.
        return $data;
    }
}
