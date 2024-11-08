<?php

namespace mod_livequiz\external;

use core_external\external_function_parameters;
use core_external\external_value;

/**
 * Class append_participation
 *
 * This class extends the core_external\external_api and is used to handle
 * the external API for appending participation in the live quiz module.
 *
 * @package    mod_livequiz
 * @return     external_function_parameters The parameters required for the execute function.
 */
class append_participation extends \core_external\external_api {
    /**
     * Returns the description of the execute_parameters function.
     * @return external_function_parameters The parameters required for the execute function.
     */
    public static function execute_parameters()  {
        return new external_function_parameters([
            'quizid' => new external_value(PARAM_INT, 'Quiz ID'),
        ]);
    }
    /**
     * Summary of execute
     * @param mixed $quizid
     * @return void
     */
    public static function execute($quizid) {
        global $DB;
        $params = self::validate_parameters(self::execute_parameters(), ['quizid' => $quizid]);
        return $quizid;
    }
    /**
     * Part of the webservice processing flow. Not called directly here,
     * but is in moodle's web service framework.
     * @return \external_function_parameters
     */
    public static function execute_returns(): external_value {
        return new external_value(PARAM_INT, 'Quiz ID');
    }
}