@mod @mod_livequiz @javascript

Feature: Edit questions in livequiz activity
  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
    And the following "courses" exist:
      | fullname    | shortname |
      | Test Course | TC        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | TC     | editingteacher |
    And the following "activity" exists:
      # Create a livequiz activity before the test
      | activity | livequiz             |
      | course   | TC                   |
      | idnumber | 1                    |
      | name     | livequiz_europe_quiz |
      | intro    | Test description     |
      | section  | 0                    |
    And I use demodata for the course "TC" and activity "livequiz"
    And I log in as "teacher1"
    And I am on "Test Course" course homepage with editing mode on
    And I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    And I should see "Quiz editor page"
    And "Question 1" "list_item" should exist

  Scenario: Edit question in a livequiz
    #Enter editing menu by clicking list element
    And I click on "//span[@class='question-title' and text()='Question 1']" "xpath_element"
    #Check if fields are filled with correct values from demo data
    And the field "question_title_id" matches value "Question 1"
    And the field "question_description_id" matches value "Which of the following cities is in France?"
    And the field "question_explanation_id" matches value "Paris is a city in France, Nice is a city in France"
    And the field "answer_input_314000" matches value "Paris"
    And the field "answer_input_314001" matches value "Champagne"
    And the field "answer_input_314002" matches value "Nice"
    # Edit the question
    Then I set the field "question_title_id" to "Question 1 - Edited"
    And I set the field "question_description_id" to "Which of the following cities is in France? - Edited"
    And I set the field "question_explanation_id" to "Paris is a city in France, Nice is a city in France - Edited"
    And I set the field "answer_input_314000" to "Paris - Edited"
    And I set the field "answer_input_314001" to "Champagne - Edited"
    And I set the field "answer_input_314002" to "Nice - Edited"
    #Close editing menu
    And "Save Question" "button" should exist
    And I click on "Save Question" "button"
    #Check if title was changed in list
    And "Question 1 - Edited" "list_item" should exist
    And I click on "//span[@class='question-title' and text()='Question 1 - Edited']" "xpath_element"
    #Check if other fields still remain changed in editing menu
    And the field "question_title_id" matches value "Question 1 - Edited"
    And the field "question_description_id" matches value "Which of the following cities is in France? - Edited"
    And the field "question_explanation_id" matches value "Paris is a city in France, Nice is a city in France - Edited"
    And the field "answer_input_314008" matches value "Paris - Edited"
    And the field "answer_input_314009" matches value "Champagne - Edited"
    And the field "answer_input_314010" matches value "Nice - Edited"

  Scenario: Edit question in a livequiz adding additional answers
    #Enter editing menu by clicking icon
    And I click on "//button[@data-id='316000']" "xpath_element"
    #Check if fields are filled with correct values from demo data
    And the field "answer_input_314000" matches value "Paris"
    And the checkbox with id "answer_checkbox_314000" should be checked
    And the field "answer_input_314001" matches value "Champagne"
    And the checkbox with id "answer_checkbox_314001" should not be checked
    And the field "answer_input_314002" matches value "Nice"
    And the checkbox with id "answer_checkbox_314002" should be checked
    # Edit the question
    And I click on "Add Answer" "button"
    And the field "answer_input_1" matches value ""
    And I set the field "answer_input_1" to "Marseille"
    And I click on "answer_checkbox_1" "checkbox"
    And the checkbox with id "answer_checkbox_1" should be checked
    #Close editing menu and save changes
    And "Save Question" "button" should exist
    And I click on "Save Question" "button"
    #Check if changes remain in editing menu
    And I click on "//button[@data-id='316000']" "xpath_element"
    And the field "answer_input_314008" matches value "Paris"
    And the checkbox with id "answer_checkbox_314008" should be checked
    And the field "answer_input_314009" matches value "Champagne"
    And the checkbox with id "answer_checkbox_314009" should not be checked
    And the field "answer_input_314010" matches value "Nice"
    And the checkbox with id "answer_checkbox_314010" should be checked
    And the field "answer_input_314011" matches value "Marseille"
    And the checkbox with id "answer_checkbox_314011" should be checked

  


