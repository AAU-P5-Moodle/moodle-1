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

use advanced_testcase;
use dml_exception;
use dml_transaction_exception;
use Error;
use mod_livequiz\models\livequiz;
use mod_livequiz\models\student_answers_relation;
use mod_livequiz\repositories\answer_repository;
use mod_livequiz\services\livequiz_services;
use mod_livequiz\models\question;
use mod_livequiz\models\answer;
use mod_livequiz\models\participation;
use PhpXmlRpc\Exception;

/**
 * Testing examples for LiveQuiz service.
 */
final class livequiz_service_test extends advanced_testcase {
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
            'activity_id' => 1,
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
     * Create participation test data.
     * @return array
     */
    protected function create_participation_data_for_test(): array {
        return  $participationdata = [
            'studentid' => 2,
            'quizid' => 1,
        ];
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
     * Test that get_newest_participation_for_quiz gets the newest participation based on studentid and quizid
     * @covers \mod_livequiz\services\livequiz_services::get_newest_participation_for_quiz
     * @throws dml_transaction_exception
     * @throws dml_exception
     */
    public function test_get_newest_participation_for_quiz(): void {
        $dbservice = livequiz_services::get_singleton_service_instance();
        $participation1 = $dbservice->insert_participation(1, 1);
        $participation2 = $dbservice->insert_participation(1, 1);

        $testparticipation = $dbservice->get_newest_participation_for_quiz(1, 1);

        $this->assertEquals($participation2->get_id(), $testparticipation->get_id());

        $participation3 = $dbservice->insert_participation(1, 1);

        $testparticipation2 = $dbservice->get_newest_participation_for_quiz(1, 1);

        $this->assertEquals($participation3->get_id(), $testparticipation2->get_id());
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
     */
    public function test_new_answer(): void {
        $title = 'Test question';
        $description = 'This is a test question for testing purposes.';
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
        $lecturerid = "2";
        $livequiz = $this->create_livequiz_with_questions_and_answers_for_test();
        $service = livequiz_services::get_singleton_service_instance();
        $livequizresult = $service->submit_quiz($livequiz, $lecturerid);
        $questions = $livequizresult->get_questions();
        // Assert properties of the LiveQuiz remain the same.
        self::assertEquals($livequiz->get_id(), $livequizresult->get_id());
        self::assertEqualsIgnoringCase($livequiz->get_name(), $livequizresult->get_name());
        self::assertEqualsIgnoringCase($livequiz->get_intro(), $livequizresult->get_intro());
        self::assertEquals($livequiz->get_timecreated(), $livequizresult->get_timecreated());
        self::assertEquals($livequiz->get_timemodified(), $livequizresult->get_timemodified());


        $getlecturer = $service->get_livequiz_question_lecturer($questions[0]->get_id());
        self::assertEquals($getlecturer['lecturer_id'], $lecturerid);

        $getquiz = $service->get_livequiz_quiz_lecturer($livequiz->get_id());
        self::assertEquals($getquiz['lecturer_id'], $lecturerid);


        // The amount of questions remains the same.
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
        $lecturerid = "2";
        $livequiz = $this->create_livequiz_with_questions_and_answers_for_test();
        $service = livequiz_services::get_singleton_service_instance();
        $firstlivequiz = $service->submit_quiz($livequiz, $lecturerid);
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
        $updatedlivequiz = $service->submit_quiz($firstlivequiz, $lecturerid);

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

    /**
     * Test of new_participation
     * @covers \mod_livequiz\services\livequiz_services::new_participation
     */
    public function test_insert_participation(): void {
        $participationdata = $this->create_participation_data_for_test();
        $service = livequiz_services::get_singleton_service_instance();

        $actualstudentid = $participationdata['studentid'];
        $acutalquizid = $participationdata['quizid'];

        $participation = $service->insert_participation($actualstudentid, $acutalquizid);
        $this->assertInstanceOf(participation::class, $participation);
        $this->assertEquals($participation->get_studentid(), $actualstudentid);
        $this->assertEquals($participation->get_livequizid(), $acutalquizid);
    }

    /**
     * Test getting answers from a student in participation.
     *
     * @covers \mod_livequiz\services\livequiz_services::submit_quiz
     * @covers \mod_livequiz\services\livequiz_services::delete_question
     * @return void
     * @throws dml_exception
     */
    public function test_get_answers_from_student_in_participation(): void {
        global $DB;
        $service = livequiz_services::get_singleton_service_instance();
        $livequiz = $this->create_livequiz_with_questions_and_answers_for_test();
        $question = $livequiz->get_questions()[0];
        $answers = $question->get_answers();
        $answercount = count($answers);

        $answerswithid = [];

        // Insert answers into db.
        for ($i = 0; $i < $answercount; $i++) {
            $answerid = $service->insert_answer($answers[$i]);
            $answerswithid[] = $service->get_answer_from_id($answerid); // This ensures id's are set since set_id() is private.
            // Simulate answers where studentid = 1 ; participationid = 1.
            $DB->insert_record('livequiz_students_answers', [
                'student_id' => 1,
                'answer_id' => $answerid,
                'participation_id' => 1,
            ]);
        }
        // Fetch all answers for studentid = 1 ; participationid = 1.
        $returnedanswers = $service->get_answers_from_student_in_participation(1, 1);

        $this->assertEquals($answerswithid[0]->get_id(), $returnedanswers[0]->get_id());
        $this->assertEquals($answerswithid[0]->get_correct(), $returnedanswers[0]->get_correct());
        $this->assertEquals($answerswithid[0]->get_description(), $returnedanswers[0]->get_description());
        $this->assertEquals($answerswithid[0]->get_explanation(), $returnedanswers[0]->get_explanation());

        $this->assertEquals($answerswithid[1]->get_id(), $returnedanswers[1]->get_id());
        $this->assertEquals($answerswithid[1]->get_correct(), $returnedanswers[1]->get_correct());
        $this->assertEquals($answerswithid[1]->get_description(), $returnedanswers[1]->get_description());
        $this->assertEquals($answerswithid[1]->get_explanation(), $returnedanswers[1]->get_explanation());

        $this->assertEquals($answerswithid[2]->get_id(), $returnedanswers[2]->get_id());
        $this->assertEquals($answerswithid[2]->get_correct(), $returnedanswers[2]->get_correct());
        $this->assertEquals($answerswithid[2]->get_description(), $returnedanswers[2]->get_description());
        $this->assertEquals($answerswithid[2]->get_explanation(), $returnedanswers[2]->get_explanation());
    }

    /**
     * Tests deleting a question from the database
     *
     * @covers \mod_livequiz\services\livequiz_services::submit_quiz
     * @throws dml_exception
     * @throws Exception
     */
    public function test_delete_question(): void {
        $lecturerid = "2";
        $service = livequiz_services::get_singleton_service_instance();
        $testquiz = $this->create_livequiz_with_questions_and_answers_for_test();

        $testquizquestions = $testquiz->get_questions();

        $testquizsubmitted = $service->submit_quiz($testquiz, $lecturerid);
        $testquizsubmittedquestions = $testquizsubmitted->get_questions();

        array_shift($testquizsubmittedquestions);
        $testquizsubmitted->set_questions($testquizsubmittedquestions);

        $testquizresubmitted = $service->submit_quiz($testquizsubmitted, $lecturerid);
        $testquizresubmittedquestions = $testquizsubmitted->get_questions();

        // Assert that the amount of questions has changed.
        $this->assertNotSameSize($testquizquestions, $testquizresubmittedquestions);
        // Assert that the first two questions are question 2 and 3, since 1 was deleted.
        $this->assertEquals('Test question 2', $testquizresubmittedquestions[0]->get_title());
        $this->assertEquals('Where is north on a compass.', $testquizresubmittedquestions[0]->get_description());
        $this->assertEquals(46, $testquizresubmittedquestions[0]->get_timelimit());
        $this->assertEquals("You need to answer where north is.", $testquizresubmittedquestions[0]->get_explanation());

        $this->assertEquals('Test question 3', $testquizresubmittedquestions[1]->get_title());
        $this->assertEquals(
            'Why is compressed air important for driving a truck.',
            $testquizresubmittedquestions[1]->get_description()
        );
        $this->assertEquals(100, $testquizresubmittedquestions[1]->get_timelimit());
        $this->assertEquals(
            "Compressed air is essential for driving a truck, but why?",
            $testquizresubmittedquestions[1]->get_explanation()
        );
    }

    /**
     * Test that deleting a question, with a relation, throws an exception.
     *
     * @covers \mod_livequiz\services\livequiz_services::submit_quiz
     * @throws dml_exception
     * @throws Exception
     */
    public function test_delete_question_throws_if_relation_exist(): void {
        $lecturerid = "2";
        $service = livequiz_services::get_singleton_service_instance();
        $testquiz = $this->create_livequiz_with_questions_and_answers_for_test();

        $testquizsubmitted = $service->submit_quiz($testquiz, $lecturerid);
        $testquizsubmittedquestions = $testquizsubmitted->get_questions();
        $studentanswertestdata = [
            'studentid' => 1,
            'participationid' => 1,
            'answerid' => $testquizsubmittedquestions[0]->get_answers()[0]->get_id(),
        ];

        student_answers_relation::insert_student_answer_relation(
            $studentanswertestdata['studentid'],
            $studentanswertestdata['answerid'],
            $studentanswertestdata['participationid']
        );

        array_shift($testquizsubmittedquestions);
        $testquizsubmitted->set_questions($testquizsubmittedquestions);

        // This sets up the test to expect the exception later in the code.
        $this->expectException(dml_exception::class);
        $this->expectExceptionMessage('error/Cannot delete answer with participations');

        // This is the actual test where the exception is thrown.
        $service->submit_quiz($testquizsubmitted, $lecturerid);
        $testquizresubmittedquestions = $testquizsubmitted->get_questions();
    }

    /**
     * Test deleting an answer.
     *
     * @covers \mod_livequiz\services\livequiz_services::submit_quiz
     * @covers \mod_livequiz\services\livequiz_services::delete_answer
     * @throws dml_exception
     * @throws Exception
     */
    public function test_delete_answer(): void {
        $lecturerid = "2";
        $service = livequiz_services::get_singleton_service_instance();
        $testquiz = $this->create_livequiz_with_questions_and_answers_for_test();

        $testquizquestions = $testquiz->get_questions();
        $testquizfirstquestionanswers = $testquizquestions[0]->get_answers();
        $testquizsubmitted = $service->submit_quiz($testquiz, $lecturerid);
        $testquizsubmittedquestions = $testquizsubmitted->get_questions();
        $testquizsubmittedanswers = $testquizsubmittedquestions[0]->get_answers();
        array_shift($testquizsubmittedanswers);
        $testquizsubmittedquestions[0]->set_answers($testquizsubmittedanswers);
        $testquizsubmitted->set_questions($testquizsubmittedquestions);

        $testquizresubmitted = $service->submit_quiz($testquizsubmitted, $lecturerid);
        $testquizresubmittedquestions = $testquizresubmitted->get_questions();
        $testquizresubmittedanswers = $testquizresubmittedquestions[0]->get_answers();

        // Assert that the amount of questions has changed.
        $this->assertNotSameSize($testquizfirstquestionanswers, $testquizresubmittedanswers);
        // Assert that the first two questions are question 2 and 3, since 1 was deleted.
        $this->assertEquals(1, $testquizresubmittedanswers[0]->get_correct());
        $this->assertEquals('150-350 kg', $testquizresubmittedanswers[0]->get_description());
        $this->assertEquals(
            'A female Polar Bear weighs this much.',
            $testquizresubmittedanswers[0]->get_explanation()
        );

        $this->assertEquals(0, $testquizresubmittedanswers[1]->get_correct());
        $this->assertEquals('600-800 kg', $testquizresubmittedanswers[1]->get_description());
        $this->assertEquals(
            'Neither af female nor a male Polar Bear weighs this much.',
            $testquizresubmittedanswers[1]->get_explanation()
        );
    }

    /**
     * tests that initate_livequiz returns a correct name and intro for a livequiz
     *
     * @covers \mod_livequiz\services\livequiz_services::initiate_livequiz
     * @throws dml_exception
     * @throws Exception
     */
    public function test_initiate_livequiz(): void {
        $service = livequiz_services::get_singleton_service_instance();
        $livequiz = $this->create_livequiz_with_questions_and_answers_for_test();
        $livequiz = $service->submit_quiz($livequiz, 1);

        [$title, $description] = $service->initiate_livequiz($livequiz->get_id());
        $this->assertEquals($title, $livequiz->get_name());
        $this->assertEquals($description, $livequiz->get_intro());
    }

    /**
     * Tests retrieving a question by its index.
     *
     * @covers \mod_livequiz\services\livequiz_services::get_question_by_index
     * @throws Exception
     * @throws dml_exception
     */
    public function test_get_question_by_index(): void {
        $service = livequiz_services::get_singleton_service_instance();
        $livequiz = $this->create_livequiz_with_questions_and_answers_for_test();
        $livequiz = $service->submit_quiz($livequiz, 1);

        [$question, $index] = $service->get_question_by_index($livequiz->get_id(), 0);
        $this->assertEquals(0, $index);
        $this->assertEquals('Test question 1', $question->get_title());
        $this->assertEquals('How much does a Polar Bear weigh?.', $question->get_description());
        $this->assertEquals(45, $question->get_timelimit());
        $this->assertEquals("Come on a Polar bear has a weight.", $question->get_explanation());
    }

    /**
     * Tests the get_sanitized_answer method, with the correct values, and no correct status.
     *
     * @covers \mod_livequiz\services\livequiz_services::get_sanitized_answers
     * @throws Exception
     * @throws dml_exception
     */
    public function test_get_sanitized_answer(): void {
        $service = livequiz_services::get_singleton_service_instance();
        $livequiz = $this->create_livequiz_with_questions_and_answers_for_test();
        $livequiz = $service->submit_quiz($livequiz, 1);

        $answers = $livequiz->get_questions()[0]->get_answers();
        $questions = $livequiz->get_questions();

        foreach ($questions as $question) {
            $sanitizedanswers = $service->get_sanitized_answers($question->get_id());
            foreach ($sanitizedanswers as $sanitizedanswer) {
                $this->assertEquals($answers[0]->get_description(), $sanitizedanswer->description);
                $this->assertEquals($answers[0]->get_explanation(), $sanitizedanswer->explanation);
                $this->expectException(Error::class);
                $this->expectExceptionMessage('Call to undefined method stdClass::get_correct()');
                $sanitizedanswer->get_correct();
            }
        }
    }

    /**
     * Tests the student answer submission.
     *
     * @covers \mod_livequiz\services\livequiz_services::student_answer_submission
     * @throws Exception
     * @throws dml_exception
     */
    public function test_student_answer_submission(): void {
        $livequiz = $this->create_livequiz_with_questions_and_answers_for_test();
        $service = livequiz_services::get_singleton_service_instance();
        $livequiz = $service->submit_quiz($livequiz, 1);

        $studentid = 1;
        $participationid = 1;

        foreach ($livequiz->get_questions() as $question) {
            $answers = $question->get_answers();
            $answerid = $answers[0]->get_id();
            $service->student_answer_submission($studentid, $answerid, $participationid);
            $this->assertEquals(1, student_answers_relation::get_answer_participation_count($answerid));
        }
    }


    /**
     * Tests the get_student_answers_for_question method.
     *
     * @covers \mod_livequiz\services\livequiz_services::get_student_answers_for_question
     * @throws Exception
     * @throws dml_exception
     */
    public function test_get_student_answers_for_question(): void {
        // MOCK.
        // Create & submit a livequiz with questions and answers.
        $livequiz = $this->create_livequiz_with_questions_and_answers_for_test();
        $service = livequiz_services::get_singleton_service_instance();
        $service->submit_quiz($livequiz, 1);
        $submittedlivequizinstance = $service->get_livequiz_instance($livequiz->get_id());

        // ACT.
        // Participate in the quiz.
        $studentid = 1;
        $participationid = $service->insert_participation($studentid, $livequiz->get_id())->get_id();

        // Insert student answers.
        $quizquestions = $submittedlivequizinstance->get_questions();
        foreach ($quizquestions as $question) {
            $answers = $question->get_answers();
            $answerid = $answers[0]->get_id();
            $service->insert_answer_choice($studentid, $answerid, $participationid);
        }

        // ASSERT.
        foreach ($quizquestions as $question) {
            $answers = $service->get_student_answers_for_question($question->get_id(), $submittedlivequizinstance->get_id());
            $this->assertEquals(1, count($answers));
            $this->assertEquals($answers[0]['studentid'], $studentid);
            $this->assertEquals($question->get_answers()[0]->get_correct(), $answers[0]['correct']);
            $this->assertEquals(!$question->get_answers()[0]->get_correct(), $answers[0]['incorrect']);
        }
    }
}
