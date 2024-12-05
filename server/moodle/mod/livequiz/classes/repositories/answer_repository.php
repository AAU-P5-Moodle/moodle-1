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

/**
 * Repository for answers
 *
 * @package    mod_livequiz
 * @copyright  2023
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_livequiz\repositories;

use dml_exception;
use Exception;
use mod_livequiz\models\answer;

/**
 * Class answer_repository
 *
 * This class represents a part of the model layer of the livequiz plugin.
 *
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class answer_repository {
    /**
     * @var string $tablename The name of the table in the database.
     */
    private static string $tablename = 'livequiz_answers';


    /**
     * Given an answer object, this method will insert the answer to the database
     *
     * @param answer $answer
     * @return int
     * @throws dml_exception
     */
    public static function insert_answer(answer $answer): int {
        global $DB;

        $answerdata = [
            'correct' => $answer->get_correct(),
            'description' => $answer->get_description(),
            'explanation' => $answer->get_explanation(),
        ];

        return $DB->insert_record(self::$tablename, $answerdata);
    }

    /**
     * Get an answer, given its id.
     *
     * @param int $id
     * @return mixed
     * @throws dml_exception
     */
    public static function get_answer_from_id(int $id): answer {
        global $DB;
        $answerdata = $DB->get_record(self::$tablename, ['id' => $id]);
        if (!$answerdata) {
            throw new Exception("No answer found in answers table with id: " . $id);
        }
        $answer = new answer($answerdata->correct, $answerdata->description, $answerdata->explanation);
        $answer->set_id($answerdata->id);
        return $answer;
    }

    /**
     * Update an answer, given its id.
     *
     * @throws dml_exception
     */
    public function update_answer(answer $answer): void {
        global $DB;

        $answerdata = [
            'id' => $answer->get_id(),
            'correct' => $answer->get_correct(),
            'description' => $answer->get_description(),
            'explanation' => $answer->get_explanation(),
        ];

        $DB->update_record(self::$tablename, $answerdata);
    }

    /**
     * Deletes an answer from the database.
     *
     * @param int $answerid
     * @return bool
     * @throws dml_exception
     */
    public static function delete_answer(int $answerid): bool {
        global $DB;
        return $DB->delete_records(self::$tablename, ['id' => $answerid]);
    }
}
