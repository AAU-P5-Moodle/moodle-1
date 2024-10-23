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


    public function __construct($name, $course_id, $intro, $introformat, $timecreated, $timeupdated)
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

            $quiz_id = $DB->insert_record('livequiz', $this);
            //$question_ids = $DB->insert_records('livequiz_questions', $questions);
            //$DB->insert_records('livequiz_quiz_questions', ['quiz_id' => $quiz_id, 'question_id' => $question_ids]);

            //foreach ($questions as $question) {
            //    $question_id = $DB->insert_record('livequiz_questions', $question);
            //    $DB->insert_record('livequiz_quiz_questions', ['quiz_id' => $quiz_id, 'question_id' => $question_id]);
            //}

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
        }

        return $quiz_id;
    }

    /**
     * @throws dml_exception
     */
    public static function get_livequiz_by_course($course_id)
    {
        global $DB;
        return $DB->get_record('livequiz', ['course_id' => $course_id]);
    }

    public static function append_questions_to_quiz($questions, $quiz_id): void
    {
        global $DB;
        try {
            $transaction = $DB->start_delegated_transaction();

            foreach ($questions as $question) {
                $question_id = $DB->insert_record('livequiz_questions', $question);
                $DB->insert_record('livequiz_quiz_questions', ['quiz_id' => $quiz_id, 'question_id' => $question_id]);
            }

            $transaction->allow_commit();
        } catch (dml_exception $e) {
            $transaction->rollback($e);
        }
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