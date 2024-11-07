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
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_livequiz;

use dml_exception;
use mod_livequiz\models\livequiz;
use mod_livequiz\services\livequiz_services;
use mod_livequiz\models\question;
use mod_livequiz\models\answer;
use PhpXmlRpc\Exception;

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
     * Create a LiveQuiz instance with questions and answers for testing.
     *
     * @return livequiz The created LiveQuiz instance.
     * @throws dml_exception
     */
    protected function create_livequiz_with_questions_and_answers_for_test(): livequiz {
        $livequiz = $this->create_livequiz_for_test();

        $questions = [
            new question(
                'Test question 1',
                'How much does a Polar Bear weigh?.',
                45,
                "Come on a Polar bear has a weight."
            ),
            new question(
                'Test question 2',
                'Where is north on a compass.',
                46,
                "You need to answer where north is."
            ),
            new question(
                'Test question 3',
                'Why is compressed air important for driving a truck.',
                100,
                "Compressed air is essential for driving a truck, but why?"
            ),
        ];

        $answersquestion1 = [
            new answer(1, '350-550 kg', "A male Polar Bear weighs this much."),
            new answer(1, '150-350 kg', "A female Polar Bear weighs this much."),
            new answer(
                0,
                '600-800 kg',
                "Neither af female nor a male Polar Bear weighs this much."
            ),
        ];

        $answersquestion2 = [
            new answer(1, 'N', "The letter N"),
            new answer(0, 'S', "The letter S"),
            new answer(0, 'W', "The letter W"),
        ];

        $answersquestion3 = [
            new answer(
                1,
                'The compressed air ensures that the handbrake spring is not permanently on',
                "This correct as the air releases the spring"
            ),
            new answer(
                0,
                'The compressed air makes funny sounds.',
                "It does not make it sound funny"
            ),
            new answer(
                1,
                'The compressed air ensures that gear changes happen, when switching from 1-6 gears to 7-12 gears',
                "This is correct as the air is needed for the force that is needed"
            ),
        ];

        $questions[0]->add_answers($answersquestion1);
        $questions[1]->add_answers($answersquestion2);
        $questions[2]->add_answers($answersquestion3);

        $livequiz->add_questions($questions);

        return $livequiz;
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

    /**
     * Test creating a new LiveQuiz instance.
     *
     * @covers \mod_livequiz\services\livequiz_services::submit_quiz
     * @return void
     * @throws dml_exception|Exception
     */
    public function test_create_livequiz(): void {
        $livequiz = $this->create_livequiz_with_questions_and_answers_for_test();
        $service = livequiz_services::get_singleton_service_instance();
        $livequizresult = $service->submit_quiz($livequiz);
        $questions = $livequiz->get_questions();

        // Assert properties of the LiveQuiz remain the same.
        self::assertEquals($livequiz->get_id(), $livequizresult->get_id());
        self::assertEqualsIgnoringCase($livequiz->get_name(), $livequizresult->get_name());
        self::assertEqualsIgnoringCase($livequiz->get_intro(), $livequizresult->get_intro());
        self::assertEquals($livequiz->get_timecreated(), $livequizresult->get_timecreated());
        self::assertEquals($livequiz->get_timemodified(), $livequizresult->get_timemodified());

        // The amount of questions remain the same.
        $questionsresult = $livequizresult->get_questions();
        self::assertCount(count($questions), $questionsresult);

        // Assert properties of the questions and their answers remain the same.
        for ($i = 0; $i < count($questions); $i++) {
            self::assertEquals($questions[$i]->get_title(), $questionsresult[$i]->get_title());
            self::assertEquals($questions[$i]->get_description(), $questionsresult[$i]->get_description());
            self::assertEquals($questions[$i]->get_timelimit(), $questionsresult[$i]->get_timelimit());
            self::assertEquals($questions[$i]->get_explanation(), $questionsresult[$i]->get_explanation());

            $answers = $questions[$i]->get_answers();
            $answersresult = $questionsresult[$i]->get_answers();
            self::assertCount(count($answers), $answersresult);
            for ($j = 0; $j < count($answers); $j++) {
                self::assertEquals($answers[$j]->get_correct(), $answersresult[$j]->get_correct());
                self::assertEquals($answers[$j]->get_description(), $answersresult[$j]->get_description());
                self::assertEquals($answers[$j]->get_explanation(), $answersresult[$j]->get_explanation());
            }
        }
    }

    /**
     * Test updating a LiveQuiz instance.
     * The asserts in this test are very manual and could be improved,
     * but as it turns out, cloning objects with arrays is a pain in PHP.
     * @covers \mod_livequiz\services\livequiz_services::submit_quiz
     * @return void
     * @throws dml_exception|Exception
     */
    public function test_update_livequiz(): void {
        $livequiz = $this->create_livequiz_with_questions_and_answers_for_test();
        $service = livequiz_services::get_singleton_service_instance();

        $firstlivequiz = $service->submit_quiz($livequiz);
        $questions = $firstlivequiz->get_questions();

        $questions[0]->set_title('New title');
        $questions[0]->set_description('New description');
        $questions[0]->set_timelimit(100);
        $questions[0]->set_explanation('New explanation');
        $newanswers = $questions[0]->get_answers();
        $newanswers[0]->set_correct(0);
        $newanswers[0]->set_description('New description');
        $newanswers[0]->set_explanation('New explanation');

        $firstlivequiz->set_questions($questions);
        $updatedlivequiz = $service->submit_quiz($firstlivequiz);

        // Assert that the specific question was updated.
        $finalquestions = $updatedlivequiz->get_questions();
        self::assertEquals($questions, $finalquestions);
        self::assertEquals('New title', $finalquestions[0]->get_title());
        self::assertEquals('New description', $finalquestions[0]->get_description());
        self::assertEquals(100, $finalquestions[0]->get_timelimit());
        self::assertEquals('New explanation', $finalquestions[0]->get_explanation());

        // Assert the first answer, to the first question, has changed.
        $finalanswers = $finalquestions[0]->get_answers();
        self::assertEquals(0, $finalanswers[0]->get_correct());
        self::assertEquals('New description', $finalanswers[0]->get_description());
        self::assertEquals('New explanation', $finalanswers[0]->get_explanation());

        // Assert that answers two and three remain the same.
        self::assertEquals(1, $finalanswers[1]->get_correct());
        self::assertEquals('150-350 kg', $finalanswers[1]->get_description());
        self::assertEquals('A female Polar Bear weighs this much.', $finalanswers[1]->get_explanation());

        self::assertEquals(0, $finalanswers[2]->get_correct());
        self::assertEquals('600-800 kg', $finalanswers[2]->get_description());
        self::assertEquals('Neither af female nor a male Polar Bear weighs this much.', $finalanswers[2]->get_explanation());

        // Assert that the other questions remain the same.
        self::assertEquals($questions[1], $finalquestions[1]);
        self::assertEquals($questions[2], $finalquestions[2]);
    }
}
