<?php

require_once('answer/answer.php');

class question {
	public string $image;
	public string $prompt;
	public answer $answer;
	
	public function html(){
		return "
			<div>
				<img src='$this->image'/>
				<div class='progress-bar'>??%</div>
				<div class='prompt'>
				<p>$this->prompt</p>
			</div>
			{$this->answer->html()}
		";
	}

	public function display(){
		echo $this->html();
	}
}
