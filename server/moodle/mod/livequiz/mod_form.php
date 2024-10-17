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
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->dirroot . '/course/moodleform_mod.php');


/**
 * Form for creating/editing a livequiz activity.
 */
class mod_livequiz_mod_form extends moodleform_mod {
    /**
     * Defines the form elements.
     *
     * @return void
     */
    public function definition(): void {
        // Used to add fields to form.
        $this->standard_coursemodule_elements();
        // Standard Moodle form buttons.
        $this->add_action_buttons();
    }
}
