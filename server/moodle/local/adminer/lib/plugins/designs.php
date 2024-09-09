<?php

/** Allow switching designs
* @link https://www.adminer.org/plugins/#use
* @author Jakub Vrana, https://www.vrana.cz/
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerMdlDesigns {
    function css() {
        global $OUTPUT, $PAGE, $CFG;
        $PAGE->set_context(\context_system::instance());
        // print_r($PAGE->theme->css_urls($PAGE));exit;
        $cssurls = $PAGE->theme->css_urls($PAGE);
        $cssurls[] = $CFG->wwwroot . '/local/adminer/lib/plugins/additional.css';
        return $cssurls;
    }
}
