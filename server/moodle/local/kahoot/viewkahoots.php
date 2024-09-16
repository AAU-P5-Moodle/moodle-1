<?php
require_once('../../config.php');

// Sæt siden op
$PAGE->set_url(new moodle_url('/local/kahoot/viewkahoots.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title("Play Kahoot");
$PAGE->set_heading("Join a Kahoot");
// Inkludér CSS-styling
$PAGE->requires->css(new moodle_url('/local/kahoot/styles.css'));
echo $OUTPUT->header();

// Hent alle kahoots fra databasen
$kahoots = $DB->get_records('local_kahoot');

// Hvis der er kahoots i databasen, vis dem
if ($kahoots) {
    echo html_writer::start_tag('table', ['class' => 'kahoot-table']);

    // Vis tabellens header
    echo html_writer::start_tag('tr');
    echo html_writer::tag('th', 'Kahoot Name');
    echo html_writer::tag('th', 'Description');
    echo html_writer::tag('th', 'Created Time');
    echo html_writer::end_tag('tr');

    // Loop gennem hver kahoot og vis dataene
    foreach ($kahoots as $kahoot) {
        echo html_writer::start_tag('tr');
        echo html_writer::tag('td', format_string($kahoot->name));
        echo html_writer::tag('td', format_text($kahoot->description));
        echo html_writer::tag('td', userdate($kahoot->timecreated));
        echo html_writer::end_tag('tr');
    }

    echo html_writer::end_tag('table');
} else {
    // Hvis ingen kahoots findes, vis en besked
    echo $OUTPUT->notification('No Kahoots found.', 'notifymessage');
}

echo $OUTPUT->footer();
