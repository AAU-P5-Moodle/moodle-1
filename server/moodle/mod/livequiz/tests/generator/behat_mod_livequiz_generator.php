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

// This is behats entrypoint for creating livequiz modules.

/**
 * Behat data generator for mod_livequiz.
 *
 * @package   mod_livequiz
 * @category  test
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_mod_livequiz_generator extends behat_generator_base {
    /**
     * Returns an array that defines the modules that can be created by the livequiz generator.
     *
     * @return array
     */
    protected function get_creatable_entities(): array {
        // You have to provide an id to create a livequiz from you behat test.
        return [
            'livequizzes' => [
                'datagenerator' => 'livequiz',
                'required' => ['id'],
            ],
        ];
    }

    /**
     * A way for behat to fetch livequiz Activity Module Id.
     * @throws dml_exception
     * @throws Exception
     */
    protected function get_livequiz_id(string $quizname): int {
        global $DB;

        if (!$id = $DB->get_field('quiz', 'id', ['name' => $quizname])) {
            throw new Exception('There is no quiz with name "' . $quizname . '" does not exist');
        }
        return $id;
    }
}
