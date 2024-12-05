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
use mod_livequiz\models\student_quiz_relation;

/**
 * student_quiz_relation_test
 */
final class student_quiz_relation_test extends advanced_testcase {
    /**
     * Create participation test data. Used in every test.
     * @return array
     * @throws dml_exception
     */
    protected function create_test_data(): array {
        // We need a quiz to append the participation to.
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
        $livequizid = $DB->insert_record('livequiz', $livequizdata, true);
        return  $participationdata = [
            'studentid' => 2,
            'quizid' => $livequizid,
        ];
    }

    /**
     * Setup before each test.
     * @return void
     * @throws dml_transaction_exception
     * @throws dml_exception
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
        $data = $this->create_test_data();
        $actual = student_quiz_relation::insert_student_quiz_relation($data['quizid'], $data['studentid']);
    }

    /**
     * Test of test_append_student_to_quiz.
     * It is impossible to assert the actual table id, since it changes every time.
     * @covers \mod_livequiz\models\student_quiz_relation::append_student_to_quiz
     * @return void
     * @throws dml_exception
     * @throws dml_transaction_exception
     */
    public function test_append_student_to_quiz(): void {
        $data = $this->create_test_data();
        $actual = student_quiz_relation::insert_student_quiz_relation($data['quizid'], $data['studentid']);

        $this->assertIsNumeric($actual);
        $this->assertGreaterThan(0, $actual);
    }

    /**
     * Test of get_all_student_participation_for_quiz
     * @covers \mod_livequiz\models\student_quiz_relation::get_all_student_participation_for_quiz
     * @return void
     * @throws dml_exception
     * @throws dml_transaction_exception
     */
    public function test_get_all_student_participation_for_quiz(): void {
        $data = $this->create_test_data();
        $participation1 = student_quiz_relation::insert_student_quiz_relation($data['quizid'], $data['studentid']);
        $participation2 = student_quiz_relation::insert_student_quiz_relation($data['quizid'], $data['studentid']);

        $participation = student_quiz_relation::get_all_student_participation_for_quiz($data['quizid'], $data['studentid']);
        $this->assertNotNull($participation[0]);
        $this->assertEquals($participation[0]->get_studentid(), $data['studentid']);
        $this->assertEquals($participation[0]->get_livequizid(), $data['quizid']);
        $this->assertNotNull($participation[1]);
        $this->assertEquals($participation[1]->get_studentid(), $data['studentid']);
        $this->assertEquals($participation[1]->get_livequizid(), $data['quizid']);
        $this->assertEquals($participation1 + 1, $participation2);
    }
}
