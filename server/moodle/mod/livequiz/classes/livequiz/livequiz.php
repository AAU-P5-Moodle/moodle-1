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

namespace mod_livequiz\livequiz;



use DateTime;
use dml_exception;
use dml_transaction_exception;
use mod_livequiz\answers\answers;
use mod_livequiz\question\question;
use mod_livequiz\questions_answers_relation\questions_answers_relation;
use mod_livequiz\quiz_questions_relation\quiz_questions_relation;
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
    private array $questions;


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
    public function __construct(int $id, string $name, int $course, string $intro, int $introformat, int $timecreated, int $timemodified) {
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
     * This method stores quiz data in the database.
     * Before calling this method, none of the quiz data is safe.
     * Please make sure that the quiz object is properly populated before using.
     * TODO:
     * Handle lecturer id such that the intermediate table can be updated accordingly.
     * @param livequiz $livequiz
     * @param array $questions // An array of question objects.
     * @return livequiz
     * @throws dml_exception
     * @throws dml_transaction_exception
     */
    public static function submit_quiz_to_database(livequiz $livequiz, array $questions): livequiz {
        $livequiz->set_questions($questions);
        foreach ($questions as $question) {
            $questionid = question::submit_question($question);

            // Inserting into the quiz_questions relation table.
            quiz_questions_relation::append_question_to_quiz($questionid, $livequiz->get_id());

            foreach ($question->get_answers() as $answer) {
                $answerid = answers::submit_answer($answer);

                // Inserting into the questions_answers relation table.
                questions_answers_relation::append_answer_to_question($questionid, $answerid);
            }
        }
        self::update_quiz($livequiz);
        return $livequiz;
    }


    /**
     * Gets a livequiz instance, with all relevant attributes.
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

        $livequiz = new livequiz(
            $quizinstance->id,
            $quizinstance->name,
            $quizinstance->course,
            $quizinstance->intro,
            $quizinstance->introformat,
            $quizinstance->timecreated,
            $quizinstance->timemodified
        );

        $questions = quiz_questions_relation::get_questions_from_quiz_id($id);

        $livequiz->questions = $questions;

        return $livequiz;
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
     * Gets the ID for the assicated course
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
     * Gets the format for the introduction.
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
     * Sets the timemodified field to the current time.
     *
     * @return int
     */
    public function set_timemodified(): int {
        return $this->timemodified = time();
    }

    /**
     * Sets the questions associated with the livequiz.
     *
     * @param array $questions
     */
    public function set_questions($questions): void {
        $this->questions = $questions;
    }

    /**
     * Updates the livequiz in the database, and updates the timemodified field.
     *
     * @param livequiz $livequiz
     * @return bool
     * @throws dml_exception
     */
    private static function update_quiz(livequiz $livequiz): bool {
        global $DB;

        // Update the timemodified field.
        $livequiz->set_timemodified();

        // Create an object with the necessary fields for updating.
        $record = new stdClass();
        $record->id = $livequiz->get_id();
        $record->timemodified = $livequiz->get_timemodified();
        // Add other fields here if necessary.

        // Update the record in the database.
        return $DB->update_record('livequiz', $record);
    }
}
