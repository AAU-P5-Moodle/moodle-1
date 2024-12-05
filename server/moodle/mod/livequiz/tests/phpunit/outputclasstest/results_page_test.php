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
use core\exception\moodle_exception;
use dml_exception;
use mod_livequiz\models\answer;
use mod_livequiz\models\livequiz;
use mod_livequiz\models\question;
use mod_livequiz\output\results_page;
use mod_livequiz\services\livequiz_services;
use PhpXmlRpc\Exception;
/**
 * Unit tests for class results_page.
 *
 * @package    mod_livequiz
 * @category   test
 * @copyright  2024 Software AAU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class results_page_test extends advanced_testcase {
    /** @var results_page $resultspage the resultspage that are used in the tests */
    protected results_page $resultspage;
    /**
     * Setup that runs before each test in the file
     * @throws dml_exception
     * @throws Exception
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();

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
        $livequizid = $DB->insert_record('livequiz', $livequizdata);

        $livequiz = livequiz::get_livequiz_instance($livequizid);
        $questions = [
            new question(
                'Test question 1',
                'Test description 1',
                0,
                "Test explanation 1"
            ),
            new question(
                'Test question 2',
                'Test description 2',
                0,
                "Test explanation 2"
            ),
            new question(
                'Test question 3',
                'Test description 3',
                0,
                "Test explanation 3"
            ),
        ];

        $answersquestion1 = [
            new answer(1, 'Answer description 1.1', "Answer explanation 1.1"),
            new answer(1, 'Answer description 1.2', "Answer explanation 1.2"),
            new answer(0, 'Answer description 1.3', "Answer explanation 1.3"),
        ];

        $answersquestion2 = [
            new answer(1, 'Answer description 2.1', "Answer explanation 2.1"),
            new answer(0, 'Answer description 2.2', "Answer explanation 2.2"),
            new answer(0, 'Answer description 2.3', "Answer explanation 2.3"),
        ];

        $answersquestion3 = [
            new answer(0, 'Answer description 3.1', "Answer explanation 3.1"),
            new answer(0, 'Answer description 3.2', "Answer explanation 3.2"),
            new answer(1, 'Answer description 3.3', "Answer explanation 3.3"),
        ];

        $questions[0]->add_answers($answersquestion1);
        $questions[1]->add_answers($answersquestion2);
        $questions[2]->add_answers($answersquestion3);

        $livequiz->add_questions($questions);
        $dbservice = livequiz_services::get_singleton_service_instance();
        $livequiz = $dbservice->submit_quiz($livequiz, 1);

        $participation = $dbservice->insert_participation(1, $livequiz->get_id());

        $this->resultspage = new results_page(1, $livequiz, $participation);

        $dbservice->insert_answer_choice(
            1,
            $livequiz->get_question_by_index(0)->get_answers()[0]->get_id(),
            $participation->get_id()
        );

        $dbservice->insert_answer_choice(
            1,
            $livequiz->get_question_by_index(0)->get_answers()[2]->get_id(),
            $participation->get_id()
        );

        $dbservice->insert_answer_choice(
            1,
            $livequiz->get_question_by_index(1)->get_answers()[0]->get_id(),
            $participation->get_id()
        );

        $dbservice->insert_answer_choice(
            1,
            $livequiz->get_question_by_index(2)->get_answers()[2]->get_id(),
            $participation->get_id()
        );
    }

    /**
     * Test of export_for_template
     * @covers       \mod_livequiz\output\results_page::export_for_template
     * @throws moodle_exception
     */
    public function test_export_for_template(): void {
        global $PAGE;
        $data = $this->resultspage->export_for_template($PAGE->get_renderer('mod_livequiz'));

        $this->assertFalse($data->isattempting);

        $this->assertTrue($data->questions[0]->answers[0]['chosen']);
        $this->assertFalse($data->questions[0]->answers[1]['chosen']);
        $this->assertTrue($data->questions[0]->answers[2]['chosen']);

        $this->assertTrue($data->questions[1]->answers[0]['chosen']);
        $this->assertFalse($data->questions[1]->answers[1]['chosen']);
        $this->assertFalse($data->questions[1]->answers[2]['chosen']);

        $this->assertFalse($data->questions[2]->answers[0]['chosen']);
        $this->assertFalse($data->questions[2]->answers[1]['chosen']);
        $this->assertTrue($data->questions[2]->answers[2]['chosen']);
    }
}
