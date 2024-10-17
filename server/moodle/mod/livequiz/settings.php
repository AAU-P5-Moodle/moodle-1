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

// Add settings page.
/**
 * Displays the livequiz view page.
 * @package   mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
global $ADMIN;
if ($ADMIN->fulltree) {
    $settings->add(new admin_settingpage('mod_livequiz', get_string('pluginname', 'mod_livequiz')));

    $settings->add(new admin_setting_configtext(
        'livequiz/some_setting',
        get_string('somesetting', 'mod_livequiz'),
        get_string('somesetting_desc', 'mod_livequiz'),
        'default_value'
    ));

    $ADMIN->add('modsettings', $settings);
}
