<?php

namespace mod_livequiz\livequiz;

use DateTime;
use dml_exception;
use mod_livequiz\question\question;

class livequiz
{
    /**
     * @throws dml_exception
     */
    public function __construct($name, $course_id, $intro, $introformat, $timecreated, $timeupdated, $questions)
    {
        global $DB;
        try {
            $transaction = $DB->start_delegated_transaction();

            $this->$name = $name;
            $this->$course_id = $course_id;
            $this->$intro = $intro;
            $this->$introformat = $introformat;
            $this->$timecreated = $timecreated;
            $this->$timeupdated = $timeupdated;
            $this->$questions = $questions;

            foreach ($questions as $question) {
                $question = new question($question->name, $question->questiontext, $question->questiontextformat, $question->generalfeedback, $question->generalfeedbackformat, $question->rightanswer, $question->rightanswerformat, $question->wronganswer1, $question->wronganswer1format, $question->wronganswer2, $question->wronganswer2format, $question->wronganswer3, $question->wronganswer3format, $question->timecreated, $question->timeupdated);
            }

            $DB->insert_record('livequiz', $this);

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
        }




        return $this;
    }

    /**
     * @throws dml_exception
     */
    public static function get_livequiz_by_course($course_id)
    {
        global $DB;
        return $DB->get_record('livequiz', ['course_id' => $course_id]);
    }

    /**
     * @throws dml_exception
     */
    public static function get_livequiz($id)
    {
        global $DB;
        return $DB->get_record('livequiz', ['id' => $id]);
    }

    /**
     * @throws dml_exception
     */
    public function get_livequizzes(): array
    {
        return $this->db->get_records('livequiz');
    }

    /**
     * @throws dml_exception
     */
    public function add_livequiz($livequiz): bool|int
    {
        return $this->db->insert_record('livequiz', $livequiz);
    }

    /**
     * @throws dml_exception
     */
    public function update_livequiz($livequiz): bool
    {
        return $this->db->update_record('livequiz', $livequiz);
    }

    /**
     * @throws dml_exception
     */
    public function delete_livequiz($id): bool
    {
        return $this->db->delete_records('livequiz', ['id' => $id]);
    }
}