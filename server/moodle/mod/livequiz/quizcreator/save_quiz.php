<?php

require_once('../../../config.php');

$id = required_param('id', PARAM_INT);

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['question'])){
    global $DB;
    $data = new stdClass();
    $data->id = $id;
    $data->name = required_param('name', PARAM_TEXT);
    $data->intro = required_param('intro',PARAM_TEXT);
    $data->introformat = required_param('introformat', PARAM_TEXT);
    $data->timemodified = required_param('timemodified',PARAM_TIMESTAMPS);
    $data->timecreated = required_param('timecreated', PARAM_TIMESTAMPS);

    $data->questionsarray = required_param('question', PARAM_OBJECT);
    $data->questionsarray->id = required_param('id', PARAM_INT);
    $data->questionsarray->title = required_param('title', PARAM_TEXT);
    $data->questionsarray->timelimit = required_param('timer', type: PARAM_INT);
    $data->questionsarray->explanation = optional_param('explanation', null, PARAM_TEXT);

    $data->questionsarray->answers = json_encode(required_param_array('answers', PARAM_OBJECT));
    /* maybe does this one it knows its a json with this within
    $data->questionsarray->answers->id = required_param('id', PARAM_INT);
    $data->questionsarray->answers->correct = required_param('correct',PARAM_BOOL);
    $data->questionsarray->answers->description = required_param('description', PARAM_TEXT);
    $data->questionsarray->answers->explanation = optional_param('', null, PARAM_TEXT);
    $data->questionsarray->answers->file = optional_param('file',null, PARAM_TEXT);
    */
    try {
        $DB->insert_record('livequiz_questions', $data);
        echo json_encode(['status'=> 'success', 'message' => 'Quiz saved succesfully.']);
    } catch (Exception $e) {
        echo json_encode(['status'=> 'error', 'message' => 'Failed to save quiz: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request or missing data']);
}