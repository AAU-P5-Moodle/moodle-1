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

namespace mod_livequiz;
use advanced_testcase;
use coding_exception;
use mod_livequiz_mod_form;
use MoodleQuickForm;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/mod/livequiz/lib.php');
require_once($CFG->dirroot . '/mod/livequiz/mod_form.php');

/**
 * Unit test for the mod_livequiz activity setup.
 *
 * @package    mod_livequiz
 * @category   test
 * @copyright  2023
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class activitysetup_test extends advanced_testcase {
    /**
     * Activity Setup Test function.
     * This function tests the setup of mod_form without assuming _form as a field.
     * It calls the definition function, standard_coursemodule_elements, and add_action_buttons.
     * @covers \mod_livequiz\activitysetup_test::test_mod_form_setup
     * @throws coding_exception
     */
    public function test_mod_form_setup(): void {
        $this->resetAfterTest(true);

        // Create a mock object for mod_livequiz_mod_form!
        // GetMockBuilder() creates a mock object for the specified class!
        // DisableOriginalConstructor() prevents the constructor from being called!
        // OnlyMethods() specifies the methods that should be mocked!.
        $mock = $this->getMockBuilder(mod_livequiz_mod_form::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['standard_intro_elements', 'standard_coursemodule_elements', 'add_action_buttons'])
            ->getMock();

        // Create an instance of MoodleQuickForm and inject it into the _form property using reflection.
        $form = new MoodleQuickForm('modform', 'POST', '', null, ['class' => 'mform'], true);

        $mock->set_form($form);

        // Set expectations for methods called in definition().
        $mock->expects($this->once())
            ->method('standard_intro_elements')
            ->with($this->equalTo(get_string('introduction', 'quiz')));

        $mock->expects($this->once())
            ->method('standard_coursemodule_elements');

        $mock->expects($this->once())
            ->method('add_action_buttons');

        // Call the definition function to execute the test.
        $mock->definition();
    }
}
