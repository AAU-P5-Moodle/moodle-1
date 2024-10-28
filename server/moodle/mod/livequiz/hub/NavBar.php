<?php
// This file is part of Moodle - http://moodle.org/.
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

/**
 * Navbar for the livequiz module.
 *
 * @package    mod_livequiz
 * @copyright  2024 Software AAU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Class to create and display a navbar for the livequiz module.
 *
 * @package    mod_livequiz
 */
class createNavbar {
    /**
     * @var string The active tab name.
     */
    private $activetab;

    /**
     * Constructor for the createNavbar class.
     *
     * @param string $activeTab The currently active tab.
     */
    public function __construct(string $activetab = 'quizcreator') {
        $this->activetab = $activetab;
    }

    /**
     * Generate the HTML for the navbar.
     *
     * @return string The HTML output for the navbar.
     */
    public function definition(): string {
        global $id;

        $tabs = [
            'quizcreator' => get_string('quizcreator', 'mod_livequiz'),
            'quizrunner' => get_string('quizrunner', 'mod_livequiz'),
            'quizstats' => get_string('quizstats', 'mod_livequiz'),
            'questionbank' => get_string('questionbank', 'mod_livequiz'),
        ];

        $output = html_writer::start_div('nav-tabs');

        foreach ($tabs as $tab => $label) {
            $url = new moodle_url('/mod/livequiz/' . $tab, ['id' => $id]);
            $activeclass = ($this->activetab === $tab) ? ' active' : '';
            $output .= html_writer::link($url, $label, ['class' => 'tab-button' . $activeclass]);
        }

        $output .= html_writer::end_div();

        return $output;
    }

    /**
     * Display the navbar.
     *
     * Outputs the generated HTML for the navbar.
     */
    public function display(): void {
        echo $this->definition();
    }
}
