<?php

global $ADMIN;
defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings = new admin_settingpage('mod_livequiz', get_string('pluginname', 'mod_livequiz'));

    $settings->add(new admin_setting_configtext('livequiz/some_setting',
        get_string('somesetting', 'mod_livequiz'), get_string('somesetting_desc', 'mod_livequiz'), 'default_value'));

    $ADMIN->add('modsettings', $settings);
}