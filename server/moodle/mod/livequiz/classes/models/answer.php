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

namespace mod_livequiz\models;

use stdClass;

/**
 * Class answer.
 *
 * This class represents an answer in the LiveQuiz module.
 * It handles the creation, retrieval, and updates of answer associated with quiz questions.
 *
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class answer {
    /**
     * @var int $id
     */
    private int $id;
    /**
     * @var int $correct
     */
    private int $correct;
    /**
     * @var string $description
     */
    private string $description;

    /**
     * @var string $explanation
     */
    private string $explanation;

    /**
     * Constructor for the answer class. Returns the object.
     *
     * @param int $correct // Expects 1 or 0.
     * @param string $description
     * @param string $explanation
     */
    public function __construct(int $correct, string $description, string $explanation) {
        $this->correct = $correct;
        $this->description = $description;
        $this->explanation = $explanation;

        return $this;
    }

    /**
     * Gets the ID of the answer.
     *
     * @return int
     */
    public function get_id(): int {
        return $this->id ?? 0;
    }

    /**
     * Gets the correct status of the answer.
     *
     * @return int
     */
    public function get_correct(): int {
        return $this->correct;
    }

    /**
     * Gets the description of the answer.
     *
     * @return string
     */
    public function get_description(): string {
        return $this->description;
    }

    /**
     * Gets the explanation of the answer.
     *
     * @return string
     */
    public function get_explanation(): string {
        return $this->explanation;
    }

    /**
     * Sets the ID of the answer.
     *
     * @param int $id
     */
    public function set_id(int $id): void {
        $this->id = $id;
    }

    /**
     * Sets the correct status of the answer.
     *
     * @param int $correct
     */
    public function set_correct(int $correct): void {
        $this->correct = $correct;
    }

    /**
     * Sets the description of the answer.
     *
     * @param string $description
     */
    public function set_description(string $description): void {
        $this->description = $description;
    }

    /**
     * Sets the explanation of the answer.
     *
     * @param string $explanation
     */
    public function set_explanation(string $explanation): void {
        $this->explanation = $explanation;
    }

    /**
     * Resets the id of the answer to 0, such that it can be reused.
     */
    public function reset_id(): void {
        $this->set_id(0);
    }

    /**
     * Gets the sanitized answer object.
     *
     * @return stdClass
     */
    public function get_sanitized_answer(): stdClass {
        $sanitizedanswer = new stdClass();

        $sanitizedanswer->id = $this->get_id();
        $sanitizedanswer->description = $this->get_description();
        $sanitizedanswer->explanation = $this->get_explanation();

        return $sanitizedanswer;
    }
}
