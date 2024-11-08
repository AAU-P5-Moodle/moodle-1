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
    /** @var array $quizData Data related to the quiz. */
    public $quizdata;

    /** @var string $formHtml HTML content for the quiz form. */
    public $formhtml;

    /** @var string $savedQuestionsHtml HTML content for the saved questions. */
    public $savedquestionshtml;

    /** @var string $filePickerHtml HTML content for the file picker. */
    public $filepickerhtml;

    /** @var array $scripts Array of script URLs. */
    public $scripts;

    /**
     * Constructor for the quizcreator_renderable class.
     *
     * @param array $quizData Data related to the quiz.
     * @param string $formHtml HTML content for the quiz form.
     * @param string $savedQuestionsHtml HTML content for the saved questions.
     * @param string $filePickerHtml HTML content for the file picker.
     */
    public function __construct($quizdata, $formhtml, $savedquestionshtml, $filepickerhtml) {
        $this->quizdata = $quizdata;
        $this->formhtml = $formhtml;
        $this->savedquestionshtml = $savedquestionshtml;
        $this->filepickerhtml = $filepickerhtml;
        $this->scripts = [
            new moodle_url('/mod/livequiz/amd/src/quizcreator.js'),
        ];
    }

    /**
     * Exports data for use in a template.
     *
     * @param \renderer_base $output The renderer base.
     * @return stdClass Data to be used in the template.
     */
    public function export_for_template(\renderer_base $output) {
        return (object)[
            'quizdata' => $this->quizdata,
            'formhtml' => $this->formhtml,
            'savedquestionshtml' => $this->savedquestionshtml,
            'filepickerhtml' => $this->filepickerhtml,
            'scripts' => $this->scripts,
        ];
    }
}
