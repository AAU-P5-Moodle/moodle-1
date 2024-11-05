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
 * LiveQuiz Service Test Class
 *
 * This class contains unit tests for the LiveQuiz service functionality.
 *
 * @package mod_livequiz
 * @copyright 2023
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_livequiz;

use dml_exception;
use mod_livequiz\models\livequiz;
use mod_livequiz\services\livequiz_services;
use mod_livequiz\models\question;
use mod_livequiz\models\answer;

/**
 * Testing examples for LiveQuiz service.
 */
final class livequiz_service_test extends \advanced_testcase {
    /**
     * Create a LiveQuiz instance for testing.
     *
     * @return livequiz The created LiveQuiz instance.
     * @throws dml_exception
     */
    protected function create_livequiz_for_test(): livequiz {
        $livequizdata = [
            'name' => 'Test LiveQuiz',
            'course' => 1,
            'intro' => 'This is a test livequiz.',
            'introformat' => 1,
            'timecreated' => time(),
            'timemodified' => time(),
        ];

        global $DB;
        $livequizid = $DB->insert_record('livequiz', $livequizdata);

        return livequiz::get_livequiz_instance($livequizid);
    }

    /**
     * Set up the test environment.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test retrieving the singleton service instance.
     *
     * @covers \mod_livequiz\services\livequiz_services::get_singleton_service_instance
     * @return void
     */
    public function test_get_singleton_service_instance(): void {
        $singleton = livequiz_services::get_singleton_service_instance();
        self::assertInstanceOf(livequiz_services::class, $singleton);

        $singleton2 = livequiz_services::get_singleton_service_instance();
        self::assertSame($singleton, $singleton2);
    }

    /**
     * Test creating a new question instance.
     *
     * @covers \mod_livequiz\models\question::__construct
     * @return void
     * @throws dml_exception
     */
    public function test_new_question(): void {
        $livequiz = $this->create_livequiz_for_test();
        $title = 'Test question';
        $description = 'This is a test question.';
        $timelimit = 60;
        $explanation = "I don't know.";

        $question = new question($title, $description, $timelimit, $explanation);

        self::assertInstanceOf(question::class, $question);
        self::assertEqualsIgnoringCase($title, $question->get_title());
        self::assertEqualsIgnoringCase($description, $question->get_description());
        self::assertEquals($timelimit, $question->get_timelimit());
        self::assertEqualsIgnoringCase($explanation, $question->get_explanation());
    }

    /**
     * Test creating a new answer instance.
     *
     * @covers \mod_livequiz\models\answer::__construct
     * @return void
     * @throws dml_exception
     */
    public function test_new_answer(): void {
        $livequiz = $this->create_livequiz_for_test();
        $title = 'Test question';
        $description = 'This is a test question.';
        $timelimit = 60;
        $explanation = "I don't know.";

        $question = new question($title, $description, $timelimit, $explanation);

        $correct = 1;
        $description = 'This is a test answer.';
        $explanation = "I don't know.";
        $answer = new answer($correct, $description, $explanation);
        $question->add_answer($answer);

        self::assertInstanceOf(answer::class, $answer);
        self::assertEquals($correct, $answer->get_correct());
        self::assertEqualsIgnoringCase($description, $answer->get_description());
        self::assertEqualsIgnoringCase($explanation, $answer->get_explanation());
    }

    /**
     * Test retrieving a LiveQuiz instance from the service.
     *
     * @covers \mod_livequiz\services\livequiz_services::get_livequiz_instance
     * @return void
     * @throws dml_exception
     */
    public function test_get_livequiz_instance(): void {
        $livequiz = $this->create_livequiz_for_test();
        $service = livequiz_services::get_singleton_service_instance();
        $livequiz2 = $service->get_livequiz_instance($livequiz->get_id());

        self::assertInstanceOf(livequiz::class, $livequiz2);
        self::assertEquals($livequiz->get_id(), $livequiz2->get_id());
        self::assertEqualsIgnoringCase($livequiz->get_name(), $livequiz2->get_name());
        self::assertEqualsIgnoringCase($livequiz->get_intro(), $livequiz2->get_intro());
        self::assertEquals($livequiz->get_timecreated(), $livequiz2->get_timecreated());
        self::assertEquals($livequiz->get_timemodified(), $livequiz2->get_timemodified());
    }

    public function test_create_livequiz(): void {
        $livequiz = $this->create_livequiz_for_test();
        $service = livequiz_services::get_singleton_service_instance();
        $questions = [
            new question('Test question 1', 'How much does a Polar Bear weigh?.', 45,
                "Come on a Polar bear has a weight."),
            new question('Test question 2', 'Where is north on a compass.', 46,
                "You need to answer where north is."),
            new question('Test question 3', 'Why is compressed air important for driving a truck.',
                100, "Compressed air is essential for driving a truck, but why?"),
        ];

        $answersquestion1 = [
            new answer(1, '350-550 kg', "A male Polar Bear weighs this much."),
            new answer(1, '150-350 kg', "A female Polar Bear weighs this much."),
            new answer(0, '600-800 kg',
                "Neither af female nor a male Polar Bear weighs this much"),
        ];

        $answersquestion2 = [
            new answer(1, 'N', "The letter N"),
            new answer(0, 'S', "The letter S"),
            new answer(0, 'W', "The letter W"),
        ];

        $answersquestion3 = [
            new answer(1, 'The compressed air ensures that the handbrake spring is not permanently on',
                "This correct as the air releases the spring"),
            new answer(0, 'The compressed air makes funny sounds.',
                "It does not make it sound funny"),
            new answer(1,
                'The compressed air ensures that gear changes happen, when switching from 1-6 gears to 7-12 gears',
                "This is correct as the air is needed for the force that is needed"),
        ];

        $questions[0]->add_answers($answersquestion1);
        $questions[1]->add_answers($answersquestion2);
        $questions[2]->add_answers($answersquestion3);

        $livequiz->add_questions($questions);

        $livequizresult = $service->submit_quiz($livequiz);

        self::assertEquals($livequiz, $livequizresult);
        self::assertEquals($livequiz->get_id(), $livequizresult->get_id());
        self::assertEqualsIgnoringCase($livequiz->get_name(), $livequizresult->get_name());
        self::assertEqualsIgnoringCase($livequiz->get_intro(), $livequizresult->get_intro());
        self::assertEquals($livequiz->get_timecreated(), $livequizresult->get_timecreated());
        self::assertEquals($livequiz->get_timemodified(), $livequizresult->get_timemodified());

        $questionsresult = $livequizresult->get_questions();
        self::assertCount(3, $questionsresult);
    }

    /**
     * Test submitting a LiveQuiz with questions and answers.
     *
     * @covers \mod_livequiz\services\livequiz_services::save_quiz
     * @return void
     * @throws dml_exception
     */
    public function test_submit_questions_with_answers(): void {
        $livequiz = $this->create_livequiz_for_test();
        $service = livequiz_services::get_singleton_service_instance();

        $title = 'Test question';
        $questiondescription = 'This is a test question.';
        $timelimit = 60;
        $questionexplanation = "I don't know.";
        $question = new question($title, $questiondescription, $timelimit, $questionexplanation);

        $correct = 1;
        $answerdescription = 'This is a test answer.';
        $answerexplanation = "I don't know this answer.";
        $answer = new answer($correct, $answerdescription, $answerexplanation);
        $question->add_answer($answer);
        $livequiz->add_question($question);

        $livequiz = $service->submit_quiz($livequiz);

        $questions = $livequiz->get_questions();

        self::assertCount(1, $questions);
        self::assertEqualsIgnoringCase($title, $questions[0]->get_title());
        self::assertEqualsIgnoringCase($questiondescription, $questions[0]->get_description());
        self::assertEquals($timelimit, $questions[0]->get_timelimit());
        self::assertEqualsIgnoringCase($questionexplanation, $questions[0]->get_explanation());

        $answers = $questions[0]->get_answers();
        self::assertCount(1, $answers);
        self::assertEquals($correct, $answers[0]->get_correct());
        self::assertEqualsIgnoringCase($answerdescription, $answers[0]->get_description());
        self::assertEqualsIgnoringCase($answerexplanation, $questions[0]->get_answers()[0]->get_explanation());
    }
}
