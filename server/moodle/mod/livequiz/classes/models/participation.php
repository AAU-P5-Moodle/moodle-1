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
 */
class participation {
    /**
     * Participation id
     * @var int $id
     */
    private int $id;
    /**
     * @var int $studentid
     */
    private int $studentid;
    /**
     * @var int $livequizid
     */
    private int $livequizid;

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
     * @return boolean
     */
    public function add_participation(): bool {
        global $DB;
        $record = new stdClass();
        $record->studentid = $this->studentid;
        $record->livequizid = $this->livequizid;
        $success = false;
        try {
            $success = $DB->insert_record('participation', $record);
        } catch (\dml_exception $dmle) {
            echo $dmle->getMessage();
        }
        return $success;
    }
    /**
     * Summary of get_participation_by_studentid
     * @param  $studentid
     */
    public static function get_participation_by_studentid($studentid) {
        global $DB;
        return $DB->get_record('participation', ['studentid' => $studentid]);
    }

    /**
     * get_id
     * @return int
     */
    public function get_id(): int {
        return $this->id;
    }
    /**
     * get_studentid
     * @return int
     */
    public function get_studentid(): int {
        return $this->studentid;
    }
    /**
     * get_livequizid
     * @return int
     */
    public function get_livequizid(): int {
        return $this->livequizid;
    }
    /**
     * set_id
     * @param int $id
     * @return void
     */
    public function set_id(int $id): void {
        $this->id = $id;
    }
    /**
     * set_studentid
     * @param int $studentid
     * @return void
     */
    public function set_studentid(int $studentid): void {
        $this->studentid = $studentid;
    }
    /**
     * set_livequizid
     * @param int $livequizid
     * @return void
     */
    public function set_livequizid(int $livequizid): void {
        $this->livequizid = $livequizid;
    }
}
