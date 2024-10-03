<?php
require_once("$CFG->libdir/formslib.php");

class modalform extends moodleform {
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        $mform->addElement('text', 'question', get_string('livequizname', 'local_livequiz'));
        $mform->setType('question', PARAM_TEXT);
        $mform->addRule('name', get_string('missingquestion'), 'required', null, 'client');

        $fileoptions = array(
            'subdirs' => 0,
            'maxbytes' => $CFG->maxbytes,
            'maxfiles' => 1,
            'accepted_types' => array('image/png', 'image/jpeg', 'image/gif',
                'video/mp4', 'video/mp3'),
        );

        $mform->addElement('filepicker', 'filename', get_string('uploadfile', 'local_livequiz'), null, $fileoptions);

//        $mform->addElement('advcheckbox', 'timelimit', 'timelimit', null, ['group' => 1]);
//        $this->add_checkbox_controller(1);



        $mform->addElement('button', 'buttonaddanswer', get_string('addanswer', 'local_livequiz'));

        $mform->addElement('button', 'buttondiscard', get_string('discardform', 'local_livequiz'));
        $mform->addElement('button', 'buttonsave', get_string('saveform', 'local_livequiz'));


    }
}