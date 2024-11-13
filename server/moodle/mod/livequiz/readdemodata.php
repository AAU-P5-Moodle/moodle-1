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



defined('MOODLE_INTERNAL') || die();

use mod_livequiz\models\livequiz;
use mod_livequiz\models\question;
use mod_livequiz\models\answer;
use mod_livequiz\services\livequiz_services;

require_once(dirname(__DIR__) . '/livequiz/classes/models/livequiz.php');

/**
 * Temporary read demo data class
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class readdemodata {
    /**
     * Reads the demo data and creates objects from it
     * @return livequiz object
     */
    public static function insertdemodata(livequiz $livequiz): livequiz {
        $livequizservice = livequiz_services::get_singleton_service_instance();

        // Read the JSON file.
        $json = file_get_contents('demodata.json');

        // Check if the file was read successfully.
        if ($json === false) {
            die('Error reading the JSON file');
        }

        // Decode the JSON file.
        $jsondata = json_decode($json, true);

        // Check if the JSON was decoded successfully.
        if ($jsondata === null) {
            die('Error decoding the JSON file');
        }

        $jsondata = $jsondata["quiz1"];
        $questions = [];

        // Prepare questions.
        foreach ($jsondata["questions"] as $question) {
            $modelquestion = new question(
                $question["title"],
                $question["description"],
                $question["timelimit"],
                $question["explanation"]
            );
            foreach ($question["answers"] as $answer) {
                $modelanswer = new answer(
                    $answer["correct"],
                    $answer["description"],
                    $answer["explanation"]
                );
                $modelquestion->add_answer($modelanswer);
            }
            $questions[] = $modelquestion;
        }
        $livequiz->add_questions($questions);
        $livequiz = $livequizservice->submit_quiz($livequiz); // Insert into database.
        return $livequiz;
    }
}
