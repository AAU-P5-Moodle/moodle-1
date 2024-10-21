<?php
require_once("$CFG->libdir/formslib.php");

class createquizform extends moodleform {
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        $mform->addElement('html', '<div class="quiz_form_container">');

        $mform->addElement('text', 'name', "Quiz Name");
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', get_string('missingname'), 'required', null, 'client');

        $mform->addElement('textarea', "quiz_Description", "Description");
        $mform->setType('description', PARAM_TEXT);

        $mform->addElement('html', '</div>');

        $mform->addElement('button', 'buttonaddquestion',"add question");
    }
}

