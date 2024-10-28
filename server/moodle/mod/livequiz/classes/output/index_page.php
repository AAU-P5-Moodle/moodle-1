<?php
// Standard GPL and phpdocs

namespace mod_livequiz\output;

use renderable;
use renderer_base;
use templatable;
use stdClass;
use moodle_url;

class index_page implements renderable, templatable {
    /** @var string $sometext Some text to show how to pass data to a template. */
    private $sometext = null;

    protected $cmid;

    public function __construct(string $sometext, int $id) {
        $this->sometext = $sometext;
        $this->cmid = $id;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @return stdClass
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = new stdClass();
        $data->url = new moodle_url('/mod/livequiz/attempt.php', ['id' => $this->cmid]);
        return $data;
    }
}