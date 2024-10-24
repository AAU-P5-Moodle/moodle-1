<?php

$activeTab = optional_param('tab', 'quizcreator', PARAM_ALPHA); 

class createNavbar{
    private $activeTab;

    public function __construct($activeTab = 'normal') {
        $this->activeTab = $activeTab; // Store the active tab in a property
    }

    public function definition() {
        $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/mod/livequiz';
        return"
                <!-- Navigation Tabs as Links -->
                <div class='nav-tabs'>
                    <a href='{$base_url}/quizcreator/?tab=quizcreator' class='tab-button'>Quiz Creator</a>
                    <a href='{$base_url}/quizrunner/?tab=quizrunner' class='tab-button'>Quiz Runner</a>
                    <a href='{$base_url}/quizstats/?tab=quizstats' class='tab-button'>Quiz Stats</a>
                    <a href='{$base_url}/questionbank/?tab=questionbank' class='tab-button'>Question Bank</a>
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
