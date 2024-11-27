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

namespace mod_livequiz\tests\behat;

use Behat\Mink\Exception\ExpectationException;
use behat_base;
use demodatareader;
use mod_livequiz\services\livequiz_services;

// Include the demodatareader file(THIS IS NECESSARY).
require_once(dirname(__DIR__) . '/behat/demodatareader.php');

// This is used because behat cannot find the class when the namespace is defined.
class_alias('mod_livequiz\tests\behat\behat_mod_livequiz', 'behat_mod_livequiz');

/**
 * Steps definitions related to mod_livequiz.
 *
 * @package   mod_livequiz
 * @category  test
 * @copyright Software AAU 2024
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_mod_livequiz extends behat_base {
    /**
     * Asserts whether the given element is checked.
     * @Then the :checkbox answer should be checked
     * @param $element (radio button or checkbox)
     * @throws ExpectationException
     */
    public function assertischecked($element): void {
        $this->assertSession()->checkboxChecked($element);
    }

    /**
     * Asserts whether the given element is not checked.
     * @Then the :checkbox answer should not be checked
     * @param $element (radio button or checkbox)
     * @throws ExpectationException
     */
    public function assertisnotchecked($element): void {
        $this->assertSession()->checkboxNotChecked($element);
    }

    /**
     * Reads the demo data and creates objects from it.
     *
     * @Given I use demodata for the course :coursename and activity :activityname
     */
    public function i_use_demodata($coursename, $activityname): void {
        global $DB;

        // Get the course ID.
        $course = $DB->get_record('course', ['shortname' => $coursename], '*', MUST_EXIST);

        // Get the module information (like 'livequiz').
        $module = $DB->get_record('modules', ['name' => $activityname], '*', MUST_EXIST);

        // Get the course module record.
        $coursemodule = $DB->get_record('course_modules', [
            'course' => $course->id,
            'module' => $module->id,
            'idnumber' => 1,
        ], '*', MUST_EXIST);

        // Get the instance of the module.
        $instance = $DB->get_record('livequiz', ['id' => $coursemodule->instance], '*', MUST_EXIST);

        // Read demo data and insert into DB to use for tests.
        $livequizservice = livequiz_services::get_singleton_service_instance();
        $livequiz = $livequizservice->get_livequiz_instance($instance->id);
        $demodatareader = new demodatareader();
        $demodatareader->insertdemodata($livequiz);
    }

    /**
     * Tests if an element has a given class (whitespaces are removed).
     *
     * @Then the :selector should have class :class
     */
    public function elementshouldhaveclass($selector, $class) {
        // Get an element via id.
        $element = $this->getSession()->getPage()->find('css', $selector);

        if (null === $element) {
            throw new \Exception("Could not find element with selector '$selector'.");
        }

        // Get the class of the div.
        $classes = $element->getAttribute('class');

        /* The class in the code contains multiple line ends and spaces (uncountable amount), therefore
         * we remove all line ends and spaces from the class given in the test and
         * the class gotten in the test.
         */
        $class = preg_replace('/\s+/', '', $class);
        $classes = preg_replace('/\s+/', '', $classes);

        // Check if the class given is not the same as the class gotten.
        if (!str_contains($classes, $class)) {
            throw new \Exception("Element with selector '$selector' does not contain class '$class'.  Actual class: $classes");
        }
    }
}
