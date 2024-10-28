<?php
// Standard GPL and phpdocs

namespace mod_livequiz\output;

use renderable;
use renderer_base;
use templatable;
use stdClass;
use mod_livequiz\classes\livequiz;

require_once(dirname(__DIR__) . '/livequiz.php');

class take_livequiz_page implements renderable, templatable {
    /** @var string $sometext Some text to show how to pass data to a template. */
    private livequiz $livequiz;
    private $sometext = null; 
    private int $questionid =0;

    public function __construct(livequiz $livequiz) {
        $this->livequiz = $livequiz;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @return stdClass
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = new stdClass();
        $data->quiztitle = $this->livequiz->get_quiz_title();
        $data->description = $this->livequiz->get_question_by_index($questionid)->description;
        return $data;
    }
}