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
 * Unit tests for class question.
 *
 * @package    mod_livequiz
 * @category   test
 * @copyright  2023
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_livequiz;

use advanced_testcase;
use mod_livequiz\models\answer;
use mod_livequiz\models\question;
use stdClass;

/**
 * Test class for livequiz class
 */
final class question_test extends advanced_testcase {
    private question $question;
    /**
     * Setup that runs before each test in the file
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();

        $this->question = new question(
            "Question 1",
            "This is the description for the question",
            55,
            "This is the explanation for the question"
        );
    }

    /**
     * Test of get_hasmultipleanswers returns true, when there are more than 1 correct answer.
     */
    public function test_question_get_hasmultipleanswers_true(): void {
        $mockanswers = [];
        for ($x = 0; $x <= 3; $x++) {
            $mock = $this->getMockBuilder(answer::class)
                ->disableOriginalConstructor()
                ->onlyMethods(['get_correct'])
                ->getMock();
            if ($x < 2) {
                $mock->expects($this->any())
                    ->method('get_correct')
                    ->willReturn(0);
            } else {
                $mock->expects($this->any())
                    ->method('get_correct')
                    ->willReturn(1);
            }
            $mockanswers[] = $mock;
        }
        $this->question->add_answers($mockanswers);
        $this->assertTrue($this->question->get_hasmultiplecorrectanswers());
    }

    /**
     * Test of get_hasmultipleanswers returns false, when there is only 1 correct answer.
     */
    public function test_question_get_hasmultipleanswers_false(): void {
        $mockanswers = [];
        for ($x = 0; $x <= 3; $x++) {
            $mock = $this->getMockBuilder(answer::class)
                ->disableOriginalConstructor()
                ->onlyMethods(['get_correct'])
                ->getMock();
            if ($x < 3) {
                $mock->expects($this->any())
                    ->method('get_correct')
                    ->willReturn(0);
            } else {
                $mock->expects($this->any())
                    ->method('get_correct')
                    ->willReturn(1);
            }
            $mockanswers[] = $mock;
        }
        $this->question->add_answers($mockanswers);
        $this->assertnotTrue($this->question->get_hasmultiplecorrectanswers());
    }

    public function test_question_prepare_for_template(){

        $data = new stdClass();
        $data = $this->question->prepare_for_template($data);

        // Verify correct question title.
        $this->assertIsString($data->questiontitle);
        $this->assertEquals($this->question->get_title(), $data->questiontitle);

        // Verify correct answers.
        $counter = 0;
    }

}
