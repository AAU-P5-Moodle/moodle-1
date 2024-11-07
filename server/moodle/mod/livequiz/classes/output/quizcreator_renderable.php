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

defined('MOODLE_INTERNAL') || die();

use moodle_url;
use renderable;
use templatable;

class quizcreator_renderable implements renderable, templatable {
    public $quizdata;
    public $form_html;
    public $saved_questions_html;
    public $file_picker_html;
    public $scripts;

    public function __construct($quizdata, $form_html, $saved_questions_html, $file_picker_html) {
        $this->quizdata = $quizdata;
        $this->form_html = $form_html;
        $this->saved_questions_html = $saved_questions_html;
        $this->file_picker_html = $file_picker_html;
        $this->scripts = [
            new moodle_url('/mod/livequiz/amd/src/quizcreator.js')
        ];
    }

    public function export_for_template(\renderer_base $output) {
        return (object)[
            'quizdata' => $this->quizdata,
            'form_html' => $this->form_html,
            'saved_questions_html' => $this->saved_questions_html,
            'file_picker_html' => $this->file_picker_html,
            'scripts' => $this->scripts
        ];
    }
}
