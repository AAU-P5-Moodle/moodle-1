<?php

defined('MOODLE_INTERNAL') || die();

function livequiz_add_instance($quizdata){
    global $DB;

    $quizdata->timecreated = time();
    $quizdata->timemodified = time();

    $quizdata->id = $DB->insert_record('livequiz', $quizdata);

    return $quizdata->id;
}

function livequiz_update_instance($quizdata){
    global $DB;

    $quizdata->timemodified = time();
    $quizdata->id = $quizdata->instance;

    $DB->update_record('livequiz', $quizdata);

    return true;
}


function livequiz_delete_instance($id){
    global $DB;

    $DB->delete_records('livequiz', ['id' => $id]);

    return true;
}