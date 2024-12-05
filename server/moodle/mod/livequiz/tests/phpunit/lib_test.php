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
 * Test of lib.php.
 * @package mod_livequiz
 * @copyright 2023
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_livequiz;
use advanced_testcase;
use dml_exception;
use stdClass;

/**
 * Testing examples!
 */
final class lib_test extends advanced_testcase {
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Tests the addition of a new live quiz instance.
     *
     * @covers \mod_livequiz\lib::livequiz_add_instance
     * Test the livequiz_add_instance function.
     * This function should add a new livequiz instance to the database.
     * It should return the ID of the new instance.
     * It should set the name and intro fields of the new instance.
     * It should return false if the instance cannot be added.
     * @throws dml_exception
     */
    public function test_livequiz_add_instance(): void {
        global $DB;

        $quizdata = new stdClass(); // Create a new stdClass object (empty object).
        $quizdata->name = 'Test Quiz';
        $quizdata->intro = 'This is a test quiz.';
        $quizdata->course = 1;
        $quizdata->module = 1;
        $quizdata->section = 1;

        $id = livequiz_add_instance($quizdata);
        $this->assertIsInt($id);
        $this->assertEquals('Test Quiz', $DB->get_field('livequiz', 'name', ['id' => $id]));
        $this->assertEquals('This is a test quiz.', $DB->get_field('livequiz', 'intro', ['id' => $id]));
        $this->assertTrue($DB->record_exists('livequiz', ['id' => $id]));
    }

    /**
     * This test updates instance.
     *
     * @covers \mod_livequiz\lib::livequiz_update_instance
     * Test the livequiz_update_instance function.
     * This function should update an existing livequiz instance in the database.
     * It should return true if the instance is updated successfully.
     * It should return false if the instance cannot be updated.
     * @throws dml_exception
     */
    public function test_livequiz_update_instance(): void {
        global $DB;

        // Prepare the data.
        $quizdata = new stdClass();
        $quizdata->name = 'Test Quiz';
        $quizdata->intro = 'This is a test quiz.';
        $quizdata->course = 1;
        $quizdata->module = 1;
        $quizdata->section = 1;
        $id = livequiz_add_instance($quizdata);
        $quizdata->instance = $id;
        $quizdata->name = 'Updated Test Quiz';
        // Execute.
        $result = livequiz_update_instance($quizdata);
        $record = $DB->get_record('livequiz', ['id' => $id]);
        // Assert.
        $this->assertTrue($result);
        $this->assertEquals('Updated Test Quiz', $record->name);
    }

    /**
     * This test the delete instance.
     *
     * @covers \mod_livequiz\lib::livequiz_delete_instance
     * Test the livequiz_delete_instance function.
     * This function should delete an existing livequiz instance from the database.
     * It should return true if the instance is deleted successfully.
     * It should return false if the instance cannot be deleted.
     * @throws dml_exception
     */
    public function test_livequiz_delete_instance(): void {
        global $DB;

        $quizdata = new stdClass();
        $quizdata->name = 'Test Quiz';
        $quizdata->intro = 'This is a test quiz.';
        $quizdata->course = 1;
        $quizdata->module = 1;
        $quizdata->section = 1;

        $id = livequiz_add_instance($quizdata);
        $result = livequiz_delete_instance($id);
        $this->assertTrue($result);
        $this->assertFalse($DB->record_exists('livequiz', ['id' => $id]));
    }
}
