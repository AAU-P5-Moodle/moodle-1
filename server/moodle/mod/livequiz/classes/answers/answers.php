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

/**
 * Displays the livequiz view page.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_livequiz\answers;

use dml_exception;
use dml_transaction_exception;
use mod_livequiz\questions_answers_relation\questions_answers_relation;
use mod_livequiz\quiz_questions_relation\quiz_questions_relation;

/**
 * Class answers.
 *
 * This class represents an answer in the LiveQuiz module.
 * It handles the creation, retrieval, and updates of answers associated with quiz questions.
 *
 * @package mod_livequiz\answers
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class answers {
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
     * Constructor for the answers class. Returns the object.
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
     * Given an answer object, this method will insert the answer to the database
     *
     * @param answers $answer
     * @return int
     * @throws dml_exception
     */
    public static function submit_answer(answers $answer): int {
        global $DB;

        $answerdata = [
            'correct' => $answer->correct,
            'description' => $answer->description,
            'explanation' => $answer->explanation,
        ];

        return $DB->insert_record('livequiz_answers', $answerdata);
    }

    /**
     * Get an answer, given its id.
     *
     * @param int $id
     * @return mixed
     * @throws dml_exception
     */
    public static function get_answer_from_id(int $id): answers {
        global $DB;
        $answerdata = $DB->get_record('livequiz_answers', ['id' => $id]);
        $answer = new answers($answerdata->correct, $answerdata->description, $answerdata->explanation);
        $answer->set_id($answerdata->id);
        return $answer;
    }

    /**
     * Gets the ID of the answer.
     *
     * @return int
     */
    public function get_id(): int {
        return $this->id;
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
    private function set_id(int $id): void {
        $this->id = $id;
    }
}
