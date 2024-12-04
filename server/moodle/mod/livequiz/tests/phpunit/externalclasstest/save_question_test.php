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
 * Unit tests for external class submit_quiz.
 *
 * @package    mod_livequiz
 * @category   test
 * @copyright  2023
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_livequiz;

use advanced_testcase;
use mod_livequiz\external\save_question;
use mod_livequiz\models\question;
use ReflectionClass;
use ReflectionException;
use function PHPUnit\Framework\assertEquals;

/**
 * Unit tests for external class save_question.
 */
final class save_question_test extends advanced_testcase {
    /**
     * Test the save_question external function.
     * This function tests if a question can be saved to the database.
     * @covers      \mod_livequiz\external\save_question::new_question
     * @throws ReflectionException
     */
    public function test_new_question(): void {
        $this->resetAfterTest();
        $questiondata = [
            'title' => 'Question Title 1',
            'description' => 'Question Description 1',
            'explanation' => 'Question Explanation 1',
            'type' => '1',
            'answers' => [
                [
                    'description' => 'Answer 1',
                    'correct' => 1,
                    'explanation' => 'Answer 1 Explanation',
                ],
                [
                    'description' => 'Answer 2',
                    'correct' => 0,
                    'explanation' => 'Answer 2 Explanation',
                ],
            ],
        ];

        $question = self::call_new_question([$questiondata]);
        $answers = $question->get_answers();

        $this->assertInstanceOf(question::class, $question);
        assertEquals(0, $question->get_id());
        assertEquals($questiondata['title'], $question->get_title());
        assertEquals($questiondata['description'], $question->get_description());
        assertEquals($questiondata['explanation'], $question->get_explanation());
        assertEquals(2, count($answers));
        assertEquals($questiondata['answers'][0]['description'], $answers[0]->get_description());
        assertEquals($questiondata['answers'][0]['correct'], $answers[0]->get_correct());
        assertEquals($questiondata['answers'][0]['explanation'], $answers[0]->get_explanation());
        assertEquals($questiondata['answers'][1]['description'], $answers[1]->get_description());
        assertEquals($questiondata['answers'][1]['correct'], $answers[1]->get_correct());
        assertEquals($questiondata['answers'][1]['explanation'], $answers[1]->get_explanation());
    }

    /**
     * Allows calling of private function new_question
     * @covers      \mod_livequiz\external\save_question::new_question
     * @throws ReflectionException
     */
    private static function call_new_question(array $questiondata): question {
        $class = new ReflectionClass(save_question::class);
        $method = $class->getMethod('new_question');
        return $method->invokeArgs(null, $questiondata);
    }
}
