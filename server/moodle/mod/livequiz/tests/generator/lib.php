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
 * Behat data generator for mod_livequiz.
 *
 * @package   mod_livequiz
 * @category  test
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class mod_livequiz_generator extends testing_module_generator {
    public function create_instance($record = null, ?array $options = null)
    {
        global $CFG;

        require_once($CFG->dirroot.'/mod/livequiz/lib.php');

        $record = (object)(array)$record; // Cast to object.

        $defaultlivequizsettings = [
            'name' => 'Live Quiz',
            'intro' => 'This is a live quiz',
            'introformat' => 1,
            'timecreated' => time(),
            'timemodified' => time(),

        ];

        foreach ($defaultlivequizsettings as $name => $value) {
            // Set default values if not set.
            if (!isset($record->{$name})) {
                $record->{$name} = $value;
            }
        }
        // By calling the parent method, we will create the instance with provided or default settings.
        return parent::create_instance($record, (array)$options);
    }
}
