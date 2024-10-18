<?php

namespace mod_livequiz\classes;

class db_manager
{


    public static function get_answers_by_question_id($question_id): array
    {
        global $DB;

        return $DB->get_records('questions_answers', array('question_id' => $question_id));
    }

    public static function get_questions_by_livequiz_id($livequiz_id): array
    {
        global $DB;

        return $DB->get_records('quiz_questions', array('quiz_id' => $livequiz_id));
    }

    public static function create_question($question, $livequiz_id): int
    {
        global $DB;

        $question_id = $DB->insert_record('questions', $question);
        $DB->insert_record('quiz_questions', array('quiz_id' => $livequiz_id, 'question_id' => $question_id));

        return $question_id;
    }

    public static function create_answer($answer, $question_id) : int
    {
        global $DB;

        $answer_id = $DB->insert_record('answers', $answer);
        $DB->insert_record('questions_answers', array('question_id' => $question_id, 'answer_id' => $answer_id));

        return $answer_id;
    }

    public static function create_students_answers($student_id, $answer_id) {
        global $DB;

        return $DB->insert_record('students_answers', array('student_id' => $student_id, 'answer_id' => $answer_id));
    }





}