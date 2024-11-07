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
use mod_livequiz\models\livequiz;
use mod_livequiz\models\question;
use stdClass;
use ReflectionClass;
use ReflectionException;

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
        $livequiz = $this->constructlivequiz(
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
            // Create a mock object for questions.
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

            // Define what the mock should return when the mocked functions are called.
            $mock->expects($this->any())// Prepare_for_template can be called any number of times.
                ->method('prepare_for_template')
                ->willReturn($mockdata);

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
        $livequiz = $this->constructlivequiz(
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
            // Create a mock object for questions.
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
     * Function to construct a livequiz using reflection to access the private constructor
     * @param int $testid
     * @param string $quiztitle
     * @param int $courseid
     * @param string $intro
     * @param int $introformat
     * @param int $timecreated
     * @param int $timemodified
     * @return livequiz
     * @throws ReflectionException
     */
    public static function constructlivequiz(
        int $testid,
        string $quiztitle,
        int $courseid,
        string $intro,
        int $introformat,
        int $timecreated,
        int $timemodified
    ): livequiz {

        $class = new ReflectionClass(livequiz::class);
        $constructor = $class->getConstructor();
        $constructor->setAccessible(true);
        $object = $class->newInstanceWithoutConstructor();
        return $constructor->invoke($object, $testid, $quiztitle, $courseid, $intro, $introformat, $timecreated, $timemodified);
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
            'This is the explanation for question 1'
        );
        $question2 = test_utility::createquestionarray(
            2,
            'question2',
            'This is the description for question 2',
            10,
            'This is the explanation for question 2'
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
