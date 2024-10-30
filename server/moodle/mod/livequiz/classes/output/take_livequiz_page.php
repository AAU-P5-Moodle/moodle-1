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

namespace mod_livequiz\output;

use core\exception\moodle_exception;
use moodle_url;
use renderable;
use renderer_base;
use templatable;
use stdClass;
use mod_livequiz\classes\livequiz;
use mod_livequiz\classes\question;
use function DI\string;

defined('MOODLE_INTERNAL') || die();
require_once(dirname(__DIR__) . '/livequiz.php');


/**
 * Class take_livequiz_page
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class take_livequiz_page implements renderable, templatable {
    /** @var int $cmid the course module id */
    private int $cmid;

    /** @var livequiz $livequiz The quiz that are currently being attempted. */
    private livequiz $livequiz;

    /** @var int $questionid . The id of the question to be rendered*/
    private int $questionid;

    /** @var int $numberofquestions The number of questions in the quiz */
    private int $numberofquestions;

    /**
     * Constructor for take_livequiz_page, which sets the livequiz field.
     *
     * @param int $cmid
     * @param livequiz $livequiz
     * @param int $questionid
     */
    public function __construct(int $cmid, livequiz $livequiz, int $questionid) {
        $this->cmid = $cmid;
        $this->livequiz = $livequiz;
        $this->questionid = $questionid;
        $this->numberofquestions = count($this->livequiz->get_questions());
    }

    /**
     * Get the next question id.
     * @return int
     */
    private function get_next_question_id(): int {
        if ($this->questionid < $this->numberofquestions - 1) {
            return $this->questionid + 1;
        }
        return $this->questionid;
    }

    /**
     * Get the previous question id.
     * @return int
     */
    private function get_previous_question_id(): int {
        if ($this->questionid > 0) {
            return $this->questionid - 1;
        }
        return $this->questionid;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output
     * @return stdClass
     * @throws moodle_exception
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = new stdClass();
        // These are used when submitting the answers.
        $data->quizid = $this->livequiz->get_id();
        $data->questionid = $this->questionid;
        $data->numberofquestions = $this->numberofquestions;

        // These are used for rendering the question.
        $data->quiztitle = $this->livequiz->get_name();
        $data->questiontitle = $this->livequiz->get_question_by_index($this->questionid)->get_title();
        $data->description = $this->livequiz->get_question_by_index($this->questionid)->get_description();
        $rawanswers = $this->livequiz->get_question_by_index($this->questionid)->get_answers();
        $answers = [];
        foreach ($rawanswers as $rawanswer) {
            $answers[] = [
                'id' => $rawanswer->get_id(),
                'answer_description' => $rawanswer->get_description(),
            ];
        }
        $data->answers = $answers;
        if ($this->livequiz->get_question_by_index($this->questionid)->get_hasmultipleanswers()) {
            $data->answertype = string('checkbox');
        } else {
            $data->answertype = string('radio');
        }

        // These are used for navigation.
        $data->nexturl = (new moodle_url(
            '/mod/livequiz/attempt.php',
            ['id' => $this->cmid, 'questionid' => $this->get_next_question_id()]
        ))->out(false);
        $data->previousurl = (new moodle_url(
            '/mod/livequiz/attempt.php',
            ['id' => $this->cmid, 'questionid' => $this->get_previous_question_id()]
        ))->out(false);
        $data->resultsurl = (new moodle_url('/mod/livequiz/results.php', ['id' => $this->cmid]));
        return $data;
    }
}
