<?php

defined('MOODLE_INTERNAL') || die();

function xmldb_livequiz_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2023080400) {
        // Define table livequiz to be created.
        $table = new xmldb_table('livequiz');

        // Adding fields to table livequiz.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('intro', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('introformat', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table livequiz.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for livequiz.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Livequiz savepoint reached.
        upgrade_mod_savepoint(true, 2023080400, 'livequiz');
    }

    return true;
}