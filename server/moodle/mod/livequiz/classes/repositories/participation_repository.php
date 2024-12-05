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

/**
 * Repository for participation
 *
 * @package    mod_livequiz
 * @copyright  2023
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_livequiz\repositories;

use dml_exception;
use mod_livequiz\models\participation;
use stdClass;

/**
 * Class participation_repository
 *
 * This class represents a part of the model layer of the livequiz plugin.
 *
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class participation_repository {
    /**
     * @var string $tablename The name of the table in the database.
     */
    private static string $tablename = 'participation';

    /**
     * Summary of add_participation
     * @param participation $participation
     * @return boolean
     */
    public function add_participation(participation $participation): bool {
        global $DB;
        $record = new stdClass();
        $record->studentid = $participation->get_studentid();
        $record->livequizid = $participation->get_livequizid();
        try {
            return $DB->insert_record(self::$tablename, $record);
        } catch (dml_exception $dmle) {
            echo $dmle->getMessage();
            return false;
        }
    }

    /**
     * Summary of get_participation_by_studentid
     * @param  int $studentid
     * @return false|mixed|stdClass
     * @throws dml_exception
     */
    public static function get_participation_by_studentid(int $studentid): mixed {
        global $DB;
        return $DB->get_record('participation', [self::$tablename => $studentid]);
    }
}
