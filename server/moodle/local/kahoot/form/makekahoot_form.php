<?php
require_once("$CFG->libdir/formslib.php");

class makekahoot_form extends moodleform {
    // Definer formularen
    public function definition() {
        $mform = $this->_form;

        // Tilføj et tekstfelt til navnet
        $mform->addElement('text', 'name', get_string('kahootname', 'local_kahoot'));
        $mform->setType('name', PARAM_NOTAGS);  // Altid sikkerhed for input
        $mform->addRule('name', null, 'required', null, 'client');

        // Tilføj et tekstområde til beskrivelse
        $mform->addElement('textarea', 'description', get_string('kahootdescription', 'local_kahoot'), 'wrap="virtual" rows="10" cols="50"');
        $mform->setType('description', PARAM_TEXT);

        // Tilføj en submit-knap
        $mform->addElement('submit', 'submitbutton', get_string('submit'));
    }

    // Validation hvis nødvendigt
    function validation($data, $files) {
        return array();  // Den gør ingenting pt.
        
    }
}
