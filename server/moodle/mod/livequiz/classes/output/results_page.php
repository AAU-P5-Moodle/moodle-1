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
use renderable;
use renderer_base;
use templatable;
use stdClass;
use mod_livequiz\models\livequiz;
use mod_livequiz\models\participation;
use mod_livequiz\services\livequiz_services;
use moodle_url;

defined('MOODLE_INTERNAL') || die();
require_once(dirname(__DIR__) . '/models/livequiz.php');

/**
 * Class results_page
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class results_page implements renderable, templatable {
    /** @var int $cmid the course module id */
    protected int $cmid;
    /** @var livequiz $livequiz The live quiz instance */
    private livequiz $livequiz;
    /** @var participation $participation The participation which should be shown*/
    private participation $participation;

    /**
     * index_page constructor.
     * @param int $id
     * @param livequiz $livequiz
     * @param participation $participation
     */
    public function __construct(int $id, livequiz $livequiz, participation $participation) {
        $this->cmid = $id;
        $this->livequiz = $livequiz;
        $this->participation = $participation;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output
     * @return stdClass
     * @throws moodle_exception
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = $this->livequiz->prepare_for_template();
        $data->isattempting = false; // This is the results page, so the user is not attempting the quiz.
        // Get the questions with their answers.
        $livequizservices = livequiz_services::get_singleton_service_instance();

        // Get the student's answers for the participation.
        $participationanswerids = $livequizservices->get_answersids_from_student_in_participation(
            $this->participation->get_studentid(),
            $this->participation->get_id()
        );
        // Add the menu URL for navigation.
        $data->menuurl = (new moodle_url(
            '/mod/livequiz/view.php',
            ['id' => $this->cmid]
        ))->out(false);

        // Prepare the questions' data.
        foreach ($data->questions as $qindex => $question) {
            // Get the student's answer for this question.
            foreach ($question->answers as $aindex => $answer) {
                // Check if the answer is correct.
                $correct = $data->questions[$qindex]->answers[$aindex]['answercorrect'];

                // Check if the answer was selected by the student.
                $data->questions[$qindex]->answers[$aindex]['chosen'] =
                    in_array($answer['answerid'], $participationanswerids);

                // Check if the answer is correct and was selected by the student.
                $data->questions[$qindex]->answers[$aindex]['correct'] =
                    $data->questions[$qindex]->answers[$aindex]['chosen'] && $correct;

                // Check if the answer is correct and was not selected by the student.
                $data->questions[$qindex]->answers[$aindex]['correctnotchosen'] =
                    !$data->questions[$qindex]->answers[$aindex]['chosen'] && $correct;
            }
        }
        return $data;
    }
}
