<?php
require_once('../../config.php');
$PAGE->set_url(new moodle_url('/local/kahoot/playkahoot.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title("Play Kahoot");
$PAGE->set_heading("Join a Kahoot");

$PAGE->requires->js_call_amd('local_kahoot/playkahoot', 'init');

echo $OUTPUT->header();
// Din indholdskode her (HTML eller noget andet indhold).
echo $OUTPUT->footer();
