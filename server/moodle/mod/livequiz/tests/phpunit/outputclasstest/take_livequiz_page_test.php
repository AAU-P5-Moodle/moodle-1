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
use stdClass;
use ReflectionClass;
use ReflectionException;

/**
 * Unit tests for class take_livequiz_page.
 *
 * @package    mod_livequiz
 * @category   test
 */
final class take_livequiz_page_test extends advanced_testcase {
    /**
     * Setup that runs before each test in the file
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
    }

    public function test_get_next_question_index() {

        $cmid = 1;
        $livequiz = ;
        $livequiz->set_questions([1, 2, 3, 4, 5]);
        $questionindex = 2;
        $take_livequiz_page = new \mod_livequiz\output\take_livequiz_page($cmid, $livequiz, $questionindex);
        $this->assertEquals(3, $take_livequiz_page->get_next_question_index());
    }


}