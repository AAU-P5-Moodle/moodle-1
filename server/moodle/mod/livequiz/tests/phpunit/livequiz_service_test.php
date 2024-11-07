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

use dml_exception;
use mod_livequiz\models\livequiz;
use mod_livequiz\services\livequiz_services;
use mod_livequiz\models\question;
use mod_livequiz\models\answer;
use mod_livequiz\models\participation;
use mod_livequiz\models\student_quiz_relation;

/**
 * Testing examples for LiveQuiz service.
 */
final class livequiz_service_test extends \advanced_testcase {
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
     * Setup before each test.
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test of new_participation
     * @covers \mod_livequiz\services\livequiz_services::new_participation
     */
    public function test_new_participation(): void {
        $participationdata = $this->create_participation_data_for_test();
        $service = livequiz_services::get_singleton_service_instance();

        $actualstudentid = $participationdata['studentid'];
        $acutalquizid = $participationdata['quizid'];

        $participation = $service->new_participation($actualstudentid, $acutalquizid);
        $this->assertInstanceOf(participation::class, $participation);
        $this->assertEquals($participation->get_studentid(), $actualstudentid);
        $this->assertEquals($participation->get_livequizid(), $acutalquizid);
    }
}
