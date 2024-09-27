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
 * Unit tests for mod_livequiz.
 *
 * @package    mod_livequiz
 * @category   test
 * @copyright  2023
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/mod/livequiz/lib.php');
require_once($CFG->dirroot . '/mod/livequiz/mod_form.php');

class test_mod_livequiz_setup extends advanced_testcase {

    /**
     * Activity Setup Test function.
     * This function should test the mod_form_setup function.
     * It should call the definition function.
     * It should call the standard_coursemodule_elements function.
     * It should call the add_action_buttons function.
     */
    public function test_mod_form_setup() {
        $this->resetAfterTest(true);

        // Create a mock object for mod_livequiz_mod_form
        // getMockBuilder() creates a mock object for the specified class
        // disableOriginalConstructor() prevents the constructor from being called
        // onlyMethods() specifies the methods that should be mocked
        $mock = $this->getMockBuilder(mod_livequiz_mod_form::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['standard_coursemodule_elements', 'add_action_buttons'])
            ->getMock();
        $mockClass = $this->createMock(mod_livequiz_mod_form::class);

        // Set expectations for the mockClass object
        $mockClass->expects($this->once())
            ->method('definition');

        // Set expectations for the mock object
        $mock->expects($this->once())
            ->method('standard_coursemodule_elements');

        $mock->expects($this->once())
            ->method('add_action_buttons');

        // Call the definition function
        $mock->definition();
        $mockClass->definition();
    }
}