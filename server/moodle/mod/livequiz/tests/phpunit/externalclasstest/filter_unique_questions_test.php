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
 * Unit tests for external class get_lecturer_questions.
 *
 * @package    mod_livequiz
 * @category   test
 * @copyright  2023
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_livequiz;

use advanced_testcase;
use dml_exception;
use mod_livequiz\external\reuse_question;
use mod_livequiz\models\answer;
use mod_livequiz\models\question;
use mod_livequiz\services\livequiz_services;
use ReflectionClass;
use ReflectionException;
use function PHPUnit\Framework\assertEquals;

defined('MOODLE_INTERNAL') || die();
require_once(__DIR__ . '/../test_utility.php');

/**
 * Unit tests for external class filter_unique_questions.
 */
final class filter_unique_questions_test extends advanced_testcase {
    /**
     * @var question $question1
     */
    private question $question1;
    /**
     * @var question $question2
     */
    private question $question2;
    /**
     * @var question $question3
     */
    private question $question3;
    /**
     * @var question $question4
     */
    private question $question4;
    /**
     * @var question $question5
     */
    private question $question5;
    /**
     * @var question $question6
     */
    private question $question6;
    /**
     * @var question $question7
     */
    private question $question7;
    /**
     * @var question $question8
     */
    private question $question8;
    /**
     * @var question $question9
     */
    private question $question9;
    /**
     * Setup that runs before each test in the file
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
    }

    /**
     * Test the filter_unique_questions external function.
     * This function tests if the filter_unique_questions function filters out duplicate questions.
     * @covers      \mod_livequiz\external\reuse_question::filter_unique_questions
     * @throws ReflectionException|dml_exception
     */
    public function test_filter_unique_questions(): void {
        $this->createtestdata();
        $questions = [
            $this->question1->get_id(),
            $this->question2->get_id(),
            $this->question3->get_id(),
        ];
        // Use reflection to access the private static method.
        $object = new reuse_question(); // Create an object of the class to test.
        $reflectionclass = new ReflectionClass($object);
        $method = $reflectionclass->getMethod('filter_unique_questions');
        // Invoke the method with the questions as argument.
        $filteredquestions = $method->invokeArgs($object, [$questions]);
        assertEquals(1, count($filteredquestions));
        assertEquals($this->question1->get_id(), $filteredquestions[0]);
    }

    /**
     * Test the filter_unique_questions external function.
     * This function tests if the filter_unique_questions function filters out duplicate questions.
     * Function filter_unique_questions should return questions that have even very small differences.
     * @covers      \mod_livequiz\external\filter_unique_questions::filter_unique_questions
     * @throws ReflectionException|dml_exception
     */
    public function test_filter_unique_questions_2(): void {
        $this->createtestdata();
        $questions = [
            $this->question4->get_id(),
            $this->question5->get_id(),
            $this->question6->get_id(),
            $this->question7->get_id(),
            $this->question8->get_id(),
            $this->question9->get_id(),
        ];
        // Use reflection to access the private static method.
        $object = new reuse_question(); // Create an object of the class to test.
        $reflectionclass = new ReflectionClass($object);
        $method = $reflectionclass->getMethod('filter_unique_questions');
        // Invoke the method with the questions as argument.
        $filteredquestions = $method->invokeArgs($object, [$questions]);
        assertEquals(5, count($filteredquestions));
        assertEquals($this->question4->get_id(), $filteredquestions[0]);
        assertEquals($this->question6->get_id(), $filteredquestions[1]);
        assertEquals($this->question7->get_id(), $filteredquestions[2]);
        assertEquals($this->question8->get_id(), $filteredquestions[3]);
        assertEquals($this->question9->get_id(), $filteredquestions[4]);
    }

    /**
     * Test the filter_unique_questions external function.
     * This function tests if the filter_unique_questions returns empty array when given empty array.
     * @covers      \mod_livequiz\external\reuse_question::filter_unique_questions
     * @throws ReflectionException|dml_exception
     */
    public function test_filter_unique_questions_0(): void {
        $this->createtestdata();
        $questions = [
        ];
        // Use reflection to access the private static method.
        $object = new reuse_question(); // Create an object of the class to test.
        $reflectionclass = new ReflectionClass($object);
        $method = $reflectionclass->getMethod('filter_unique_questions');
        // Invoke the method with the questions as argument.
        $filteredquestions = $method->invokeArgs($object, [$questions]);
        assertEquals(0, count($filteredquestions));
    }

    /**
     * Creates test data to be used in the tests.
     * Question 1, 2, 3 are duplicates.
     * Question 4, 5 are duplicates.
     * Question 6-9 is not a duplicate of 4.
     * @return void
     * @throws dml_exception
     */
    private function createtestdata(): void {
        $answer1 = new answer(1, 'This is answer 1', 'This is explanation 1');
        $answer2 = new answer(0, 'This is answer 2', 'This is explanation 2');
        $answer3 = new answer(0, 'This is answer 3', 'This is explanation 3');
        $answer4 = new answer(1, 'This is answer 4', 'This is explanation 4');
        $answer5 = new answer(1, 'This is answer 1', 'This is explanation 1');

        $this->question1 = new question(
            'question1',
            'This is the description for question 1',
            5,
            'This is the explanation for question 1'
        );
        $this->question2 = new question( // Duplicate question of id 1.
            'question1',
            'This is the description for question 1',
            5,
            'This is the explanation for question 1'
        );
        $this->question3 = new question( // Duplicate question of id 1 as answer5 is the same as answer1.
            'question1',
            'This is the description for question 1',
            5,
            'This is the explanation for question 1'
        );
        $this->question4 = new question(
            'question2',
            'This is the description for question 2',
            10,
            'This is the explanation for question 2'
        );
        $this->question5 = new question( // Duplicate question of id 4.
            'question2',
            'This is the description for question 2',
            10,
            'This is the explanation for question 2'
        );
        $this->question6 = new question( // Not a duplicate question of id 4.
            'question2',
            'This is the description that is a little different for question 2',
            10,
            'This is the explanation for question 2'
        );
        $this->question7 = new question( // Not a duplicate question of id 4.
            'questions2',
            'This is the description for question 2',
            10,
            'This is the explanation for question 2'
        );
        $this->question8 = new question( // Not a duplicate question of id 4.
            'question2',
            'This is the description for question 2',
            10,
            'This is the explanation that is a little different for question 2'
        );
        $this->question9 = new question(// Not a duplicate question of id 4.
            'question2',
            'This is the description for question 2',
            10,
            'This is the explanation for question 2'
        );

        $service = livequiz_services::get_singleton_service_instance();

        $this->question1->set_id($service->insert_question($this->question1));
        $this->question2->set_id($service->insert_question($this->question2));
        $this->question3->set_id($service->insert_question($this->question3));
        $this->question4->set_id($service->insert_question($this->question4));
        $this->question5->set_id($service->insert_question($this->question5));
        $this->question6->set_id($service->insert_question($this->question6));
        $this->question7->set_id($service->insert_question($this->question7));
        $this->question8->set_id($service->insert_question($this->question8));
        $this->question9->set_id($service->insert_question($this->question9));
        $answer1->set_id($service->insert_answer($answer1));
        $answer2->set_id($service->insert_answer($answer2));
        $answer3->set_id($service->insert_answer($answer3));
        $answer4->set_id($service->insert_answer($answer4));
        $answer5->set_id($service->insert_answer($answer5));

        // Question 1.
        $id = $this->question1->get_id();
        $service->insert_question_answer_relation($id, $answer1->get_id());
        $service->insert_question_answer_relation($id, $answer2->get_id());
        $service->insert_question_answer_relation($id, $answer3->get_id());
        // Question 2.
        $id = $this->question2->get_id();
        $service->insert_question_answer_relation($id, $answer1->get_id());
        $service->insert_question_answer_relation($id, $answer2->get_id());
        $service->insert_question_answer_relation($id, $answer3->get_id());
        // Question 3.
        $id = $this->question3->get_id();
        $service->insert_question_answer_relation($id, $answer5->get_id());
        $service->insert_question_answer_relation($id, $answer2->get_id());
        $service->insert_question_answer_relation($id, $answer3->get_id());
        // Question 4.
        $id = $this->question4->get_id();
        $service->insert_question_answer_relation($id, $answer1->get_id());
        $service->insert_question_answer_relation($id, $answer2->get_id());
        $service->insert_question_answer_relation($id, $answer3->get_id());
        $service->insert_question_answer_relation($id, $answer4->get_id());
        // Question 5.
        $id = $this->question5->get_id();
        $service->insert_question_answer_relation($id, $answer1->get_id());
        $service->insert_question_answer_relation($id, $answer2->get_id());
        $service->insert_question_answer_relation($id, $answer3->get_id());
        $service->insert_question_answer_relation($id, $answer4->get_id());
        // Question 6.
        $id = $this->question6->get_id();
        $service->insert_question_answer_relation($id, $answer1->get_id());
        $service->insert_question_answer_relation($id, $answer2->get_id());
        $service->insert_question_answer_relation($id, $answer3->get_id());
        $service->insert_question_answer_relation($id, $answer4->get_id());
        // Question 7.
        $id = $this->question7->get_id();
        $service->insert_question_answer_relation($id, $answer1->get_id());
        $service->insert_question_answer_relation($id, $answer2->get_id());
        $service->insert_question_answer_relation($id, $answer3->get_id());
        $service->insert_question_answer_relation($id, $answer4->get_id());
        // Question 8.
        $id = $this->question8->get_id();
        $service->insert_question_answer_relation($id, $answer1->get_id());
        $service->insert_question_answer_relation($id, $answer2->get_id());
        $service->insert_question_answer_relation($id, $answer3->get_id());
        $service->insert_question_answer_relation($id, $answer4->get_id());
        // Question 9.
        $id = $this->question9->get_id();
        $service->insert_question_answer_relation($id, $answer1->get_id());
        $service->insert_question_answer_relation($id, $answer2->get_id());
        $service->insert_question_answer_relation($id, $answer3->get_id());
    }
}
