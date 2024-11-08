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

namespace mod_livequiz\external;

use core_external\external_function_parameters;
use core_external\external_value;
use PhpParser\Node\Param;

/**
 * Class update_session
 *
 * This class extends the core_external\external_api and is used to handle
 * the external API for updating the session with currently checked answers in the live quiz module.
 *
 * @return     external_function_parameters The parameters required for the execute function.
 * @package    mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class update_session extends \core_external\external_api {
    private string $answervalue;
    private int $questionid;

    /**
     * @var int $questionid The question id.
     * @var string $answervalue The values of the answers in JSON format.
     */
    public function __construct($questionid, $answervalue) {
        $this->questionid = $questionid;
        $this->answervalue = $answervalue;
    }
   
    /**
     * Returns the description of the execute_parameters function.
     * @return external_function_parameters The parameters required for the execute function.
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'questionid' => new external_value(PARAM_INT, 'questionid'),
            'answervalue' => new external_value(PARAM_TEXT, 'answervalue'),
        ]);
    }

    /**
     * Summary of execute
     * @param $questionid
     * @param $answervalue
     * @return array
     * @throws \invalid_parameter_exception
     */
    public static function execute($questionid, $answervalue): array {
        global $DB;
        self::validate_parameters(
            self::execute_parameters(),
            ['questionid' => $questionid, 'answervalue' => $answervalue]
        );
        self::update_session($questionid, $answervalue);
        return [
            'questionid' => $questionid,
            'answervalue' => $answervalue,
        ];
    }

    /**
     * Part of the webservice processing flow. Not called directly here,
     * but is in moodle's web service framework.
     * @return array
     */
    public static function execute_returns(): array {
        return [
            new external_value(PARAM_INT, 'questionid'),
            new external_value(PARAM_TEXT, 'answervalue'),
        ];
    }

    /**
     * Update the session with the currently checked answers.
     * @param $questionid
     * @param $answervalue
     * @return void
     */
    public static function update_session($questionid, $answervalue): void {
        $answers = [];
        $decodeanswer = json_decode($answervalue, true);
        foreach ($decodeanswer as $key => $value) {
            $answers[] = $value;
        }
        if (!isset($_SESSION['quiz_answers'])) {
            $_SESSION['quiz_answers'] = [];
        }
        $_SESSION['quiz_answers'][$questionid] = [
            'question_id' => $questionid,
            'answers' => $answers,
        ];
    }
}
