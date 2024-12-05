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
    # Enter editing menu by clicking list element
    And I click on "//span[@class='question_list_text' and text()='Question 1'][1]" "xpath_element"
    # Check if fields are filled with correct values from demo data
    And the field "question_title_id" matches value "Question 1"
    And the field "question_description_id" matches value "Which of the following cities is in France?"
    And the field "question_explanation_id" matches value "Paris is a city in France, Nice is a city in France"
    And the field with xpath "(//input[@class='answer_input'])[1]" matches value "Paris"
    And the field with xpath "(//input[@class='answer_input'])[2]" matches value "Champagne"
    And the field with xpath "(//input[@class='answer_input'])[3]" matches value "Nice"
    # Edit the question
    Then I set the field "question_title_id" to "Question 1 - Edited"
    And I set the field "question_description_id" to "Which of the following cities is in France? - Edited"
    And I set the field "question_explanation_id" to "Paris is a city in France, Nice is a city in France - Edited"
    # Use Xpath since the fields are dynamically generated
    And I set the field with xpath "(//input[@class='answer_input'])[1]" to "Paris - Edited"
    And I set the field with xpath "(//input[@class='answer_input'])[2]" to "Champagne - Edited"
    And I set the field with xpath "(//input[@class='answer_input'])[3]" to "Nice - Edited"
    # Close editing menu
    And "Save Question" "button" should exist
    And I click on "Save Question" "button"
    # Check if title was changed in list
    And "Question 1 - Edited" "list_item" should exist
    And I click on "//span[@class='question_list_text' and text()='Question 1 - Edited'][1]" "xpath_element"
    # Check if other fields still remain changed in editing menu
    And the field "question_title_id" matches value "Question 1 - Edited"
    And the field "question_description_id" matches value "Which of the following cities is in France? - Edited"
    And the field "question_explanation_id" matches value "Paris is a city in France, Nice is a city in France - Edited"
    And the field with xpath "(//input[@class='answer_input'])[1]" matches value "Paris - Edited"
    And the field with xpath "(//input[@class='answer_input'])[2]" matches value "Champagne - Edited"
    And the field with xpath "(//input[@class='answer_input'])[3]" matches value "Nice - Edited"

  Scenario: Edit question in a livequiz adding additional answers
    # Enter editing menu by clicking icon
    And I click on "(//li[.//span[text()='Question 1']])[1]//button[contains(@class, 'edit-question-btn')]" "xpath_element"
    # Check if fields are filled with correct values from demo data
    And the field with xpath "(//input[@class='answer_input'])[1]" matches value "Paris"
    And the field with xpath "(//input[@class='answer_checkbox'])[1]" matches value "checked"
    And the field with xpath "(//input[@class='answer_input'])[2]" matches value "Champagne"
    # The checkbox should not be checked, hence empty
    And the field with xpath "(//input[@class='answer_checkbox'])[2]" matches value ""
    And the field with xpath "(//input[@class='answer_input'])[3]" matches value "Nice"
    And the field with xpath "(//input[@class='answer_checkbox'])[3]" matches value "checked"
    # Edit the question
    And I click on "Add Answer" "button"
    And the field with xpath "(//input[@class='answer_input'])[4]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[4]" to "Marseille"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[4]" to "checked"
    And the field with xpath "(//input[@class='answer_checkbox'])[4]" matches value "checked"
    # Close editing menu and save changes
    And "Save Question" "button" should exist
    And I click on "Save Question" "button"
    # Check if changes remain in editing menu
    And I click on "(//li[.//span[text()='Question 1']])[1]//button[contains(@class, 'edit-question-btn')]" "xpath_element"
    And the field with xpath "(//input[@class='answer_input'])[1]" matches value "Paris"
    And the field with xpath "(//input[@class='answer_checkbox'])[1]" matches value "checked"
    And the field with xpath "(//input[@class='answer_input'])[2]" matches value "Champagne"
    And the field with xpath "(//input[@class='answer_checkbox'])[2]" matches value ""
    And the field with xpath "(//input[@class='answer_input'])[3]" matches value "Nice"
    And the field with xpath "(//input[@class='answer_checkbox'])[3]" matches value "checked"
    And the field with xpath "(//input[@class='answer_input'])[4]" matches value "Marseille"
    And the field with xpath "(//input[@class='answer_checkbox'])[3]" matches value "checked"

  Scenario: Edit question in a livequiz for take quiz
    And I click on "//span[@class='question_list_text' and text()='Question 1'][1]" "xpath_element"
    Then I set the field "question_title_id" to "Question 1 - Edited"
    And I set the field "question_description_id" to "Which of the following cities is in France? - Edited"
    And I set the field "question_explanation_id" to "Paris is a city in France, Nice is a city in France - Edited"
    # Use Xpath since the fields are dynamically generated
    And I set the field with xpath "(//input[@class='answer_input'])[1]" to "Paris - Edited"
    And I set the field with xpath "(//input[@class='answer_input'])[2]" to "Champagne - Edited"
    And I set the field with xpath "(//input[@class='answer_input'])[3]" to "Nice - Edited"
    # Close editing menu
    And I click on "Save Question" "button"
    # Check if title was changed in list
    And "Question 1 - Edited" "list_item" should exist
    And "Question 2" "list_item" should exist
    And "Question 3" "list_item" should exist
    And I click on "Take Quiz" "link"
    And I should see "Question 1 - Edited"
    And I should see "Which of the following cities is in France? - Edited"
    And I should see "Paris - Edited"
    And I should see "Champagne - Edited"
    And I should see "Nice - Edited"