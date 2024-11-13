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
use dml_exception;
use mod_livequiz\external\submit_quiz;

/**
 * Unit tests for external class submit_quiz.
 */
final class submit_quiz_test extends advanced_testcase {
    /**
     * Custom assertion to check if a record exists in the database.
     *
     * @param string $table The name of the table.
     * @param array $data The data to check for.
     * @throws dml_exception
     */
    protected function assertdatabasehas(string $table, array $data): void {
        global $DB;

        $record = $DB->get_record($table, $data);
        $this->assertNotEmpty(
            $record,
            "Failed asserting that a row in the table [$table] matches the attributes " . json_encode($data)
        );
    }

    /**
     * Custom assertion to check if a record not exists in the database.
     *
     * @param string $table The name of the table.
     * @param array $data The data to check for.
     * @throws dml_exception
     */
    protected function assertdatabasenothas(string $table, array $data): void {
        global $DB;

        $record = $DB->get_record($table, $data);
        $this->assertEmpty(
            $record,
            "Failed asserting that all rows in the table [$table] matches the attributes " . json_encode($data)
        );
    }

    /**
     * Test insert participation.
     * @covers       \mod_livequiz\external\submit_quiz::insert_answers_from_session
     */
    public function test_insert_answers_from_session(): void {
        $this->resetAfterTest(true);

        // Mock quizid.
        $quizid = 101;

        // Mock session variables.
        $_SESSION['quiz_answers'][$quizid][1] = [
            'quizid' => $quizid,
            'questionid' => 1,
            'answers' => [9, 13, 16],
        ];
        $_SESSION['quiz_answers'][$quizid][3] = [
            'quizid' => $quizid,
            'questionid' => 3,
            'answers' => [31],
        ];
        $_SESSION['quiz_answers'][202][3] = [
            'quizid' => 202,
            'questionid' => 3,
            'answers' => [77, 88],
        ];

        // Mock studentid and participationid.
        $studentid = 1;
        $participationid = 2;

        // Call the function insert_answers_from_session().
        submit_quiz::insert_answers_from_session($quizid, $studentid, $participationid);

        $this->assertDatabaseHas('livequiz_students_answers', [
            'student_id' => $studentid,
            'answer_id' => 31,
            'participation_id' => $participationid,
        ]);
        $this->assertdatabasehas('livequiz_students_answers', [
            'student_id' => $studentid,
            'answer_id' => 9,
            'participation_id' => $participationid,
        ]);
        $this->assertdatabasehas('livequiz_students_answers', [
            'student_id' => $studentid,
            'answer_id' => 13,
            'participation_id' => $participationid,
        ]);
        $this->assertdatabasehas('livequiz_students_answers', [
            'student_id' => $studentid,
            'answer_id' => 16,
            'participation_id' => $participationid,
        ]);
        $this->assertdatabasenothas('livequiz_students_answers', [
            'student_id' => $studentid,
            'answer_id' => 77,
            'participation_id' => $participationid,
        ]);
        $this->assertdatabasenothas('livequiz_students_answers', [
            'student_id' => $studentid,
            'answer_id' => 88,
            'participation_id' => $participationid,
        ]);

        // Clear session variables after the test.
        unset($_SESSION['quiz_answers']);
    }
}
