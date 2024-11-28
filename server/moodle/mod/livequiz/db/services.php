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
 * Livequiz access information file
 *
 * @package   mod_livequiz
 * @copyright Computer science Aalborg university  {@link http:/aau.dk}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


namespace mod_livequiz\external;

defined('MOODLE_INTERNAL') || die();

$functions = [
    'mod_livequiz_submit_quiz' => [
        'classname'   => 'mod_livequiz\external\submit_quiz',
        'description' => 'Record user participation and answers in a livequiz.',
        'type'        => 'write',
        'ajax'        => true,
        'services'    => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
    'mod_livequiz_update_session' => [
        'classname'   => 'mod_livequiz\external\update_session',
        'description' => 'Update the session with currently checked answers in the live quiz module.',
        'type'        => 'write',
        'ajax'        => true,
        'services'    => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
    'mod_livequiz_save_question' => [
        'classname'   => 'mod_livequiz\external\save_question',
        'description' => 'Save a question.',
        'type'        => 'write',
        'ajax'        => true,
        'services'    => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
    'mod_livequiz_delete_question' => [
        'classname'   => 'mod_livequiz\external\delete_question',
        'description' => 'Delete a question.',
        'type'        => 'write',
        'ajax'        => true,
        'services'    => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
    'mod_livequiz_get_question' => [
        'classname'   => 'mod_livequiz\external\get_question',
        'description' => 'Retrieves a question.',
        'type'        => 'read',
        'ajax'        => true,
        'services'    => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
    'mod_livequiz_get_lecturer_quiz' => [
        'classname'   => 'mod_livequiz\external\get_lecturer_quiz',
        'description' => 'Retrieves all questions of a lecturer.',
        'type'        => 'read',
        'ajax'        => true,
        'services'    => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
    'mod_livequiz_reuse_question' => [
        'classname'   => 'mod_livequiz\external\reuse_question',
        'description' => 'Imports existing questions into a quiz',
        'type'        => 'write',
        'ajax'        => true,
        'services'    => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
];

$services = [];
