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
 * Repository for livequiz
 *
 * @package    mod_livequiz
 * @copyright  2023
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_livequiz\repositories;


use dml_exception;
use mod_livequiz\models\livequiz;
use stdClass;

/**
 * Class livequiz_repository
 *
 * This class represents a part of the model layer of the livequiz plugin.
 *
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class livequiz_repository {
    /**
     * @var string $tablename The name of the table in the database.
     */
    private static string $tablename = 'livequiz';

    /**
     * Updates the livequiz in the database, and updates the timemodified field.
     *
     * @param livequiz $livequiz
     * @return bool
     * @throws dml_exception
     */
    public function update_quiz(livequiz $livequiz): bool {
        global $DB;

        $livequiz->set_timemodified();

        $record = new stdClass();
        $record->id = $livequiz->get_id();
        $record->timemodified = $livequiz->get_timemodified();

        return $DB->update_record(self::$tablename, $record);
    }
}
