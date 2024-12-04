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
 * Unit tests for class livequiz.
 *
 * @package    mod_livequiz
 * @category   test
 * @copyright  2023
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_livequiz;

use advanced_testcase;
use InvalidArgumentException;
use mod_livequiz\models\question;
use RuntimeException;
use stdClass;
use ReflectionException;
use function PHPUnit\Framework\assertEquals;


defined('MOODLE_INTERNAL') || die();
require_once(__DIR__ . '/../test_utility.php');

/**
 * Test class for livequiz class
 */
final class livequiz_test extends advanced_testcase {
    /**
     * Setup that runs before each test in the file
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
    }

    /**
     * Tests the function prepare_for_template()
     *
     * @covers       \mod_livequiz\models\livequiz::prepare_for_template
     * @dataProvider dataprovider
     * prepare_for_template() should return a stdClass object, data, for use in mustache templates
     * data should have the fields: quizid, quiztitle, numberofquestions, questions.
     * @throws ReflectionException
     */
    public function test_livequiz_prepare_for_template(
        int $quizid,
        string $quiztitle,
        int $courseid,
        string $intro,
        int $introformat,
        int $timecreated,
        int $timemodified,
        array $questions
    ): void {
        $livequiz = test_utility::constructlivequiz(
            $quizid,
            $quiztitle,
            $courseid,
            $intro,
            $introformat,
            $timecreated,
            $timemodified
        );

        $mockquestions = [];
        foreach ($questions as $question) {
            // Create a mock object for questions and defining which methods should be mocked.
            $mock = $this->getMockBuilder(question::class)
                ->disableOriginalConstructor()
                ->onlyMethods(['prepare_for_template',
                    'get_id',
                    'get_title',
                    'get_description',
                    'get_timelimit',
                    'get_explanation'])
                ->getMock();
            $mockdata = new stdClass();
            $mockdata->questionid = $question["id"];
            $mockdata->questiontitle = $question["title"];
            $mockdata->questiondescription = $question["description"];
            $mockdata->questiontimelimit = $question["timelimit"];
            $mockdata->questionexplanation = $question["explanation"];

            // Define what the mock should return when the mocked methods are called.
            $mock->expects($this->any()) // Defines that the method can be called any number of times.
                ->method('prepare_for_template') // Defines which method we are defining the mock for.
                ->willReturn($mockdata); // Defines what should be returned when the mocked function is called.

            $mock->expects($this->any())
                ->method('get_id')
                ->willReturn($question["id"]);

            $mock->expects($this->any())
                ->method('get_title')
                ->willReturn($question["title"]);

            $mock->expects($this->any())
                ->method('get_description')
                ->willReturn($question["description"]);

            $mock->expects($this->any())
                ->method('get_timelimit')
                ->willReturn($question["timelimit"]);

            $mock->expects($this->any())
                ->method('get_explanation')
                ->willReturn($question["explanation"]);
            $mockquestions[] = $mock;
        }
        $livequiz->add_questions($mockquestions);

        $data = $livequiz->prepare_for_template();

        // Verify correct quizid.
        $this->assertIsInt($data->quizid);
        $this->assertEquals($livequiz->get_id(), $data->quizid);
        // Verify correct quiztitle.
        $this->assertIsString($data->quiztitle);
        $this->assertEquals($livequiz->get_name(), $data->quiztitle);

        // Verify correct numberofquestions.
        $this->assertIsInt($data->numberofquestions);
        $this->assertEquals(count($livequiz->get_questions()), $data->numberofquestions);

        // Verify correct questions.
        $counter = 0;
        foreach ($livequiz->get_questions() as $question) {
            $this->assertIsInt($data->questions[$counter]->questionid);
            $this->assertEquals($question->get_id(), $data->questions[$counter]->questionid);

            $this->assertIsString($data->questions[$counter]->questiontitle);
            $this->assertEquals($question->get_title(), $data->questions[$counter]->questiontitle);

            $this->assertIsString($data->questions[$counter]->questiondescription);
            $this->assertEquals($question->get_description(), $data->questions[$counter]->questiondescription);

            $this->assertIsInt($data->questions[$counter]->questiontimelimit);
            $this->assertEquals($question->get_timelimit(), $data->questions[$counter]->questiontimelimit);

            $this->assertIsString($data->questions[$counter]->questionexplanation);
            $this->assertEquals($question->get_explanation(), $data->questions[$counter]->questionexplanation);

            $counter++;
        }
    }

    /**
     * Tests the function prepare_question_for_template()
     *
     * @covers       \mod_livequiz\models\livequiz::prepare_question_for_template
     * @dataProvider dataprovider
     * prepare_question_for_template() should return a stdClass object, data, for use in mustache templates
     * data should have the fields: quizid, quiztitle, numberofquestions, questionid, questiontitle,
     * questiondescription, questiontimelimit, questionexplanation, answers
     * @throws ReflectionException
     */
    public function test_livequiz_prepare_question_for_template(
        int $quizid,
        string $quiztitle,
        int $courseid,
        string $intro,
        int $introformat,
        int $timecreated,
        int $timemodified,
        array $questions,
        int $questionindex
    ): void {
        $livequiz = test_utility::constructlivequiz(
            $quizid,
            $quiztitle,
            $courseid,
            $intro,
            $introformat,
            $timecreated,
            $timemodified
        );

        $mockquestions = [];
        foreach ($questions as $question) {
            // Create a mock object for questions and defining which methods should be mocked.
            $mock = $this->getMockBuilder(question::class)
                ->disableOriginalConstructor()
                ->onlyMethods(['prepare_for_template',
                    'get_id',
                    'get_title',
                    'get_description',
                    'get_timelimit',
                    'get_explanation',
                    'get_answers'])
                ->getMock();

            // Define what the mock should return when the mocked functions are called.
            $mock->expects($this->any())// Prepare_for_template can be called any number of times.
                ->method('prepare_for_template')
                ->willReturnCallback(function ($data) use ($question) {
                    // Append mockdata properties to the $data object.
                    $data->questionid = $question["id"];
                    $data->questiontitle = $question["title"];
                    $data->questiondescription = $question["description"];
                    $data->questiontimelimit = $question["timelimit"];
                    $data->questionexplanation = $question["explanation"];
                    $data->answers = [];
                    $data->answertype = 'checkbox';
                    return $data;
                });
            // Define what the mock should return when the mocked methods are called.
            $mock->expects($this->any()) // Defines that it can be called any number of times.
                ->method('get_id') // Defines which method we are defining the mock for.
                ->willReturn($question["id"]); // Defines what should be returned when the mocked function is called.

            $mock->expects($this->any())
                ->method('get_title')
                ->willReturn($question["title"]);

            $mock->expects($this->any())
                ->method('get_description')
                ->willReturn($question["description"]);

            $mock->expects($this->any())
                ->method('get_timelimit')
                ->willReturn($question["timelimit"]);

            $mock->expects($this->any())
                ->method('get_explanation')
                ->willReturn($question["explanation"]);

            $mock->expects($this->any())
                ->method('get_answers')
                ->willReturn([]);

            $mockquestions[] = $mock;
        }
        $livequiz->add_questions($mockquestions);

        $data = $livequiz->prepare_question_for_template($questionindex);

        // Verify correct quizid.
        $this->assertIsInt($data->quizid);
        $this->assertEquals($livequiz->get_id(), $data->quizid);


        // Verify correct quiztitle.
        $this->assertIsString($data->quiztitle);
        $this->assertEquals($livequiz->get_name(), $data->quiztitle);

        // Verify correct numberofquestions.
        $this->assertIsInt($data->numberofquestions);
        $this->assertEquals(count($livequiz->get_questions()), $data->numberofquestions);

        // Verify correct question.
        if (count($livequiz->get_questions()) > 0) {
            $question = $livequiz->get_question_by_index($questionindex);
            $this->assertIsInt($data->questionid);
            $this->assertEquals($question->get_id(), $data->questionid);

            $this->assertIsString($data->questiontitle);
            $this->assertEquals($question->get_title(), $data->questiontitle);

            $this->assertIsString($data->questiondescription);
            $this->assertEquals($question->get_description(), $data->questiondescription);

            $this->assertIsInt($data->questiontimelimit);
            $this->assertEquals($question->get_timelimit(), $data->questiontimelimit);

            $this->assertIsString($data->questionexplanation);
            $this->assertEquals($question->get_explanation(), $data->questionexplanation);

            $this->assertIsArray($data->answers);
        } else {
            $this->assertFalse(property_exists($data, 'question'), 'The $data object should not have a "question" field.');
        }
    }

    /**
     * Tests the function get_question_by_id()
     *
     * @covers       \mod_livequiz\models\livequiz::get_question_by_id
     * get_question_by_id() should return a question object matching the question from the database with the given id.
     * If there is no question in the database with the given id, an exception is thrown.
     * questiondescription, questiontimelimit, questionexplanation, answers
     * @throws ReflectionException
     */
    public function test_livequiz_get_question_by_id(): void {
        $livequiz = test_utility::constructlivequiz(
            1,
            "test title",
            1,
            "test intro",
            1,
            1,
            2
        );

        // Create mock questions. Only mock the get_id method.
        $mockquestion1 = $this->getMockBuilder(question::class)
            ->setConstructorArgs(['title1', 'description1', 10, 'explanation1'])
            ->onlyMethods(['get_id'])
            ->getMock();
        $mockquestion2 = $this->getMockBuilder(question::class)
            ->setConstructorArgs(['title2', 'description2', 10, 'explanation2'])
            ->onlyMethods(['get_id'])
            ->getMock();
        $mockquestion3 = $this->getMockBuilder(question::class)
            ->setConstructorArgs(['title3', 'description3', 10, 'explanation3'])
            ->onlyMethods(['get_id'])
            ->getMock();

        // Define mocked method get_id().
        $mockquestion1->method('get_id')
            ->willReturn(1);
        $mockquestion2->method('get_id')
            ->willReturn(2);
        $mockquestion3->method('get_id')
            ->willReturn(99);

        $livequiz->add_question($mockquestion1);
        $livequiz->add_question($mockquestion2);
        $livequiz->add_question($mockquestion3);

        $questionwithid1 = $livequiz->get_question_by_id(1);
        $questionwithid2 = $livequiz->get_question_by_id(2);
        $questionwithid3 = $livequiz->get_question_by_id(99);

        // Test that correct questions are returned by verifying correct titles.
        assertEquals($questionwithid1->get_title(), $mockquestion1->get_title());
        assertEquals($questionwithid2->get_title(), $mockquestion2->get_title());
        assertEquals($questionwithid3->get_title(), $mockquestion3->get_title());


        // Test invalid case: No question with the given ID.
        $this->expectException(InvalidArgumentException::class); // Expect an InvalidArgumentExceptionException to be thrown.
        $this->expectExceptionMessage("Could not find question with id 20");
        $livequiz->get_question_by_id(20); // This ID doesn't exist, should throw an exception.

        // Add question to livequiz with duplicate id.
        $mockquestion4 = $this->getMockBuilder(Question::class)
            ->setConstructorArgs(['title4', 'ddescription4', 10, 'explanation4n'])
            ->onlyMethods(['get_id'])
            ->getMock();
        $mockquestion4->method('get_id')->willReturn(1);
        $livequiz->add_question($mockquestion4);

        // Test invalid case: Multiple questions with the same ID.
        $this->expectException(RuntimeException::class); // Expect a RuntimeException to be thrown.
        $this->expectExceptionMessage("Something is wrong. Multiple questions found with id 1");
        $livequiz->get_question_by_id(1);
    }


    /**
     * Function that defines the data provider, such that a test can be run multiple times with different data
     * @return array
     */
    public static function dataprovider(): array {
        $question1 = test_utility::createquestionarray(
            1,
            'question1',
            'This is the description for question 1',
            5,
            'This is the explanation for question 1',
            0,
            []
        );
        $question2 = test_utility::createquestionarray(
            2,
            'question2',
            'This is the description for question 2',
            10,
            'This is the explanation for question 2',
            0,
            []
        );

        return [
            test_utility::createquizarray(
                1,
                "TestQuiz 1",
                2,
                "This is quiz intro",
                1,
                5000,
                6000,
                [],
                0
            ),
            test_utility::createquizarray(
                2,
                "TestQuiz 2",
                2,
                "This is quiz intro",
                2,
                0,
                0,
                [
                $question1,
                $question2,
                ],
                0
            ),
            test_utility::createquizarray(
                3,
                "TestQuiz 3",
                2,
                "æøå",
                1,
                5000,
                6000,
                [
                $question1,
                $question2,
                ],
                1
            ),
          test_utility::createquizarray(
              4,
              "TestQuiz 4",
              2,
              "",
              1,
              5000,
              6000,
              [
                $question1,
                $question2,
              ],
              0,
          ),
        ];
    }
}
