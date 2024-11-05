<?php
// File: mod/livequiz/classes/external/append_participation.php

namespace mod_livequiz\external;

defined('MOODLE_INTERNAL') || die();

use external_function_parameters;
use external_value;
use external_single_structure;
use context_module;
use external_api;
 
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
    public static function execute_parameters() {
        return new external_function_parameters([
            'quizid' => new external_value(PARAM_INT, 'Quiz ID'),
        ]);
    }

    /**
     * Executes the append participation process for the given quiz.
     * @param int $quizid The ID of the quiz.
     * @return void
     */
    public static function execute($quizid) {
        global $USER;

        $params = self::validate_parameters(self::execute_parameters(), ['quizid' => $quizid]);
        $context = context_module::instance($params['quizid']);
        self::validate_context($context);

        require_capability('mod/livequiz:participate', $context);

        // Implement your logic here.
        $userid = $USER->id;
        // For example: livequiz_services::append_student_to_quiz($userid, $params['quizid']);


        return ['status' => 'success'];
    }

    public static function execute_returns() {
        return new external_single_structure([
            'status' => new external_value(PARAM_TEXT, 'Status message'),
        ]);
    }
}