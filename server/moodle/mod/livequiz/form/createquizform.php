<?php
require_once("$CFG->libdir/formslib.php");

class createquizform extends moodleform {
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        $mform->addElement('text', 'name', get_string('livequizname', 'local_livequiz'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', get_string('missingname'), 'required', null, 'client');

        $mform->addElement('textarea', get_string('livequizdescription', 'local_livequiz', 'wrap="virtual" rows="10" cols="50"'));
        $mform->setType('description', PARAM_TEXT);

        $mform->addElement('button', 'buttonaddquestion', get_string('addquestion', 'local_livequiz'));
    }
}

