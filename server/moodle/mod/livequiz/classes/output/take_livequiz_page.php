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

    public function __construct(livequiz $livequiz) {
        $this->livequiz = $livequiz;
        $this->sometext="Testsing take livequiz page";
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @return stdClass
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = new stdClass();
        $data->sometext = $this->sometext;
        return $data;
    }
}