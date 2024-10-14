<?php

require_once('answer.php');

class multichoice_choice {
	public string $display;
	public string $value;

	public function __construct(string $display, string $value){
		$this->display	= $display;
		$this->value	= $value;
	}
}

class multichoice implements answer { 
	private array $choices;

	public function __construct(array $choices){
		$this->choices = $choices;
	}

	public function html() : string { 
		$output = '<form action="quizrunner/wait.php" method="POST" class="answer multichoice">';

		foreach ($this->choices as $choice){
			$output .= "<button type='submit' name='answer' value='$choice->value'>$choice->display</button>";
		}

		$output .= '</form>';

		return $output;
	}
}
