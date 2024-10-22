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

namespace mod_livequiz\classes;

/**
 * Class answer
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class answer {
    /** @var string $text the text of the answer*/
    public string $text;

    /** @var bool $correct if the answer is correct*/
    public bool $correct;

    /** @var string $explanation */
    public string $explanation;

    /**
     * @param string $text
     * @param bool $correct
     * @param string $explanation
     */
    public function __construct(string $text, bool $correct, string $explanation) {
        $this->text = $text;
        $this->correct = $correct;
        $this->explanation = $explanation;
    }
}