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

use Behat\Mink\Exception\DriverException;
use Behat\Mink\Exception\ExpectationException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
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
    public function assertischecked($element) {
        $this->assertSession()->checkboxChecked(field: $element);
    }

    /**
     * Asserts whether the given element with a specific id is checked
     * @Then the checkbox with id :checkboxid should be checked
     */
    public function checkbox_with_id_should_be_checked($checkboxid) {
        $checkbox = $this->getSession()->getPage()->findField($checkboxid);

        if (null === $checkbox) {
            throw new \Exception("Checkbox with id '{$checkboxid}' not found.");
        }

        if (!$checkbox->isChecked()) {
            throw new \Exception("Checkbox with id '{$checkboxid}' is not checked.");
        }
    }

    /**
     * Asserts whether the given element with a specific id is NOT checked
     * @Then the checkbox with id :checkboxid should not be checked
     */
    public function checkbox_with_id_should_not_be_checked($checkboxid) {
        $checkbox = $this->getSession()->getPage()->findField($checkboxid);

        if (null === $checkbox) {
            throw new \Exception("Checkbox with id '{$checkboxid}' not found.");
        }

        if ($checkbox->isChecked()) {
            throw new \Exception("Checkbox with id '{$checkboxid}' is not checked.");
        }
    }

    /**
     * Asserts the id for a checkbox or radio button.
     * @Then the :selectorType with id :checkboxid should exist
     */
    public function assertelementidexists($checkboxid) {
        $this->assertSession()->elementExists('css', '#' . $checkboxid);
    }

    /**
     * Asserts the id for a checkbox or radio button.
     * @Then the :selectorType with id :checkboxid should not exist
     */
    public function assertelemtenidnotexists($checkboxid) {
        $this->assertSession()->elementNotExists('css', '#' . $checkboxid);
    }

    /**
     * Asserts whether the given element is not checked.
     * @Then the :checkbox answer should not be checked
     * @param $element (radio button or checkbox)
     * @throws ExpectationException
     */
    public function assertisnotchecked($element) {
        $this->assertSession()->checkboxNotChecked($element);
    }

    /**
     * Asserts whether a given element only occurs once in the list
     * @Then I check that element :itemName occurs only once in the list
     */
    public function icheckthatelementoccursonlyonceinthelist($expectedname) {
        $elements = $this->getSession()->getPage()->findAll('xpath', "//*[text()='$expectedname']");

        // Check if the count is exactly 1.
        if (count($elements) !== 1) {
            throw new \Exception(
                "The element '$expectedname' occurs " .
                count($elements) .
                " times, but it should only occur once."
            );
        }
    }

    /**
     * Reads the demo data and creates objects from it.
     *
     * @Given I use demodata :datanumber for the course :coursename and activity :activityname and lecturer :teachername
     */
    public function i_use_demodata($datanumber, $coursename, $activityname, $teachername): void {
        global $DB;

        // Get the course ID.
        $course = $DB->get_record('course', ['shortname' => $coursename], '*', MUST_EXIST);


        // Get the module information (like 'livequiz').
        $module = $DB->get_record('modules', ['name' => $activityname], '*', MUST_EXIST);

        // Get the course module record.
        $coursemodule = $DB->get_record('course_modules', [
            'course' => $course->id,
            'module' => $module->id,
        ], '*', MUST_EXIST);

        // Get the user record.
        $user = $DB->get_record('user', [
            'username' => $teachername,
        ], 'id', MUST_EXIST);

        // Get the instance of the module.
        $instance = $DB->get_record('livequiz', ['id' => $coursemodule->instance], '*', MUST_EXIST);

        // Read demo data and insert into DB to use for tests.
        $livequizservice = livequiz_services::get_singleton_service_instance();
        $livequiz = $livequizservice->get_livequiz_instance($instance->id);
        $demodatareader = new demodatareader();
        $demodatareader->insertdemodata($livequiz, '/behatdata' . $datanumber . '.json', $user->id);
    }

    /**
     * Reads the demo data and creates objects from it.
     *
     * @Given I use demodata for the course :coursename and activity :activityname
     */
    public function i_use_demodata_one($coursename, $activityname): void {
        $this->i_use_demodata(1, $coursename, $activityname, "admin");
    }

    /**
     * Tests if an element has a given class (whitespaces are removed).
     *
     * @Then :selector should have a parent div with class :class
     */
    public function elementshouldhaveclass($selector, $class) {

        $label = $this->getSession()->getPage()->findAll('css', 'label');
        foreach ($label as $lbl) {
            if ($lbl->getText() === $selector) {
                // Get the parent element of the label (which should be the div).
                $labelclass = $lbl->getAttribute('class');
                break; // Stop once the correct label is found.
            }
        }
        /* The class in the code contains multiple line ends and spaces (uncountable amount), therefore
         * we remove all line ends and spaces from the class given in the test and
         * the class gotten in the test.
         */
        $class = preg_replace('/\s+/', '', $class);
        $classes = preg_replace('/\s+/', '', $labelclass);

        // Check if the class given is not the same as the class gotten.
        if (!str_contains($classes, $class)) {
            throw new \Exception("Element with selector '$selector' does not contain class '$class'.  Actual class: $classes");
        }
    }


    /**
     * Enables automatic dismissal of alerts.
     *
     * @When /^I enable automatic dismissal of alerts$/
     * @throws UnsupportedDriverActionException
     * @throws DriverException
     */
    public function idismissalerts(): void {
        $driver = $this->getSession()->getDriver();
        $driver->evaluateScript('window.confirm = function() { return true; };'); // Auto-accept confirms.
    }
}
