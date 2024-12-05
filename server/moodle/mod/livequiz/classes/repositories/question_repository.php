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
 * Repository for question
 *
 * @package    mod_livequiz
 * @copyright  2023
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_livequiz\repositories;

use dml_exception;
use mod_livequiz\models\question;
use mod_livequiz\models\questions_answers_relation;

/**
 * Class question_repository
 *
 * This class represents a part of the model layer of the livequiz plugin.
 *
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class question_repository {
    /**
     * @var string $tablename The name of the table in the database.
     */
    private static string $tablename = 'livequiz_questions';

    /**
     * This function is used to submit a question to the database.
     *
     * @param question $question
     * @return int
     * @throws dml_exception
     */
    public static function insert_question(question $question): int {
        global $DB;
        $questiondata = [
            'title' => $question->get_title(),
            'description' => $question->get_description(),
            'timelimit' => $question->get_timelimit(),
            'explanation' => $question->get_explanation(),
            'type' => $question->get_type(),
        ];

        return $DB->insert_record(self::$tablename, $questiondata);
    }

    /**
     * Gets a question instance.
     *
     * @param int $id
     * @return question
     * @throws dml_exception
     */
    public static function get_question_from_id(int $id): question {
        global $DB;
        $questioninstance = $DB->get_record(self::$tablename, ['id' => $id]);
        $question = new question(
            $questioninstance->title,
            $questioninstance->description,
            $questioninstance->timelimit,
            $questioninstance->explanation
        );
        $question->set_id($questioninstance->id);
        $question->set_type($questioninstance->type);
        return $question;
    }

    /**
     * Gets a question instance with answers.
     *
     * @param int $id
     * @return question
     * @throws dml_exception
     */
    public static function get_question_with_answers_from_id(int $id): question {
        global $DB;
        $questioninstance = $DB->get_record(self::$tablename, ['id' => $id]);
        $question = new question(
            $questioninstance->title,
            $questioninstance->description,
            $questioninstance->timelimit,
            $questioninstance->explanation
        );
        $question->set_id($questioninstance->id);
        $question->set_type($questioninstance->type);
        $answers = questions_answers_relation::get_answers_from_question($id);
        $question->set_answers($answers);
        return $question;
    }

    /**
     * Updates a question in the database.
     *
     * @param question $question
     * @return void
     * @throws dml_exception
     */
    public function update_question(question $question): void {
        global $DB;
        $questiondata = [
            'id' => $question->get_id(),
            'title' => $question->get_title(),
            'description' => $question->get_description(),
            'timelimit' => $question->get_timelimit(),
            'explanation' => $question->get_explanation(),
            'type' => $question->get_type(),
        ];
        $DB->update_record(self::$tablename, $questiondata);
    }

    /**
     * Deletes a question from the database.
     *
     * @param int $questionid
     * @return bool
     * @throws dml_exception
     */
    public static function delete_question(int $questionid): bool {
        global $DB;
        return $DB->delete_records(self::$tablename, ['id' => $questionid]);
    }
}
