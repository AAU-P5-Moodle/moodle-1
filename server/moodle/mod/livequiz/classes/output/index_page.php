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

/**
 * Class index_page
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class index_page implements renderable, templatable {
    /** @var string $sometext Some text to show how to pass data to a template. */
    private string $sometext;
    /** @var int $cmid the course module id */
    protected int $cmid;

    /**
     * index_page constructor.
     * @param string $sometext
     * @param int $id
     */
    public function __construct(string $sometext, int $id) {
        $this->sometext = $sometext;
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
        $data->sometext = $this->sometext;
        $data->url = new moodle_url('/mod/livequiz/attempt.php', ['cmid' => $this->cmid]);

        // Standard information for the navigationbar.
        $data->tabs = [
            [
                'url' => new moodle_url('/mod/livequiz/quizcreator.php', ['id' => $this->cmid]),
                'label' => get_string('quizcreator', 'mod_livequiz'),

            ],
            [
                'url' => new moodle_url('/mod/livequiz/quizrunner.php', ['id' => $this->cmid]),
                'label' => get_string('quizrunner', 'mod_livequiz'),

            ],
            [
                'url' => new moodle_url('/mod/livequiz/.php', ['id' => $this->cmid]),
                'label' => get_string('quizstats', 'mod_livequiz'),

            ],
            [
                'url' => new moodle_url('/mod/livequiz/questionbank.php', ['id' => $this->cmid]),
                'label' => get_string('questionbank', 'mod_livequiz'),
            ],
        ];
        return $data;
    }
}
