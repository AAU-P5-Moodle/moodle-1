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
use mod_livequiz\models\livequiz;

defined('MOODLE_INTERNAL') || die();
require_once(dirname(__DIR__) . '/models/livequiz.php');

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

    /** @var int $studentid The id of the student taking the quiz */
    private int $studentid;

    /** @var int $questionindex The index of the question in the quiz - Used for navigation */
    private int $questionindex;

    /** @var int $numberofquestions The number of questions in the quiz - Used for navigation */
    private int $numberofquestions;

    /**
     * Constructor for take_livequiz_page, which sets the livequiz field.
     *
     * @param int $cmid
     * @param livequiz $livequiz
     * @param int $questionindex
     * @param int $studentid
     */
    public function __construct(int $cmid, livequiz $livequiz, int $questionindex, int $studentid) {
        $this->cmid = $cmid;
        $this->livequiz = $livequiz;
        $this->questionindex = $questionindex;
        $this->studentid = $studentid;
        $this->questionid = $livequiz->get_questions()[$questionindex]->get_id();
        $this->numberofquestions = count($livequiz->get_questions());
    }

    /**
     * Get the next question id.
     * @return int
     */
    public function get_next_question_index(): int {
        if ($this->questionindex < $this->numberofquestions - 1) {
            return $this->questionindex + 1;
        }
        return $this->questionindex;
    }

    /**
     * Get the previous question id.
     * @return int
     */
    public function get_previous_question_index(): int {
        if ($this->questionindex > 0) {
            return $this->questionindex - 1;
        }
        return $this->questionindex;
    }
    /**
     * Set the question index.
     * @param int $index
     */
    public function set_question_index(int $index): void {
        $this->questionindex = $index;
    }

    /**
     * Get the question index.
     * @return int questionindex
     */
    public function get_question_index(): int {
        return $this->questionindex;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output
     * @return stdClass
     * @throws moodle_exception
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = $this->livequiz->prepare_question_for_template($this->questionindex);
        $data->studentid = $this->studentid;
        $data->cmid = $this->cmid;
        $data->isattempting = true;
        $data->questionid = $this->questionid;
        $data->questionindex = $this->questionindex;
        $data->nextquestionindex = $this->get_next_question_index();
        $data->previousquestionindex = $this->get_previous_question_index();
        $data->numberofquestions = $this->numberofquestions;
        // Check if user has selected answers for this question.
        if (!empty($_SESSION['quiz_answers'][$this->livequiz->get_id()][$this->questionid])) {
            $chosenanswers = $_SESSION['quiz_answers'][$this->livequiz->get_id()][$this->questionid]['answers'];
            foreach ($chosenanswers as $chosenanswer) {
                for ($i = 0; $i < count($data->answers); $i++) {
                    if ($chosenanswer == $data->answers[$i]['answerid']) {
                        $data->answers[$i]['chosen'] = true;
                    }
                }
            }
        }
        // These are used for navigation.
        if ($data->nextquestionindex !== $this->questionindex) {
            // If the next question is the same as the current question, we don't want to show the next button.
            $data->nexturl = (new moodle_url(
                '/mod/livequiz/attempt.php',
                ['cmid' => $this->cmid, 'questionindex' => $data->nextquestionindex]
            ))->out(false);
        }
        if ($data->previousquestionindex !== $this->questionindex) {
            // If the previous question is the same as the current question, we don't want to show the previous button.
            $data->previousurl = (new moodle_url(
                '/mod/livequiz/attempt.php',
                ['cmid' => $this->cmid, 'questionindex' => $data->previousquestionindex]
            ))->out(false);
        }
        $data->resultsurl = (new moodle_url(
            '/mod/livequiz/results.php',
            ['id' => $this->cmid, 'livequizid' => $this->livequiz->get_id()]
        ))->out(false);

        return $data;
    }
}
