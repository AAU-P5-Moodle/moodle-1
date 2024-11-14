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
 * Slider answer class implementation.
 *
 * This class implements the answer interface for a slider input type.
 *
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once('answer.php');

/**
 * Class slider.
 *
 * Represents an answer type with a slider input.
 *
 * @package   mod_livequiz
 */
class slider implements answer_interface {
    /**
     * @var int $min The minimum value of the slider.
     */
    private $min;

    /**
     * @var int $max The maximum value of the slider.
     */
    private $max;

    /**
     * Constructor for the slider class.
     *
     * @param int $min The minimum value of the slider.
     * @param int $max The maximum value of the slider.
     */
    public function __construct(int $min, int $max) {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Generate the HTML representation of the slider input.
     *
     * @return string The HTML for the slider input form.
     */
    public function html(): string {
        $output = "
            <form action='wait.php' method='POST' class='answer slider'>
                <output>24</output><br>
                    <input
                    type='range'
                    name='answer'
                    min='" . $this->min . "'
                    max='" . $this->max . "'
					oninput='this.previousElementSibling.previousElementSibling.value = this.value'
                >
                <button type='submit' name='submit'>Submit</button>
            </form>
        ";
        return $output;
    }
}
