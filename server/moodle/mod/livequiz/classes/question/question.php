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
use mod_livequiz\answers\answers;
use mod_livequiz\questions_answers_relation\questions_answers_relation;
use mod_livequiz\quiz_questions_relation\quiz_questions_relation;
use stdClass;


/**
 * Class question
 *
 * This class represents a question in the LiveQuiz module.
 * It handles creation, retrieval, and updates of quiz questions and their associated answers.
 *
 * @package question
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
        try {
            $transaction = $DB->start_delegated_transaction();
            $questiondata = [
                    'title' => $question->title,
                    'description' => $question->description,
                    'timelimit' => $question->timelimit,
                    'explanation' => $question->explanation,
                ];

            $questionid = $DB->insert_record('livequiz_questions', $questiondata);
            $transaction->allow_commit();
            return $questionid;
        } catch (dml_exception $e) {
            $transaction->rollback($e);
            throw $e;
        }
    }

    /**
     * Gets a question instance, with all relevant attributes
     *
     * @param $id
     * @return stdClass
     * @throws dml_exception
     */
    public static function get_question_from_id($id): stdClass {
        global $DB;
        $question = $DB->get_record('livequiz_questions', ['id' => $id]);
        $answers = questions_answers_relation::get_answers_from_question($question->id);
        $question->answers = $answers;
        return $question;
    }

    /**
     * When a question is being constructed,
     * this function should be called to create an answer
     * associated with the specific question.
     *
     * @param $correct
     * @param $description
     * @param $explanation
     * @return void
     */
    public function new_answer_option($correct, $description, $explanation): void {
        $this->answers[] = new answers($correct, $description, $explanation);
    }

    /**
     * TODO: Implement this method
     * Update a question
     *
     * @param $questiondata
     * @return bool
     * @throws dml_exception
     */
    public static function update_question($questiondata): bool {
        global $DB;
        return $DB->update_record('livequiz_questions', $questiondata);
    }

    /**
     * TODO: Implement this method
     * Delete a question
     *
     * @param $questiondata
     * @throws dml_exception
     */

    // Getters for private fields.

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
}
