<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace mod_livequiz\models;

defined('MOODLE_INTERNAL') || die();

use stdClass;

/**
 * Class Participation
 *
 * This class will handle interactions with the participation table in the database.
 * It will handle the creation, retrieval, and updates of participation records.
 *
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */class Participation {
    /**
     * @var $studentid
     */
    private $studentid;
    /**
     * @var $livequizid
     */
    private $livequizid;

    /**
     * Participation constructor.
     *
     * @param $studentid
     * @param $livequizid
     */
    public function __construct($studentid, $livequizid) {
        $this->studentid = $studentid;
        $this->livequizid = $livequizid;
    }
    /**
     * Summary of add_participation
     * @return void
     */
    public function add_participation() {
        global $DB;
        $record = new stdClass();
        $record->studentid = $this->studentid;
        $record->livequizid = $this->livequizid;
        $DB->insert_record('participation', $record);
    }
    /**
     * Summary of get_participation_by_studentid
     * @param  $studentid
     */
    public static function get_participation_by_studentid($studentid) {
        global $DB;
        return $DB->get_record('participation', ['studentid' => $studentid]);
    }
}
