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
            $mockdata->id = $question[0];
            $mockdata->title = $question[1];
            $mockdata->description = $question[2];
            $mockdata->timelimit = $question[3];
            $mockdata->explanation = $question[4];

            // Define what the mock should return when the mocked functions are called.
            $mock->expects($this->any())// Prepare_for_template can be called any number of times.
                ->method('prepare_for_template')
                ->willReturn($mockdata);

            $mock->expects($this->any())
                ->method('get_id')
                ->willReturn($mockdata->id);

            $mock->expects($this->any())
                ->method('get_title')
                ->willReturn($mockdata->title);

            $mock->expects($this->any())
                ->method('get_description')
                ->willReturn($mockdata->description);

            $mock->expects($this->any())
                ->method('get_timelimit')
                ->willReturn($mockdata->timelimit);
            $mock->expects($this->any())
                ->method('get_explanation')
                ->willReturn($mockdata->explanation);
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
            $this->assertIsInt($data->questions[$counter]->id);
            $this->assertEquals($question->get_id(), $data->questions[$counter]->id);

            $this->assertIsString($data->questions[$counter]->title);
            $this->assertEquals($question->get_title(), $data->questions[$counter]->title);

            $this->assertIsString($data->questions[$counter]->description);
            $this->assertEquals($question->get_description(), $data->questions[$counter]->description);

            $this->assertIsInt($data->questions[$counter]->timelimit);
            $this->assertEquals($question->get_timelimit(), $data->questions[$counter]->timelimit);

            $this->assertIsString($data->questions[$counter]->explanation);
            $this->assertEquals($question->get_explanation(), $data->questions[$counter]->explanation);

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
            $mockdata = new stdClass();
            $mockdata->id = $question[0];
            $mockdata->title = $question[1];
            $mockdata->description = $question[2];
            $mockdata->timelimit = $question[3];
            $mockdata->explanation = $question[4];
            $mockdata->answers = [];

            // Define what the mock should return when the mocked functions are called.
            $mock->expects($this->any())// Prepare_for_template can be called any number of times.
                ->method('prepare_for_template')
                ->willReturn($mockdata);

            $mock->expects($this->any())
                ->method('get_id')
                ->willReturn($mockdata->id);

            $mock->expects($this->any())
                ->method('get_title')
                ->willReturn($mockdata->title);

            $mock->expects($this->any())
                ->method('get_description')
                ->willReturn($mockdata->description);

            $mock->expects($this->any())
                ->method('get_timelimit')
                ->willReturn($mockdata->timelimit);
            $mock->expects($this->any())
                ->method('get_explanation')
                ->willReturn($mockdata->explanation);
            $mock->expects($this->any())
                ->method('get_answers')
                ->willReturn($mockdata->answers);
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
        if ( count($livequiz->get_questions()) > 0 ) {
            $question = $livequiz->get_question_by_index($questionindex);
            $this->assertIsInt($data->question->id);
            $this->assertEquals($question->get_id(), $data->question->id);

            $this->assertIsString($data->question->title);
            $this->assertEquals($question->get_title(), $data->question->title);

            $this->assertIsString($data->question->description);
            $this->assertEquals($question->get_description(), $data->question->description);

            $this->assertIsInt($data->question->timelimit);
            $this->assertEquals($question->get_timelimit(), $data->question->timelimit);

            $this->assertIsString($data->question->explanation);
            $this->assertEquals($question->get_explanation(), $data->question->explanation);

            $this->assertIsArray($data->question->answers);
            $this->assertEquals($question->get_explanation(), $data->question->explanation);
        } else{
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
    private function constructlivequiz(
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
        $question1 = [1, 'question1', 'This is the description for question 1', 5, 'This is the explanation for question 1'];
        $question2 = [2, 'question2', 'This is the description for question 2', 10, 'This is the explanation for question 2'];

        return [
                [1, "TestQuiz 1", 2, "This is quiz intro", 1, 5000, 6000, [], 0],
                [2, "TestQuiz 2", 2, "This is quiz intro", 2, 0, 0, [
                    $question1,
                    $question2, ],
                    1,
                ],
                [3, "TestQuiz 3", 2, "æøå", 1, 5000, 6000, [
                    $question1,
                    $question2, ],
                    2,
                ],
                [4, "TestQuiz 4", 2, "", 1, 5000, 6000, [
                    $question1,
                    $question2, ],
                    0,
                ],
            ];
    }
}
