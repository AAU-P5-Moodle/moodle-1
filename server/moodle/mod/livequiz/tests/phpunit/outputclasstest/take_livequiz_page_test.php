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

namespace mod_livequiz;

use advanced_testcase;
use mod_livequiz\models\livequiz;
use mod_livequiz\models\question;
use ReflectionClass;
use ReflectionException;
use mod_livequiz\output\take_livequiz_page;

defined('MOODLE_INTERNAL') || die();
require_once(__DIR__ . '/../test_utility.php');

/**
 * Unit tests for class take_livequiz_page.
 *
 * @package    mod_livequiz
 * @category   test
 * @copyright  2024 Software AAU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class take_livequiz_page_test extends advanced_testcase {
    /**
     * Setup that runs before each test in the file
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
    }

    /**
     * Test of get_next_question_index returns the correct index.
     * @param int $quizid The id of the quiz.
     * @param string $quiztitle The title of the quiz.
     * @param int $courseid The id of the course.
     * @param string $intro The intro of the quiz.
     * @param int $introformat The format of the intro.
     * @param int $timecreated The time the quiz was created.
     * @param int $timemodified The time the quiz was modified.
     * @param array $questions An array of questions.
     * @covers       \mod_livequiz\output\take_livequiz_page::get_next_question_index
     * @dataProvider dataprovider
     * @throws ReflectionException
     */
    public function test_get_next_question_index(
        int $quizid,
        string $quiztitle,
        int $courseid,
        string $intro,
        int $introformat,
        int $timecreated,
        int $timemodified,
        array $questions,
    ): void {
        $livequiz = $this->createtestsetup(
            $quizid,
            $quiztitle,
            $courseid,
            $intro,
            $introformat,
            $timecreated,
            $timemodified,
            $questions,
        );
        $numberofquestions = count($livequiz->get_questions());
        $questionindex = 0;
        $studentid = 2;

        if ($numberofquestions >= 1) { // When we have at least 1 question.
            $takelivequizpage = new take_livequiz_page($courseid, $livequiz, $questionindex, $studentid);
            while ($takelivequizpage->get_question_index() < $numberofquestions - 1) {
                // We test that while the question is not the last in the array that
                // get_next_question_index will return the next index.
                $this->assertEquals($takelivequizpage->get_question_index() + 1, $takelivequizpage->get_next_question_index());
                $takelivequizpage->set_question_index($takelivequizpage->get_question_index() + 1);
            }
            $this->assertEquals($takelivequizpage->get_question_index(), $takelivequizpage->get_next_question_index());
        } else {
            // If there is no questions we cannot make a take_livequiz_page object.
            $emptyquestions = $livequiz->get_questions();
            $this->assertEmpty($emptyquestions, "The questions array is empty");
        }
    }

    /**
     * Test of get_previous_question_index returns the correct index.
     * @param int $quizid The id of the quiz.
     * @param string $quiztitle The title of the quiz.
     * @param int $courseid The id of the course.
     * @param string $intro The intro of the quiz.
     * @param int $introformat The format of the intro.
     * @param int $timecreated The time the quiz was created.
     * @param int $timemodified The time the quiz was modified.
     * @param array $questions An array of questions.
     * @covers       \mod_livequiz\output\take_livequiz_page::get_previous_question_index
     * @dataProvider dataprovider
     * @throws ReflectionException
     */
    public function test_get_previous_question_index(
        int $quizid,
        string $quiztitle,
        int $courseid,
        string $intro,
        int $introformat,
        int $timecreated,
        int $timemodified,
        array $questions,
    ): void {
        $livequiz = $this->createtestsetup(
            $quizid,
            $quiztitle,
            $courseid,
            $intro,
            $introformat,
            $timecreated,
            $timemodified,
            $questions,
        );
        $numberofquestions = count($livequiz->get_questions());
        $studentid = 2;

        if ($numberofquestions >= 1) { // When we have at lest 1 question.
            $takelivequizpage = new take_livequiz_page($courseid, $livequiz, $numberofquestions - 1, $studentid);
            while ($takelivequizpage->get_question_index() > 0) {
                // We test that while the question is not the first in the array that
                // get_previous_question_index will return the previous index.
                $this->assertEquals($takelivequizpage->get_question_index() - 1, $takelivequizpage->get_previous_question_index());
                $takelivequizpage->set_question_index($takelivequizpage->get_question_index() - 1);
            }
            $this->assertEquals($takelivequizpage->get_question_index(), $takelivequizpage->get_previous_question_index());
        } else {
            $emptyquestions = $livequiz->get_questions();
            $this->assertEmpty($emptyquestions, "The questions array is empty");
        }
    }

    /**
     * Function that creates a reflection of a livequiz object with questions
     * It's a reflection because the livequiz constructor is not public.
     * @param int $quizid
     * @param string $quiztitle
     * @param int $courseid
     * @param string $intro
     * @param int $introformat
     * @param int $timecreated
     * @param int $timemodified
     * @param array $questions
     * @return livequiz
     * @throws ReflectionException
     */
    private function createtestsetup(
        int $quizid,
        string $quiztitle,
        int $courseid,
        string $intro,
        int $introformat,
        int $timecreated,
        int $timemodified,
        array $questions,
    ): livequiz {
        $livequiz = test_utility::constructlivequiz(
            $quizid,
            $quiztitle,
            $courseid,
            $intro,
            $introformat,
            $timecreated,
            $timemodified,
        );

        $questionarray = [];
        foreach ($questions as $question) {
            $questionobject = new question(
                $question['title'],
                $question['description'],
                $question['timelimit'],
                $question['explanation'],
            );
            $class = new ReflectionClass(question::class);
            $method = $class->getMethod('set_id');
            $method->invokeArgs($questionobject, (array)$question['id']);
            $questionarray[] = $questionobject;
        }
        $livequiz->add_questions($questionarray);

        return $livequiz;
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
            []
        );
        $question2 = test_utility::createquestionarray(
            2,
            'question2',
            'This is the description for question 2',
            10,
            'This is the explanation for question 2',
            []
        );
        $question3 = test_utility::createquestionarray(
            3,
            'question3',
            'This is the description for question 3',
            12,
            'This is the explanation for question 3',
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
                0
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
                    $question3,
                ],
                0,
            ),
        ];
    }
}
