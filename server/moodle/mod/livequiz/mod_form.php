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
 * Activity creation/editing form for the mod_livequiz plugin.
 *
 * @package
 * @copyright
 * @license
 */

require_once($CFG->dirroot.'/course/moodleform_mod.php');

class mod_livequiz_mod_form extends moodleform_mod {
    /**
     * @return void
     */
    function definition() {
        global $CFG, $DB, $OUTPUT;
        // Used to add fields to form.
        $mform =& $this->_form;
        $this->standard_coursemodule_elements();
        // Standard Moodle form buttons.
        $this->add_action_buttons();
    }
    function validation($data, $files) {

    }
    function data_preprocessing(&$default_values) {

    }

}