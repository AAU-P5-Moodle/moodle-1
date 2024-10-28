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
    /** @var int $id the id of the answer*/
    private int $id;

    /** @var string $description the text of the answer*/
    private string $description;

    /** @var bool $correct if the answer is correct*/
    private bool $correct;

    /** @var string $explanation */
    private string $explanation;

    /**
     * answer constructor.
     * @param int $id
     * @param string $description
     * @param bool $correct
     * @param string $explanation
     */
    public function __construct(int $id, string $description, bool $correct, string $explanation) {
        $this->id = $id;
        $this->description = $description;
        $this->correct = $correct;
        $this->explanation = $explanation;
    }

    /**
     * Getter for answer id
     * @return int
     */
    public function get_id(): int {
        return $this->id;
    }

    /**
     * Getter for answer description
     * @return string
     */
    public function get_description(): string {
        return $this->description;
    }

    /**
     * Getter for answer correct
     * @return bool
     */
    public function get_correct(): bool {
        return $this->correct;
    }

    /**
     * Getter for answer explanation
     * @return string
     */
    public function get_explanation(): string {
        return $this->explanation;
    }
}
