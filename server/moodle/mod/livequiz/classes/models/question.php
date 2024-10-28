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

namespace mod_livequiz\question;

use dml_exception;
use dml_transaction_exception;
use mod_livequiz\models\answer;
use mod_livequiz\models\questions_answers_relation;
use mod_livequiz\models\quiz_questions_relation;
use stdClass;


/**
 * Class question
 *
 * This class represents a question in the LiveQuiz module.
 * It handles creation, retrieval, and updates of quiz questions and their associated answers.
 *
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class question {
    /**
     * @var int $id The id of the question.
     */
    private int $id;

    /**
     * @var string $title The title of the question.
     */
    private string $title;

    /**
     * @var string $description The description or body of the question.
     */
    private string $description;

    /**
     * @var int $timelimit The time limit for answering the question (in seconds).
     */
    private int $timelimit;

    /**
     * @var string $explanation The explanation for the correct answer.
     */
    private string $explanation;

    /**
     * @var array $answers A list of possible answers for the question.
     */
    private array $answers = [];

    /**
     * Constructor for the question class.
     *
     * @param string $title
     * @param string $description
     * @param int $timelimit
     * @param string $explanation
     */
    public function __construct(string $title, string $description, int $timelimit, string $explanation) {
        $this->title = $title;
        $this->description = $description;
        $this->timelimit = $timelimit;
        $this->explanation = $explanation;

        return $this;
    }

    /**
     * This function is used to submit a question to the database.
     *
     * @param $question
     * @return int
     * @throws dml_exception
     * @throws dml_transaction_exception
     */
    public static function submit_question($question): int {
        global $DB;
        $questiondata = [
                'title' => $question->title,
                'description' => $question->description,
                'timelimit' => $question->timelimit,
                'explanation' => $question->explanation,
            ];

        return $DB->insert_record('livequiz_questions', $questiondata);
    }

    /**
     * Gets a question instance
     *
     * @param $id
     * @return question
     * @throws dml_exception
     */
    public static function get_question_from_id($id): question {
        global $DB;
        $questioninstance = $DB->get_record('livequiz_questions', ['id' => $id]);
        $question = new question(
            $questioninstance->title,
            $questioninstance->description,
            $questioninstance->timelimit,
            $questioninstance->explanation
        );
        $question->set_id($questioninstance->id);
        return $question;
    }

    /**
     * Gets the ID of the question.
     *
     * @return int
     */
    public function get_id(): int {
        return $this->id;
    }

    /**
     * Gets the title of the question.
     *
     * @return string The title of the question.
     */
    public function get_title(): string {
        return $this->title;
    }

    /**
     * Gets the description of the question.
     *
     * @return string The description of the question.
     */
    public function get_description(): string {
        return $this->description;
    }

    /**
     * Gets the time limit of the question.
     *
     * @return int The time limit of the question.
     */
    public function get_timelimit(): int {
        return $this->timelimit;
    }

    /**
     * Gets the explanation for the question.
     *
     * @return string The explanation of the question.
     */
    public function get_explanation(): string {
        return $this->explanation;
    }

    /**
     * Gets the answers associated with the question.
     *
     * @return array The list of answers.
     */
    public function get_answers(): array {
        return $this->answers;
    }

    /**
     * Appends an answer to the question object.
     *
     * @param array $answers The title of the question.
     */
    public function add_answers(array $answers): void {
        foreach ($answers as $answer) {
            $this->add_answer($answer);
        }
    }

    /*
     * Appends an answer to the question object.
     *
     * @param answers $answer The title of the question.
     */
    public function add_answer(answers $answer): void {
        $this->answers[] = $answer;
    }

    /**
     * Sets the ID of the question.
     *
     * @param $id
     * @return void The ID of the question.
     */
    private function set_id($id): void {
        $this->id = $id;
    }
}
