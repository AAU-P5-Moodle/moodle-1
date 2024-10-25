<?php
// This file is part of Moodle - http://moodle.org/.
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
 * Unit tests for the livequiz module.
 *
 * @package    mod_livequiz
 * @category   test
 * @copyright  2023 Software AAU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_livequiz;

use advanced_testcase;

/**
 * Unit tests for the livequiz module functions.
 *
 * @package    mod_livequiz
 * @category   test
 */
final class lib_test extends advanced_testcase {
    /**
     * Setup before each test.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Tests the addition of a new livequiz instance.
     *
     * @covers \mod_livequiz\lib::livequiz_add_instance
     * @return void
     * @throws \dml_exception When a database error occurs.
     */
    public function test_livequiz_add_instance(): void {
        global $DB;

        $quizdata = new \stdClass();
        $quizdata->name = 'Test Quiz';
        $quizdata->intro = 'This is a test quiz.';

        $id = livequiz_add_instance($quizdata);
        $this->assertIsInt($id);
        $this->assertEquals('Test Quiz', $DB->get_field('livequiz', 'name', ['id' => $id]));
        $this->assertEquals('This is a test quiz.', $DB->get_field('livequiz', 'intro', ['id' => $id]));
        $this->assertTrue($DB->record_exists('livequiz', ['id' => $id]));
    }

    /**
     * Tests the updating of a livequiz instance.
     *
     * @covers \mod_livequiz\lib::livequiz_update_instance
     * @return void
     * @throws \dml_exception When a database error occurs.
     */
    public function test_livequiz_update_instance(): void {
        global $DB;

        $quizdata = new \stdClass();
        $quizdata->name = 'Test Quiz';
        $quizdata->intro = 'This is a test quiz.';

        $id = livequiz_add_instance($quizdata);
        $quizdata->id = $id;
        $quizdata->name = 'Updated Test Quiz';

        $result = livequiz_update_instance($quizdata);
        $this->assertTrue($result);
        $record = $DB->get_record('livequiz', ['id' => $id]);
        $this->assertEquals('Updated Test Quiz', $record->name);
    }

    /**
     * Tests the deletion of a livequiz instance.
     *
     * @covers \mod_livequiz\lib::livequiz_delete_instance
     * @return void
     * @throws \dml_exception When a database error occurs.
     */
    public function test_livequiz_delete_instance(): void {
        global $DB;

        $quizdata = new \stdClass();
        $quizdata->name = 'Test Quiz';
        $quizdata->intro = 'This is a test quiz.';

        $id = livequiz_add_instance($quizdata);
        $result = livequiz_delete_instance($id);
        $this->assertTrue($result);
        $this->assertFalse($DB->record_exists('livequiz', ['id' => $id]));
    }
}
