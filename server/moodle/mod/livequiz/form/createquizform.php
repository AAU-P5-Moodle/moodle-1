<?php
// This file is part of Moodle - http://moodle.org/.
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Form for creating a quiz in the livequiz module.
 *
 * @package    mod_livequiz
 * @copyright  2024 Software AAU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

/**
 * Form for creating/editing a quiz in the livequiz module.
 *
 * @package    mod_livequiz
 */
class createquizform extends moodleform {
    /**
     * Defines the form elements.
     *
     * This function sets up the form fields for creating or editing a quiz,
     * including the quiz name, description, and buttons for adding questions.
     *
     * @return void
     */
    public function definition(): void {
        $mform = $this->_form; // Reference to the form.

        // Start the form container.
        $mform->addElement('html', '<div class="quiz_form_container">');

        // Quiz name field.
        $mform->addElement('text', 'name', get_string('quizname', 'mod_livequiz'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', get_string('missingname', 'mod_livequiz'), 'required', null, 'client');

        // Quiz description field.
        $mform->addElement('textarea', 'quiz_description', get_string('description', 'mod_livequiz'));
        $mform->setType('quiz_description', PARAM_TEXT);

        // End the form container.
        $mform->addElement('html', '</div>');

        // Button for adding a question.
        $mform->addElement('button', 'button_add_question', get_string('addquestion', 'mod_livequiz'));
    }

    /**
     * Custom validation for the form.
     *
     * @param array $data Submitted form data.
     * @param array $files Uploaded files.
     * @return array An array of validation errors, empty if none.
     */
    public function validation($data, $files): array {
        $errors = [];

        // Ensure that the quiz name is not empty.
        if (empty(trim($data['name']))) {
            $errors['name'] = get_string('missingname', 'mod_livequiz');
        }

        return $errors;
    }
}
