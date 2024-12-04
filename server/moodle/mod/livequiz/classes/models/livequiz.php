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
use InvalidArgumentException;
use RuntimeException;
use stdClass;

/**
 * Class livequiz
 *
 * This class represents a livequiz in the LiveQuiz module.
 * It handles creation, retrieval, and updates of livequizzes and their associated questions.
 *
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class livequiz {
    /**
     * @var int $id
     */
    private int $id;

    /**
     * @var string $name
     */
    private string $name;

    /**
     * @var int $course
     */
    private int $course;

    /**
     * @var string $intro
     */
    private string $intro;

    /**
     * @var int $introformat
     */
    private int $introformat;

    /**
     * @var int $timecreated
     */
    private int $timecreated;

    /**
     * @var int $timemodified
     */
    private int $timemodified;

    /**
     * @var array $questions
     */
    private array $questions = [];

    /**
     * Constructor for the livequiz class. Returns the object.
     *
     * @param int $id
     * @param string $name
     * @param int $course
     * @param string $intro
     * @param int $introformat
     * @param int $timecreated
     * @param int $timemodified
     */
    private function __construct(
        int $id,
        string $name,
        int $course,
        string $intro,
        int $introformat,
        int $timecreated,
        int $timemodified
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->course = $course;
        $this->intro = $intro;
        $this->introformat = $introformat;
        $this->timecreated = $timecreated;
        $this->timemodified = $timemodified;

        return $this;
    }

    /**
     * Gets a livequiz instance from the DB, with all relevant attributes.
     *
     * TODO implement associated lecturer.
     *
     * @param int $id
     * @return livequiz
     * @throws dml_exception
     */
    public static function get_livequiz_instance(int $id): livequiz {
        global $DB;
        $quizinstance = $DB->get_record('livequiz', ['id' => $id]);

        return new livequiz(
            $quizinstance->id,
            $quizinstance->name,
            $quizinstance->course,
            $quizinstance->intro,
            $quizinstance->introformat,
            $quizinstance->timecreated,
            $quizinstance->timemodified
        );
    }

    /**
     * Gets the associated ID for the livequiz.
     *
     * @return int
     */
    public function get_id(): int {
        return $this->id;
    }

    /**
     * Gets the name of the livequiz.
     *
     * @return string
     */
    public function get_name(): string {
        return $this->name;
    }

    /**
     * Gets the ID for the associated course.
     *
     * @return int
     */
    public function get_course(): int {
        return $this->course;
    }

    /**
     * Gets the introduction for the livequiz.
     *
     * @return string
     */
    public function get_intro(): string {
        return $this->intro;
    }

    /**
     * Gets the introduction format for the livequiz.
     *
     * @return int
     */
    public function get_introformat(): int {
        return $this->introformat;
    }

    /**
     * Gets the time the livequiz was created.
     *
     * @return int
     */
    public function get_timecreated(): int {
        return $this->timecreated;
    }

    /**
     * Gets the time the livequiz was last modified.
     *
     * @return int
     */
    public function get_timemodified(): int {
        return $this->timemodified;
    }

    /**
     * Gets the questions associated with the livequiz.
     *
     * @return array
     */
    public function get_questions(): array {
        return $this->questions;
    }

    /**
     * Removes a question from the livequiz
     * @param int $questionid
     * @return bool was a question with the specified id found and removed form the questions.
     */
    public function remove_question_by_id(int $questionid): bool {
        $questions = $this->get_questions();

        // Filter out the question with the given ID.
        $filteredquestions = array_filter($questions, function ($question) use ($questionid) {
            return $question->get_id() !== $questionid;
        });

        // If the number of questions has decreased, a question was removed.
        if (count($questions) > count($filteredquestions)) {
            $this->set_questions($filteredquestions);
            return true;
        }
        return false; // No question was removed.
    }

    /**
     * Gets a question from the livequiz
     * @param int $questionid
     * @return question was a question with the specified id found and removed form the questions.
     */
    public function get_question_by_id(int $questionid): question {
        $questions = $this->get_questions();
        $questionwithid = null;
        foreach ($questions as $question) {
            if ($question->get_id() === $questionid) {
                // If we already found a question, it means that there are questions with duplicate id.
                if ($questionwithid !== null) {
                    throw new RuntimeException("Something is wrong. Multiple questions found with id {$questionid}");
                }
                $questionwithid = $question;
            }
        }
        if ($questionwithid === null) {
            throw new InvalidArgumentException("Could not find question with id {$questionid}");
        }
        return $questionwithid;
    }

    /**
     * Getter that gets the question object in the parsed index
     * @param int $index the index of the question
     * @return question
     */
    public function get_question_by_index(int $index): question {
        return $this->questions[$index];
    }


    /**
     * Sets the timemodified field to the current time.
     *
     * @return int
     */
    public function set_timemodified(): int {
        return $this->timemodified = time();
    }

    /**
     * Append the questions associated with the livequiz.
     *
     * @param array $questions
     */
    public function add_questions(array $questions): void {
        foreach ($questions as $question) {
            $this->add_question($question);
        }
    }

    /**
     * Appends a question
     *
     * @param question $question
     */
    public function add_question(question $question): void {
        $this->questions[] = $question;
    }

    /**
     *
     * Sets questions for the livequiz.
     * @param array $questions
     */
    public function set_questions(array $questions): void {
        $this->questions = $questions;
    }
    /**
     * Prepares the template data for mustache.
     * The data object will hold the following properties:
     * - quizid
     * - quiztitle
     * - numberofquestions
     * - questions
     *
     * Each question will have the following properties:
     * - questionid
     * - questiontitle
     * - questiondescription
     * - questiontimelimit
     * - questionexplanation
     * - answers
     * - answertype
     * @return stdClass
     */
    public function prepare_for_template(): stdClass {
        // Prepare data object.
        $data = new stdClass();

        $data->quizid = $this->id;
        $data->quiztitle = $this->get_name();
        $data->numberofquestions = count($this->get_questions());

        // Prepare questions.
        $rawquestions = $this->questions;

        $data->questions = [];
        foreach ($rawquestions as $rawquestion) {
            $data->questions[] = $rawquestion->prepare_for_template(new stdClass());
        }
        return $data;
    }

    /**
     * Prepares the template data for mustache.
     * @param int $questionindex
     * @return stdClass
     */
    public function prepare_question_for_template(int $questionindex): stdClass {
        // Prepare data object.
        $data = new stdClass();
        $data->quizid = $this->id;
        $data->quiztitle = $this->name;
        $data->numberofquestions = count($this->get_questions());
        if ($data->numberofquestions > 0) {
            $question = $this->get_question_by_index($questionindex);
            $data = $question->prepare_for_template($data);
        }
        return $data;
    }
}
