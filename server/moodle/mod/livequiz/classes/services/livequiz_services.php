<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace mod_livequiz\services;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../models/livequiz.php');
require_once(__DIR__ . '/../models/question.php');
require_once(__DIR__ . '/../models/answer.php');
require_once(__DIR__ . '/../models/questions_answers_relation.php');
require_once(__DIR__ . '/../models/quiz_questions_relation.php');

use dml_exception;
use dml_transaction_exception;

use mod_livequiz\models\answer;
use mod_livequiz\models\livequiz;
use mod_livequiz\models\question;
use mod_livequiz\models\questions_answers_relation;
use mod_livequiz\models\quiz_questions_relation;

/**
 * Class livequiz_services
 *
 * This class represents the service layer for handling the models.
 *
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class livequiz_services {
    /**
     * @var livequiz_services|null $instance
     */
    private static ?livequiz_services $instance = null;

    /**
     * livequiz_services constructor.
     */
    private function __construct() {
    }

    /**
     * Create a singleton instance of the livequiz_services class.
     *
     * @return livequiz_services
     */
    public static function get_singleton_service_instance(): livequiz_services {
        if (self::$instance == null) {
            self::$instance = new livequiz_services();
        }
        return self::$instance;
    }

    /**
     * Gets, and constructs, a livequiz instance from the database.
     *
     * @throws dml_exception
     */
    public function get_livequiz_instance(int $id): livequiz {
        $livequiz = livequiz::get_livequiz_instance($id);

        $questions = $this->get_questions_with_answers($id);

        $livequiz->add_questions($questions);

        return $livequiz;
    }

    /**
     * Constructs a new question object and appends it to the livequiz object.
     *
     * @param livequiz $livequiz
     * @param string $title
     * @param string $description
     * @param int $timelimit
     * @param string $explanation
     * @return question
     */
    public function new_question(
        livequiz $livequiz,
        string $title,
        string $description,
        int $timelimit,
        string $explanation
    ): question {
        $questiondata = new question($title, $description, $timelimit, $explanation);

        $livequiz->add_questions([$questiondata]);
        return new question($title, $description, $timelimit, $explanation);
    }

    /**
     * Constructs a new answer object and appends it to the question object.
     *
     * @param question $question
     * @param int $correct
     * @param string $description
     * @param string $explanation
     * @return answer
     */
    public function new_answer(question $question, int $correct, string $description, string $explanation): answer {
        $question->add_answer(new answer($correct, $description, $explanation));
        return new answer($correct, $description, $explanation);
    }

    /**
     *  This method stores quiz data in the database.
     *  Before calling this method, none of the quiz data is safe.
     *  Please make sure that the quiz object is properly populated before using.
     *  TODO:
     *  Handle lecturer id such that the intermediate table can be updated accordingly.
     *
     * @throws dml_exception
     */
    public function submit_quiz(livequiz $livequiz): livequiz {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        try {
            $livequiz->update_quiz();

            $quizid = $livequiz->get_id();
            $questions = $livequiz->get_questions();

            $this->submit_questions($quizid, $questions);

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
            throw $e;
        }
        return $this->get_livequiz_instance($quizid);
    }

    /**
     * Submits questions to the database.
     *
     * @throws dml_transaction_exception
     * @throws dml_exception
     */
    private function submit_questions(int $quizid, array $questions): void {
        foreach ($questions as $question) {
            $questionid = question::submit_question($question);

            quiz_questions_relation::append_question_to_quiz($questionid, $quizid);
            $this::submit_answers($questionid, $question->get_answers());
        }
    }

    /**
     * Submits answers to the database.
     *
     * @throws dml_transaction_exception
     * @throws dml_exception
     */
    private function submit_answers(int $questionid, array $answers): void {
        foreach ($answers as $answer) {
            $answerid = answer::submit_answer($answer);
            questions_answers_relation::append_answer_to_question($questionid, $answerid);
        }
    }



    /**
     * Gets questions with answers from the database.
     *
     * @throws dml_exception
     */
    private function get_questions_with_answers(int $quizid): array {
        $questions = quiz_questions_relation::get_questions_from_quiz_id($quizid);

        foreach ($questions as $question) {
            $answers = questions_answers_relation::get_answers_from_question($question->get_id());
            $question->add_answers($answers);
        }
        return $questions;
    }
}
