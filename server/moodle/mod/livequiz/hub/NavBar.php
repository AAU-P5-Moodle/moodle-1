<?php

$activeTab = optional_param('tab', 'quizcreator', PARAM_ALPHA); 

class createNavbar{
    private $activeTab;

    public function __construct($activeTab = 'normal') {
        $this->activeTab = $activeTab; // Store the active tab in a property
    }

    public function definition() {
        $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/mod/livequiz';

        //Active tab does not currently work
        return"
                <!-- Navigation Tabs as Links -->
                <div class='nav-tabs'>
                    <a href='{$base_url}/quizcreator/?tab=quizcreator' class='tab-button" . ($this->activeTab === 'quizcreator' ? ' active' : '') . "'>Quiz Creator</a>
                    <a href='{$base_url}/quizrunner/?tab=quizrunner' class='tab-button" . ($this->activeTab === 'quizrunner' ? ' active' : '') . "'>Quiz Runner</a>
                    <a href='{$base_url}/quizstats/?tab=quizstats' class='tab-button" . ($this->activeTab === 'quizstats' ? ' active' : '') . "'>Quiz Stats</a>
                    <a href='{$base_url}/questionbank/?tab=questionbank' class='tab-button" . ($this->activeTab === 'questionbank' ? ' active' : '') . "'>Question Bank</a>
                </div>
        ";
    }
    public function display() {
        echo $this->definition(); // Call the definition method and output the content
    }
}

//echo $OUTPUT->header();

//echo $OUTPUT->heading($strquizzes, 2);

//echo $Body_content;

//echo $OUTPUT->footer();

?>
