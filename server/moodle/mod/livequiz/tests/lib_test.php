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

defined('MOODLE_INTERNAL') || die();

use \mod_livequiz\lib;

class mod_livequiz_lib_test extends advanced_testcase {

    protected function setUp(): void {
        $this->resetAfterTest(true);
    }

    public function test_livequiz_add_instance() {
        global $DB;

        $quizdata = new stdClass();
        $quizdata->name = 'Test Quiz';
        $quizdata->intro = 'This is a test quiz.';

        $id = livequiz_add_instance($quizdata);
        $this->assertIsInt($id);
        $this->assertEquals('Test Quiz', $DB->get_field('livequiz', 'name', ['id' => $id]));
        $this->assertTrue($DB->record_exists('livequiz', ['id' => $id]));
    }

    public function test_livequiz_update_instance() {
        global $DB;

        $quizdata = new stdClass();
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

    public function test_livequiz_delete_instance() {
        global $DB;

        $quizdata = new stdClass();
        $quizdata->name = 'Test Quiz';
        $quizdata->intro = 'This is a test quiz.';

        $id = livequiz_add_instance($quizdata);
        $result = livequiz_delete_instance($id);
        $this->assertTrue($result);
        $this->assertFalse($DB->record_exists('livequiz', ['id' => $id]));
    }
}