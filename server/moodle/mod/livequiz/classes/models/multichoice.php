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
 * Multichoice class for quiz answers.
 *
 * This class together with the multichoice_choice class implement the answer interface for multiple choice answers.
 *
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once('answer.php');
require_once('multichoiceoption.php');

/**
 * Class multichoice.
 *
 * Implements the answer interface for a multiple choice answer.
 *
 * @package   mod_livequiz
 */
class multichoice implements answer_interface {
    /**
     * @var multichoice_choice[] $choices An array of multiple choice options.
     */
    private array $choices;

    /**
     * Constructor for the multichoice class.
     *
     * @param multichoice_choice[] $choices An array of multiple choice options.
     */
    public function __construct(array $choices) {
        $this->choices = $choices;
    }

    /**
     * Generate the HTML representation of the multiple choice answer.
     *
     * @return string The HTML for the multiple choice answer form.
     */
    public function html(): string {
        $output = '<form action="wait.php" method="POST" class="answer multichoice">';

        foreach ($this->choices as $choice) {
            $output .= "<button type='submit' name='answer' value='" . htmlspecialchars($choice->value, ENT_QUOTES, 'UTF-8') . "'>"
                . htmlspecialchars($choice->display, ENT_QUOTES, 'UTF-8') . "</button>";
        }

        $output .= '</form>';

        return $output;
    }
}
