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

use moodle_url;
use renderable;
use templatable;
use stdClass;

/**
 * Class quizcreator_renderable
 *
 * This class is responsible for rendering the quiz creator interface.
 *
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class quizcreator_renderable implements renderable, templatable {
    /** @var array $quizdata Data related to the quiz structure */
    private array $quizdata;

    /** @var array $savedquestions List of saved questions */
    private array $savedquestions;

    /**
     * Constructor for the quizcreator_renderable class.
     *
     * @param array $quizdata Data related to the quiz.
     * @param array $savedquestions Array of saved questions.
     */
    public function __construct(array $quizdata, array $savedquestions) {
        $this->quizdata = $quizdata;
        $this->savedquestions = $savedquestions;
    }

    /**
     * Exports data for use in a Mustache template.
     *
     * @param \renderer_base $output The renderer base.
     * @return stdClass Data to be used in the template.
     */
    public function export_for_template(\renderer_base $output): stdClass {
        $data = new stdClass();
        $data->quizdata = $this->quizdata;
        $data->savedquestions = $this->savedquestions;
        $data->scripturl = (new moodle_url('/mod/livequiz/amd/src/quizcreator.js'))->out();

        return $data;
    }
}
