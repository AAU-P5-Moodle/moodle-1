<?php
// This file is part of Moodle - http://moodle.org/
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

function xmldb_livequiz_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2024072506) {

        // Define table livequiz to be created.
        $livequiz_table = new xmldb_table('livequiz');
        $course_id = new xmldb_field('course', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding fields to table livequiz.
        $livequiz_table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $livequiz_table->add_field('name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $livequiz_table->add_field('course', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $livequiz_table->add_field('intro', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $livequiz_table->add_field('introformat', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0');
        $livequiz_table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $livequiz_table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table livequiz.
        $livequiz_table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $livequiz_table->add_key('fk_course', XMLDB_KEY_FOREIGN, ['course'], 'mdl_course', ['id']);

        // Conditionally launch create table for livequiz.
        if ($dbman->table_exists($livequiz_table)) {
            $dbman->add_field($livequiz_table, $course_id);
        } else {
            $dbman->create_table($livequiz_table);
        }

        // Define table questions to be created.
        $questions_table = new xmldb_table('questions');

        // Adding fields to table questions.
        $questions_table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $questions_table->add_field('title', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $questions_table->add_field('description', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $questions_table->add_field('timelimit', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $questions_table->add_field('explanation', XMLDB_TYPE_TEXT, null, null, null, null, null);

        // Adding keys to table questions.
        $questions_table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for questions.
        if (!$dbman->table_exists($questions_table)) {
            $dbman->create_table($questions_table);
        }

        // Define table answers to be created.
        $answers_table = new xmldb_table('answers');

        // Adding fields to table answers.
        $answers_table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $answers_table->add_field('correct', XMLDB_TYPE_BINARY, null, null, XMLDB_NOTNULL, null, null);
        $answers_table->add_field('description', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $answers_table->add_field('explanation', XMLDB_TYPE_TEXT, null, null, null, null, null);

        // Adding keys to table answers.
        $answers_table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for answers.
        if (!$dbman->table_exists($answers_table)) {
            $dbman->create_table($answers_table);
        }

        // Define table quiz_student to be created.
        $quiz_student_table = new xmldb_table('quiz_student');

        // Adding fields to table quiz_student.
        $quiz_student_table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $quiz_student_table->add_field('livequiz_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $quiz_student_table->add_field('student_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table quiz_student.
        $quiz_student_table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $quiz_student_table->add_key('fk_livequiz', XMLDB_KEY_FOREIGN, ['livequiz_id'], 'livequiz', ['id']);
        $quiz_student_table->add_key('fk_student', XMLDB_KEY_FOREIGN, ['student_id'], 'mdl_user', ['id']);

        // Conditionally launch create table for quiz_student.
        if (!$dbman->table_exists($quiz_student_table)) {
            $dbman->create_table($quiz_student_table);
        }

        // Define table quiz_lecturer to be created.
        $quiz_lecturer_table = new xmldb_table('quiz_lecturer');

        // Adding fields to table quiz_lecturer.
        $quiz_lecturer_table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $quiz_lecturer_table->add_field('lecturer_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $quiz_lecturer_table->add_field('quiz_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table quiz_lecturer.
        $quiz_lecturer_table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $quiz_lecturer_table->add_key('fk_lecturer', XMLDB_KEY_FOREIGN, ['lecturer_id'], 'mdl_user', ['id']);
        $quiz_lecturer_table->add_key('fk_quiz', XMLDB_KEY_FOREIGN, ['quiz_id'], 'livequiz', ['id']);

        // Conditionally launch create table for quiz_lecturer.
        if (!$dbman->table_exists($quiz_lecturer_table)) {
            $dbman->create_table($quiz_lecturer_table);
        }

        // Define table quiz_questions to be created.
        $quiz_questions_table = new xmldb_table('quiz_questions');

        // Adding fields to table quiz_questions.
        $quiz_questions_table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $quiz_questions_table->add_field('quiz_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $quiz_questions_table->add_field('question_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table quiz_questions.
        $quiz_questions_table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $quiz_questions_table->add_key('fk_quiz', XMLDB_KEY_FOREIGN, ['quiz_id'], 'livequiz', ['id']);
        $quiz_questions_table->add_key('fk_question', XMLDB_KEY_FOREIGN, ['question_id'], 'questions', ['id']);

        // Conditionally launch create table for quiz_questions.
        if (!$dbman->table_exists($quiz_questions_table)) {
            $dbman->create_table($quiz_questions_table);
        }


        // Define table questions_answers to be created.
        $questions_answers_table = new xmldb_table('questions_answers');

        // Adding fields to table questions_answers.
        $questions_answers_table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $questions_answers_table->add_field('question_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $questions_answers_table->add_field('answer_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table questions_answers.
        $questions_answers_table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $questions_answers_table->add_key('fk_question', XMLDB_KEY_FOREIGN, ['question_id'], 'questions', ['id']);
        $questions_answers_table->add_key('fk_answer', XMLDB_KEY_FOREIGN, ['answer_id'], 'answers', ['id']);

        // Conditionally launch create table for questions_answers.
        if (!$dbman->table_exists($questions_answers_table)) {
            $dbman->create_table($questions_answers_table);
        }


        // Define table questions_lecturer to be created.
        $questions_lecturer_table = new xmldb_table('questions_lecturer');

        // Adding fields to table questions_lecturer.
        $questions_lecturer_table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $questions_lecturer_table->add_field('question_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $questions_lecturer_table->add_field('lecturer_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table questions_lecturer.
        $questions_lecturer_table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $questions_lecturer_table->add_key('fk_question', XMLDB_KEY_FOREIGN, ['question_id'], 'questions', ['id']);
        $questions_lecturer_table->add_key('fk_lecturer', XMLDB_KEY_FOREIGN, ['lecturer_id'], 'mdl_user', ['id']);

        // Conditionally launch create table for questions_lecturer.
        if (!$dbman->table_exists($questions_lecturer_table)) {
            $dbman->create_table($questions_lecturer_table);
        }

        // Define table students_answers to be created.
        $students_answers_table = new xmldb_table('students_answers');

        // Adding fields to table students_answers.
        $students_answers_table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $students_answers_table->add_field('student_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $students_answers_table->add_field('answer_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table students_answers.
        $students_answers_table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $students_answers_table->add_key('fk_student', XMLDB_KEY_FOREIGN, ['student_id'], 'mdl_user', ['id']);
        $students_answers_table->add_key('fk_answer', XMLDB_KEY_FOREIGN, ['answer_id'], 'answers', ['id']);

        // Conditionally launch create table for students_answers.
        if (!$dbman->table_exists($students_answers_table)) {
            $dbman->create_table($students_answers_table);
        }

        // Define table course_quiz to be created.
        $course_quiz_table = new xmldb_table('course_quiz');

        // Adding fields to table course_quiz.
        $course_quiz_table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $course_quiz_table->add_field('course_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $course_quiz_table->add_field('quiz_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table course_quiz.
        $course_quiz_table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $course_quiz_table->add_key('fk_course', XMLDB_KEY_FOREIGN, ['course_id'], 'mdl_course', ['id']);
        $course_quiz_table->add_key('fk_quiz', XMLDB_KEY_FOREIGN, ['quiz_id'], 'livequiz', ['id']);

        // Conditionally launch create table for course_quiz.
        if (!$dbman->table_exists($course_quiz_table)) {
            $dbman->create_table($course_quiz_table);
        }

        // Livequiz savepoint reached.
          upgrade_mod_savepoint(true, 2024072506, 'livequiz');
    }

    return true;
}