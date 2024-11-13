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

use behat_base;

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
     */
    public function assertischecked($element) {
        $this->assertSession()->checkboxChecked($element);
    }
}
