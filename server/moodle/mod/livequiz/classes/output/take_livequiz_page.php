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

use renderable;
use renderer_base;
use templatable;
use stdClass;
use mod_livequiz\classes\livequiz;

defined('MOODLE_INTERNAL') || die();
require_once(dirname(__DIR__) . '/livequiz.php');

/**
 * Class take_livequiz_page
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class take_livequiz_page implements renderable, templatable {
    /** @var livequiz $livequiz The quiz that are currently being attempted. */
    private livequiz $livequiz;

    /** @var string $sometext Some text to show how to pass data to a template. */
    private string $sometext;

    /** @var int $questionid . The id of the question to be rendered*/
    private int $questionid = 0;

    /**
     * Constructor for take_livequiz_page, which sets the livequiz field.
     *
     * @param livequiz $livequiz
     */
    public function __construct(livequiz $livequiz) {
        $this->livequiz = $livequiz;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output
     * @return stdClass
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = new stdClass();
        $data->quiztitle = $this->livequiz->get_name();
        $data->questiontitle = $this->livequiz->get_question_by_index($this->questionid)->get_title();
        $data->description = $this->livequiz->get_question_by_index($this->questionid)->get_description();
        return $data;
    }
}
