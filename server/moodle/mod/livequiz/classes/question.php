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
defined('MOODLE_INTERNAL') || die();
require_once('answer.php');

/**
 * Class question
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class question {
    /** @var int $id the id of the question*/
    public int $id;

    /** @var string $image if the question has an image to display*/
    public string $image;

    /** @var string $title title of the question*/
    public string $title;

    /** @var string $description description of the question*/
    public string $description;

    /** @var string $explanation explanation of the question and the answer*/
    public string $explanation;

    /** @var int $timelimit the time an answer can be answered (seconds)*/
    public int $timelimit;

    /** @var array $answers array of answers to the question*/
    public array $answers = [];

    /**
     * question constructor.
     * @param int $id
     * @param string $title
     * @param string $description
     * @param string $explanation
     * @param int $timelimit
     * @param array $answers
     */
    public function __construct(int $id, string $title, string $description, string $explanation, int $timelimit, array $answers) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->explanation = $explanation;
        $this->timelimit = $timelimit;

        foreach ($answers as $answer) {
            $answerobject = new answer($answer['id'], $answer['description'], $answer['correct'], $answer['explanation']);
            $this->answers[] = $answerobject;
        }
    }

    /**
     * Getter for question id
     * @return int
     */
    public function get_id(): int {
        return $this->id;
    }

    /**
     * Getter for question title
     * @return string
     */
    public function get_title(): string {
        return $this->title;
    }

    /**
     * Getter for question description
     * @return string
     */
    public function get_description(): string {
        return $this->description;
    }

    /**
     * Getter for question explanation
     * @return string
     */
    public function get_explanation(): string {
        return $this->explanation;
    }

    /**
     * Getter for question timelimit
     * @return int
     */
    public function get_timelimit(): int {
        return $this->timelimit;
    }
}
