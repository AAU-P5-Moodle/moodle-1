<?php


require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');
require_once(__DIR__ . '/../../../../question/tests/behat/behat_question_base.php');

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\DriverException;
use Behat\Mink\Exception\ExpectationException;

/**
 * Features context for livequiz module.
 */

class behat_mod_livequiz extends behat_question_base
{
    protected function resolve_page_url(string $page): moodle_url
    {
        switch (strtolower($page)) {
            case 'livequiz':
                return new moodle_url('/mod/livequiz/view.php');
            default:
                throw new Exception('Unrecognised quiz page type "' . $page . '."');
        }
    }

    protected function resolve_page_instance_url(string $type, string $identifier): moodle_url
    {
        global $DB;

        switch (strtolower($type)) {
            case 'instance':
                $quiz = $DB->get_record('quiz', ['name' => $identifier], '*', MUST_EXIST);
                return new moodle_url('/mod/quiz/view.php', ['id' => $quiz->id]);
            default:
                throw new Exception('Unrecognised quiz page type "' . $type . '."');
        }

    }
}
