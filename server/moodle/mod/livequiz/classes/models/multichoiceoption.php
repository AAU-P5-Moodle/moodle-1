<?php
// This file is part of Moodle - http://moodle.org/.
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
 * Class multichoice_choice.
 *
 * Represents an individual choice in a multiple choice question.
 *
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Class multichoice_choice.
 *
 * Represents an individual choice in a multiple choice question.
 *
 * @package   mod_livequiz
 */
class multichoice_choice {
    /**
     * @var string $display The text displayed for this choice.
     */
    public string $display;

    /**
     * @var string $value The value submitted for this choice.
     */
    public string $value;

    /**
     * Constructor for the multichoice_choice class.
     *
     * @param string $display The text displayed for this choice.
     * @param string $value The value submitted for this choice.
     */
    public function __construct(string $display, string $value) {
        $this->display = $display;
        $this->value = $value;
    }
}
