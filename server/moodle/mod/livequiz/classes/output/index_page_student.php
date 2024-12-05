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
use dml_exception;
use mod_livequiz\models\livequiz;
use mod_livequiz\services\livequiz_services;
use renderable;
use renderer_base;
use templatable;
use stdClass;
use moodle_url;
use mod_livequiz\models\student_quiz_relation;

/**
 * Class index_page_student
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class index_page_student implements renderable, templatable {
    /** @var int $quizid the livequiz to take or retake*/
    private int $quizid;
    /** @var int $studentid the id of the student who is interacting with the quiz.
     */
    private int $studentid;
    /** @var int $cmid the course module id */
    protected int $cmid;

    /** @var livequiz $livequiz the livequiz instance */
    private livequiz $livequiz;

    /**
     * index_page constructor.
     * @param int $cmid
     * @param int $quizid
     * @param int $studentid
     * @throws dml_exception
     */
    public function __construct(int $cmid, int $quizid, int $studentid) {
        $this->cmid = $cmid;
        $this->quizid = $quizid;
        $this->studentid = $studentid;
        $service = livequiz_services::get_singleton_service_instance();
        $this->livequiz = $service->get_livequiz_instance($quizid);
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     * Keeps database ID's confidential by not exposing them in the URLs. Instead, the participation number is used (1-based).
     * @param renderer_base $output
     * @return stdClass
     * @throws moodle_exception
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = new stdClass();
        $data->pagename = "Quiz menu page";
        $data->studentid = $this->studentid;
        $data->hasquestions = !empty($this->livequiz->get_questions());
        $data->quizid = $this->quizid;
        $data->participations = [];
        $service = livequiz_services::get_singleton_service_instance();
        $participations = $service->get_all_student_participation_for_quiz($this->quizid, $this->studentid);
        $_SESSION['participations'] = $participations; // Store participations in session.

        foreach ($participations as $index => $participation) {
            $participationnumber = $index + 1;
            $data->participations[] = (object) [
                'participationnumber'   => $participationnumber, // Displayed number to the user, starting from 1.
                'resultsurl'            => (new moodle_url(
                    '/mod/livequiz/results.php',
                    [
                        'id'                    => $this->cmid, // Course module ID.
                        'livequizid'            => $participation->get_livequizid(), // Live quiz ID.
                        'participationnumber'   => $participationnumber, // Pass the participation number to the results page.
                    ]
                ))->out(false),
            ];
        }

        $data->url = new moodle_url('/mod/livequiz/attempt.php', ['cmid' => $this->cmid]);
        return $data;
    }
}
