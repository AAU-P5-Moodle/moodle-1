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

namespace mod_livequiz;

use mod_livequiz\models\livequiz;
use ReflectionClass;
use ReflectionException;

/**
 * Utility functions for tests of the livequiz.
 *
 * @package    mod_livequiz
 * @category   test
 * @copyright  2024 Software AAU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class test_utility {
    /**
     * Function to construct a livequiz using reflection to access the private constructor
     * @param int $testid
     * @param string $quiztitle
     * @param int $courseid
     * @param string $intro
     * @param int $introformat
     * @param int $timecreated
     * @param int $timemodified
     * @return livequiz
     * @throws ReflectionException
     */
    public static function constructlivequiz(
        int $testid,
        string $quiztitle,
        int $courseid,
        string $intro,
        int $introformat,
        int $timecreated,
        int $timemodified
    ): livequiz {
        $class = new ReflectionClass(livequiz::class);
        $constructor = $class->getConstructor();
        $object = $class->newInstanceWithoutConstructor();
        return $constructor->invoke($object, $testid, $quiztitle, $courseid, $intro, $introformat, $timecreated, $timemodified);
    }

    /**
     * Function that returns array of test data representing a question
     * @param int $id
     * @param string $title
     * @param string $description
     * @param int $timelimit
     * @param string $explanation
     * @param array $answers
     * @return array
     */
    public static function createquestionarray(
        int $id,
        string $title,
        string $description,
        int $timelimit,
        string $explanation,
        int $type,
        array $answers
    ): array {
        return [
            "id" => $id,
            "title" => $title,
            "description" => $description,
            "timelimit" => $timelimit,
            "explanation" => $explanation,
            "type" => $type,
            "answers" => $answers,
        ];
    }

    /**
     * Function that returns array of test data representing a quiz
     * @param int $id
     * @param string $title
     * @param int $courseid
     * @param string $intro
     * @param int $introformat
     * @param int $timecreated
     * @param int $timemodified
     * @param array $questions
     * @param int $questionindex
     * @return array
     */
    public static function createquizarray(
        int $id,
        string $title,
        int $courseid,
        string $intro,
        int $introformat,
        int $timecreated,
        int $timemodified,
        array $questions,
        int $questionindex
    ): array {
        return [
            "id" => $id,
            "title" => $title,
            "courseid" => $courseid,
            "intro" => $intro,
            "introformat" => $introformat,
            "timecreated" => $timecreated,
            "timemodified" => $timemodified,
            "questions" => $questions,
            "questionindex" => $questionindex,
        ];
    }

    /**
     * Function that returns array of test data representing an answer
     * @param int $id
     * @param string $description
     * @param string $explanation
     * @param int $correct
     * @return array
     */
    public static function createanswerarray(
        int $id,
        string $description,
        string $explanation,
        int $correct
    ): array {
        return [
            "id" => $id,
            "description" => $description,
            "explanation" => $explanation,
            "correct" => $correct,
        ];
    }
}
