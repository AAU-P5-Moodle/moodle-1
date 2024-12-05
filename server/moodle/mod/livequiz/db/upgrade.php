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

/**
 * Livequiz activity version information.
 *
 * @package   mod_livequiz
 * @copyright Department of Computer Science, Aalborg University, 2024  {@link https://aau.dk}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * xmldb_livequiz_upgrade upgrades the database for the LiveQuiz module.
 *
 * @param $oldversion
 * @return true
 * @throws ddl_exception
 * @throws ddl_table_missing_exception
 */
function xmldb_livequiz_upgrade($oldversion): bool {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2024072539) {
        // Define table livequiz to be created.
        $livequiztable = new xmldb_table('livequiz');
        $courseid = new xmldb_field('course', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding fields to table livequiz.
        $livequiztable->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $livequiztable->add_field('name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $livequiztable->add_field('course', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $livequiztable->add_field('intro', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $livequiztable->add_field('introformat', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0');
        $livequiztable->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $livequiztable->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table livequiz.
        $livequiztable->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $livequiztable->add_key('fk_course', XMLDB_KEY_FOREIGN, ['course'], 'mdl_course', ['id']);

        // Conditionally launch create table for livequiz.
        if ($dbman->table_exists($livequiztable)) {
            if (!$dbman->field_exists($livequiztable, $courseid)) {
                $dbman->add_field($livequiztable, $courseid);
            }
        } else {
            $dbman->create_table($livequiztable);
        }

        // Define table questions to be created.
        $questionstable = new xmldb_table('questions');

        // Adding fields to table questions.
        $questionstable->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $questionstable->add_field('title', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $questionstable->add_field('description', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $questionstable->add_field('timelimit', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $questionstable->add_field('explanation', XMLDB_TYPE_TEXT, null, null, null, null, null);

        // Adding keys to table questions.
        $questionstable->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for questions.
        if (!$dbman->table_exists($questionstable)) {
            $dbman->create_table($questionstable);
        }

        // Define table answers to be created.
        $answerstable = new xmldb_table('answers');

        // Adding fields to table answers.
        $answerstable->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $answerstable->add_field('correct', XMLDB_TYPE_BINARY, null, null, XMLDB_NOTNULL, null, null);
        $answerstable->add_field('description', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $answerstable->add_field('explanation', XMLDB_TYPE_TEXT, null, null, null, null, null);

        // Adding keys to table answers.
        $answerstable->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for answers.
        if (!$dbman->table_exists($answerstable)) {
            $dbman->create_table($answerstable);
        }

        // Define table quiz_student to be created.
        $quizstudenttable = new xmldb_table('quiz_student');

        // Adding fields to table quiz_student.
        $quizstudenttable->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $quizstudenttable->add_field('livequiz_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $quizstudenttable->add_field('student_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table quiz_student.
        $quizstudenttable->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $quizstudenttable->add_key('fk_livequiz', XMLDB_KEY_FOREIGN, ['livequiz_id'], 'livequiz', ['id']);
        $quizstudenttable->add_key('fk_student', XMLDB_KEY_FOREIGN, ['student_id'], 'mdl_user', ['id']);

        // Conditionally launch create table for quiz_student.
        if (!$dbman->table_exists($quizstudenttable)) {
            $dbman->create_table($quizstudenttable);
        }

        // Define table quiz_lecturer to be created.
        $quizlecturertable = new xmldb_table('quiz_lecturer');

        // Adding fields to table quiz_lecturer.
        $quizlecturertable->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $quizlecturertable->add_field('lecturer_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $quizlecturertable->add_field('quiz_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table quiz_lecturer.
        $quizlecturertable->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $quizlecturertable->add_key('fk_lecturer', XMLDB_KEY_FOREIGN, ['lecturer_id'], 'mdl_user', ['id']);
        $quizlecturertable->add_key('fk_quiz', XMLDB_KEY_FOREIGN, ['quiz_id'], 'livequiz', ['id']);

        // Conditionally launch create table for quiz_lecturer.
        if (!$dbman->table_exists($quizlecturertable)) {
            $dbman->create_table($quizlecturertable);
        }

        // Define table quiz_questions to be created.
        $quizquestionstable = new xmldb_table('quiz_questions');

        // Adding fields to table quiz_questions.
        $quizquestionstable->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $quizquestionstable->add_field('quiz_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $quizquestionstable->add_field('question_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table quiz_questions.
        $quizquestionstable->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $quizquestionstable->add_key('fk_quiz', XMLDB_KEY_FOREIGN, ['quiz_id'], 'livequiz', ['id']);
        $quizquestionstable->add_key('fk_question', XMLDB_KEY_FOREIGN, ['question_id'], 'questions', ['id']);

        // Conditionally launch create table for quiz_questions.
        if (!$dbman->table_exists($quizquestionstable)) {
            $dbman->create_table($quizquestionstable);
        }

        // Define table questions_answers to be created.
        $questionsanswerstable = new xmldb_table('questions_answers');

        // Adding fields to table questions_answers.
        $questionsanswerstable->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $questionsanswerstable->add_field('question_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $questionsanswerstable->add_field('answer_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table questions_answers.
        $questionsanswerstable->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $questionsanswerstable->add_key('fk_question', XMLDB_KEY_FOREIGN, ['question_id'], 'questions', ['id']);
        $questionsanswerstable->add_key('fk_answer', XMLDB_KEY_FOREIGN, ['answer_id'], 'answers', ['id']);

        // Conditionally launch create table for questions_answers.
        if (!$dbman->table_exists($questionsanswerstable)) {
            $dbman->create_table($questionsanswerstable);
        }

        // Define table questions_lecturer to be created.
        $questionslecturertable = new xmldb_table('questions_lecturer');

        // Adding fields to table questions_lecturer.
        $questionslecturertable->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $questionslecturertable->add_field('question_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $questionslecturertable->add_field('lecturer_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table questions_lecturer.
        $questionslecturertable->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $questionslecturertable->add_key('fk_question', XMLDB_KEY_FOREIGN, ['question_id'], 'questions', ['id']);
        $questionslecturertable->add_key('fk_lecturer', XMLDB_KEY_FOREIGN, ['lecturer_id'], 'mdl_user', ['id']);

        // Conditionally launch create table for questions_lecturer.
        if (!$dbman->table_exists($questionslecturertable)) {
            $dbman->create_table($questionslecturertable);
        }

        // Define table students_answers to be created.
        $studentsanswerstable = new xmldb_table('students_answers');

        // Adding fields to table students_answers.
        $studentsanswerstable->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $studentsanswerstable->add_field('student_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $studentsanswerstable->add_field('answer_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table students_answers.
        $studentsanswerstable->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $studentsanswerstable->add_key('fk_student', XMLDB_KEY_FOREIGN, ['student_id'], 'mdl_user', ['id']);
        $studentsanswerstable->add_key('fk_answer', XMLDB_KEY_FOREIGN, ['answer_id'], 'answers', ['id']);

        // Conditionally launch create table for students_answers.
        if (!$dbman->table_exists($studentsanswerstable)) {
            $dbman->create_table($studentsanswerstable);
        }

        // Define table course_quiz to be created.
        $coursequiztable = new xmldb_table('course_quiz');

        // Adding fields to table course_quiz.
        $coursequiztable->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $coursequiztable->add_field('course_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $coursequiztable->add_field('quiz_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table course_quiz.
        $coursequiztable->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $coursequiztable->add_key('fk_course', XMLDB_KEY_FOREIGN, ['course_id'], 'mdl_course', ['id']);
        $coursequiztable->add_key('fk_quiz', XMLDB_KEY_FOREIGN, ['quiz_id'], 'livequiz', ['id']);

        // Conditionally launch create table for course_quiz.
        if (!$dbman->table_exists($coursequiztable)) {
            $dbman->create_table($coursequiztable);
        }

        // Livequiz savepoint reached.
        upgrade_mod_savepoint(true, 2024072538, 'livequiz');
    }

    if ($oldversion < 2024072510) {
        // Rename table questions to livequiz_questions.
        $questionstable = new xmldb_table('questions');
        if ($dbman->table_exists($questionstable)) {
            $dbman->rename_table($questionstable, 'livequiz_questions');
        }

        // Rename table answers to livequiz_answers.
        $answerstable = new xmldb_table('answers');
        if ($dbman->table_exists($answerstable)) {
            $dbman->rename_table($answerstable, 'livequiz_answers');
        }

        // Rename table quiz_student to livequiz_quiz_student.
        $quizstudenttable = new xmldb_table('quiz_student');
        if ($dbman->table_exists($quizstudenttable)) {
            $dbman->rename_table($quizstudenttable, 'livequiz_quiz_student');
        }

        // Rename table quiz_lecturer to livequiz_quiz_lecturer.
        $quizlecturertable = new xmldb_table('quiz_lecturer');
        if ($dbman->table_exists($quizlecturertable)) {
            $dbman->rename_table($quizlecturertable, 'livequiz_quiz_lecturer');
        }

        // Array for tables with foreign keys.
        $tables = [];

        // Rename table quiz_questions to livequiz_quiz_questions and updated foreign key reftables accordingly.
        $quizquestionstable = new xmldb_table('quiz_questions');
        $tables[] = $quizquestionstable;
        if ($dbman->table_exists($quizquestionstable)) {
            $dbman->rename_table($quizquestionstable, 'livequiz_quiz_questions');
        }

        // Rename table questions_answers to livequiz_questions_answers and updated foreign key reftables accordingly.
        $questionsanswerstable = new xmldb_table('questions_answers');
        $tables[] = ($questionsanswerstable);
        if ($dbman->table_exists($questionsanswerstable)) {
            $dbman->rename_table($questionsanswerstable, 'livequiz_questions_answers');
        }

        // Rename table questions_lecturer to livequiz_questions_lecturer and updated foreign key reftables accordingly.
        $questionslecturertable = new xmldb_table('questions_lecturer');
        $tables[] = $questionslecturertable;
        if ($dbman->table_exists($questionslecturertable)) {
            $dbman->rename_table($questionslecturertable, 'livequiz_questions_lecturer');
        }

        // Rename table students_answers to livequiz_students_answers and updated foreign key reftables accordingly.
        $studentsanswerstable = new xmldb_table('students_answers');
        $tables[] = $studentsanswerstable;
        if ($dbman->table_exists($studentsanswerstable)) {
            $dbman->rename_table($studentsanswerstable, 'livequiz_students_answers');
        }

        // Rename table course_quiz to livequiz_course_quiz.
        $coursequiztable = new xmldb_table('course_quiz');
        if ($dbman->table_exists($coursequiztable)) {
            $dbman->rename_table($coursequiztable, 'livequiz_course_quiz');
        }

        // Change reftable to match new table names for foreign keys in all the relevant intermediate tables.
        foreach ($tables as $table) {
            if ($dbman->table_exists($table)) {
                $oldkey = new xmldb_key('fk_question');
                if ($dbman->find_key_name($table, $oldkey)) {
                    $dbman->drop_key($table, $oldkey);

                    $newkey = new xmldb_key('fk_question');
                    $newkey->set_attributes(XMLDB_KEY_FOREIGN, ['fk_question'], 'livequiz_questions', ['id']);

                    $dbman->add_key($table, $newkey);
                }

                $oldkey = new xmldb_key('fk_answer');
                if ($dbman->find_key_name($table, $oldkey)) {
                    $dbman->drop_key($table, $oldkey);

                    $newkey = new xmldb_key('fk_answer');
                    $newkey->set_attributes(XMLDB_KEY_FOREIGN, ['fk_answer'], 'livequiz_answers', ['id']);

                    $dbman->add_key($table, $newkey);
                }
            }
        }

        // Livequiz savepoint reached.
        upgrade_mod_savepoint(true, 2024072510, 'livequiz');
    }
    if ($oldversion < 2024072516) {
        // Define field type to be added to livequiz_questions.
        $table = new xmldb_table('livequiz_questions');
        $field = new xmldb_field('type', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'explanation');

        // Conditionally launch add field type.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field participation_id to be added to livequiz_students_answers.
        $table = new xmldb_table('livequiz_students_answers');
        $field = new xmldb_field('participation_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null, 'answer_id');

        // Conditionally launch add field participation_id.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define key fk_participation (foreign) to be added to livequiz_students_answers.
        $table = new xmldb_table('livequiz_students_answers');
        $key = new xmldb_key('fk_participation', XMLDB_KEY_FOREIGN, ['participation_id'], 'livequiz_quiz_student', ['id']);

        // Launch add key fk_participation.
        $dbman->add_key($table, $key);

        // Livequiz savepoint reached.
        upgrade_mod_savepoint(true, 2024072516, 'livequiz');
    }
    if ($oldversion < 2024072555) {
        // Define field activityid to be added to livequiz_questions.
        $table = new xmldb_table('livequiz');
        $field = new xmldb_field('activity_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null, 'timemodified');

        // Conditionally launch add field activityid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Livequiz savepoint reached.
        upgrade_mod_savepoint(true, 2024072555, 'livequiz');
    }

    return true;
}
