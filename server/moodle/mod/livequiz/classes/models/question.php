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

use dml_exception;
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
     * @var int $type Defines the type of the question.
     */
    private int $type = 0;

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
     * Gets the ID of the question.
     *
     * @return int|0 // Returns the ID of the question, if it has one. 0 if it does not.
     */
    public function get_id(): int {
        return $this->id ?? 0;
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
     * Sets the answers associated with the question.
     *
     * @param array $newanswers
     */
    public function set_answers(array $newanswers): void {
        $this->answers = $newanswers;
    }

    /**
     * Appends an answer to the question object.
     *
     * @param array $answers
     */
    public function add_answers(array $answers): void {
        foreach ($answers as $answer) {
            $this->add_answer($answer);
        }
    }

    /**
     * Appends an answer to the question object.
     *
     * @param answer $answer The title of the question.
     */
    public function add_answer(answer $answer): void {
        $this->answers[] = $answer;
    }

    /**
     * Removes all answers from the question
     *
     */
    public function remove_answers(): void {
        $this->answers = [];
    }


    /**
     * Sets the ID of the question.
     *
     * @param $id
     * @return void The ID of the question.
     */
    public function set_id($id): void {
        $this->id = $id;
    }

    /**
     * Sets the title of the question.
     *
     * @param string $title The title of the question.
     */
    public function set_title(string $title): void {
        $this->title = $title;
    }

    /**
     * Sets the description of the question.
     *
     * @param string $description The description of the question.
     */
    public function set_description(string $description): void {
        $this->description = $description;
    }

    /**
     * Sets the time limit of the question.
     *
     * @param int $timelimit The time limit of the question.
     */
    public function set_timelimit(int $timelimit): void {
        $this->timelimit = $timelimit;
    }

    /**
     * Sets the explanation for the question.
     *
     * @param string $explanation The explanation of the question.
     */
    public function set_explanation(string $explanation): void {
        $this->explanation = $explanation;
    }

    /**
     * Checks if an answer is in the question.
     * @param int $answerid
     * @return bool
     */
    public function is_answer_in_question(int $answerid): bool {
        foreach ($this->get_answers() as $answer) {
            if ($answer->get_id() == $answerid) {
                return true;
            }
        }
        return false;
    }

    /**
     * Resets the id of the question such that it can be reused.
     */
    public function reset_id(): void {
        $this->set_id(0);
    }

    /**
     * Sets the type of the question.
     */
    public function set_type(int $type): void {
        $this->type = $type;
    }

    /**
     * Gets the type of the question.
     * 0 is checkbox, 1 is radiobutton
     * @return int|0 // Returns the type of the question, if it has one. 0 if it does not.
     */
    public function get_type(): int {
        return $this->type ?? 0;
    }

    /**
     * Prepares the template data for mustache.
     * The data object will hold the following properties:
     * - questionid
     * - questiontitle
     * - questiondescription
     * - questiontimelimit
     * - questionexplanation
     * - answers
     * - answertype
     * @param stdClass $data
     * @return stdClass
     */
    public function prepare_for_template(stdClass $data): stdClass {
        // Add to data object.
        $data->questionid = $this->id;
        $data->questiontitle = $this->title;
        $data->questiondescription = $this->description;
        $data->questiontimelimit = $this->timelimit;
        $data->questionexplanation = $this->explanation;
        $data->questiontype = $this->type == 1 ? 'radio' : 'checkbox';
        $data->answers = [];
        foreach ($this->answers as $answer) {
            $data->answers[] = [
                'answerid' => $answer->get_id(),
                'answerdescription' => $answer->get_description(),
                'answerexplanation' => $answer->get_explanation(),
                'answercorrect' => $answer->get_correct(),
            ];
        }
        return $data;
    }

    /**
     * Gets a question instance with answers.
     *
     * @param $id
     * @return question
     * @throws dml_exception
     */
    public static function get_question_with_answers_from_id($id): question {
        global $DB;
        $questioninstance = $DB->get_record('livequiz_questions', ['id' => $id]);
        $question = new question(
            $questioninstance->title,
            $questioninstance->description,
            $questioninstance->timelimit,
            $questioninstance->explanation
        );
        $question->set_id($questioninstance->id);
        $answers = questions_answers_relation::get_answers_from_question($id);
        $question->set_answers($answers);
        return $question;
    }
}
