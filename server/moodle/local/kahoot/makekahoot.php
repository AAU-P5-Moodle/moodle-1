<?php
require_once('../../config.php');
require_once('form/makekahoot_form.php');
require_login();

$PAGE->set_url(new moodle_url('/local/kahoot/makekahoot.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title("Make a Kahoot");
$PAGE->set_heading("Create a Kahoot");

echo $OUTPUT->header();

// Opret formular
$mform = new makekahoot_form();

// Hvis formularen er indsendt og valideret
if ($mform->is_cancelled()) {
    // Håndter annullering
} else if ($data = $mform->get_data()) {
    // Indsæt data i databasen
    $record = new stdClass();
    $record->name = $data->name;
    $record->description = $data->description;
    $record->timecreated = time();

    $DB->insert_record('local_kahoot', $record);

    // Vis en bekræftelse
    echo $OUTPUT->notification('Kahoot created successfully!', 'notifysuccess');
}

// Vis formularen
$mform->display();

echo $OUTPUT->footer();
