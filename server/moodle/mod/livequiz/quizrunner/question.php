<?php

require_once('answer/answer.php');

class question {
	public string $image;
	public string $prompt;
	public answer $answer;
	
	public function html(){
        // Assume $progress_percentage is passed to this class somehow ()
        global $progress_percentage;

        // builds the progress bare if it's the time set is more then zero
        $progressBarHtml = '';
        if (isset($progress_percentage) && $progress_percentage > 0) {
            $progressBarHtml = "
                <div class='progress-bar'>
                    <div style='width: {$progress_percentage}%;'>
                        {$progress_percentage}%
                    </div>
                </div>
            ";
        }

		return "
			<div class= 'question-container'>
				<img src='$this->image' alt='quiz image' />
				{$progressBarHtml}
				<div class='prompt'>
				    <p>$this->prompt</p>
			    </div>
			    {$this->answer->html()}
			</div>
		";
	}

	public function display(){
		echo $this->html();
	}
}
