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
 * Question class for representing a quiz question.
 *
 * This class handles the representation and display of a quiz question,
 * including the image, prompt, and associated answer.
 *
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once('answer/answer.php');

/**
 * Question class for representing a quiz question.
 *
 * This class handles the representation and display of a quiz question,
 * including the image, prompt, and associated answer.
 *
 * @package   mod_livequiz
 */
class question {
    /**
     * @var string $image The URL of the image associated with the question.
     */
    public string $image;

    /**
     * @var string $prompt The text prompt for the question.
     */
    public string $prompt;

    /**
     * @var string $prompt The text prompt for the question.
     */
    public answer $answer;

    /**
     * Constructor for the question class.
     *
     * Initializes the question object with an image, prompt, and answer.
     *
     * @param string $image The URL of the image for the question.
     * @param string $prompt The text prompt for the question.
     * @param answer $answer The answer object associated with the question.
     */
    public function __construct(string $image, string $prompt, answer $answer) {
        $this->image = $image;
        $this->prompt = $prompt;
        $this->answer = $answer;
    }

    /**
     * Generate the HTML representation of the question.
     *
     * @param int|null $progressPercentage Optional progress percentage.
     * @return string The HTML representation.
     */
    public function html(?int $progresspercentage = null): string {
        $progressbarhtml = '';
        if ($progresspercentage !== null && $progresspercentage > 0) {
            $progressbarhtml = "
                <div class='progress-bar'>
                    <div style='width: {$progresspercentage}%;'>
                        {$progresspercentage}%
                    </div>
                </div>
            ";
        }

        return "
            <div class='question-container'>
                <img src='" . htmlspecialchars($this->image, ENT_QUOTES, 'UTF-8') . "' alt='quiz image' />
                {$progressbarhtml}
                <div class='prompt'>
                    <p>" . htmlspecialchars($this->prompt, ENT_QUOTES, 'UTF-8') . "</p>
                </div>
                {$this->answer->html()}
            </div>
        ";
    }

    /**
     * Display the question by outputting its HTML.
     *
     * @param int|null $progressPercentage Optional progress percentage.
     */
    public function display(?int $progresspercentage = null): void {
        echo $this->html($progresspercentage);
    }
}