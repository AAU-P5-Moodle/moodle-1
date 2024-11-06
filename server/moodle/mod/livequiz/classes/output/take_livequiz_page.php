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

    /** @var int $nubmerofquestions The number of questions in the quiz - Used for navigation */
    private int $nubmerofquestions;
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
        $this->nubmerofquestions = count($livequiz->get_questions());
    }

    /**
     * Get the next question id.
     * @return int
     */
    private function get_next_question_id(): int {
        if ($this->questionid < $this->nubmerofquestions - 1) {
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
        $data = $this->livequiz->prepare_question_for_template($this->questionid);
        $data->cmid = $this->cmid;
        $data->isattempting = true;
        $data->nextquestionid = $this->get_next_question_id();
        $data->previousquestionid = $this->get_previous_question_id();
        // These are used for navigation.
        if ($data->nextquestionid !== $this->questionid) {
            // If the next question is the same as the current question, we don't want to show the next button.
            $data->nexturl = (new moodle_url(
                '/mod/livequiz/attempt.php',
                ['cmid' => $this->cmid, 'questionid' => $data->nextquestionid]
            ))->out(false);
        }
        if ($data->previousquestionid !== $this->questionid) {
            // If the previous question is the same as the current question, we don't want to show the previous button.
            $data->previousurl = (new moodle_url(
                '/mod/livequiz/attempt.php',
                ['cmid' => $this->cmid, 'questionid' => $data->previousquestionid]
            ))->out(false);
        }
        $data->resultsurl = (new moodle_url('/mod/livequiz/results.php', ['id' => $this->cmid, 'livequizid' => $this->livequiz->get_id()]))->out(false);

        return $data;
    }
}
