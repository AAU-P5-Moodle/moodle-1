<?php

require_once('../../config.php');

$id = required_param('id', PARAM_INT); // Course module ID

$PAGE->set_url('/mod/livequiz/view.php', array('id' => $id));
$PAGE->set_title(get_string('liveQuiz', 'mod_livequiz'));
$PAGE->set_heading(get_string('live_Quiz', 'mod_livequiz'));

echo $OUTPUT->header();
echo $OUTPUT->heading('Live Quiz');
echo $OUTPUT->footer();
