<?php
require_once('answer.php');

class slider implements answer {
	private $min;
	private $max;

	public function __construct(int $min, int $max){
		$this->min = $min;
		$this->max = $max;
	}

	public function html() : string {
		return "
			<form action='quizrunner/wait.php' method='POST' class='answer slider'>
				<output>24</output><br>
				<input type='range' name='answer' min='$this->min' max='$this->max' oninput='this.previousElementSibling.previousElementSibling.value = this.value'>
				<button type='submit' name='submit''>Submit</button>
			</form>
		";
	}
}
