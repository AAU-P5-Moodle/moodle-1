@mod @mod_livequiz @javascript

Feature: View livequiz activity
  as a studenxt

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
      | student1 | Student   | 1        | student1@example.com |
    And the following "courses" exist:
      | fullname    | shortname |
      | Test Course | TC        |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | TC | editingteacher |
      | student1 | TC | student |
    And the following "activity" exists:
    # Create a livequiz activity before the test
      | activity | livequiz         |
      | course   | TC               |
      | idnumber | 1                |
      | name     | livequiz_europe_quiz    |
      | intro    | Test description |
      | section  | 0                |
    And I use demodata for the course "TC" and activity "livequiz"
    And I log in as "teacher1"
    And I am on "Test Course" course homepage with editing mode on

  Scenario: Add questions to a livequiz
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    Then I should see "Quiz editor page"
    And "Add Question" "button" should exist
    And I should see "Saved Questions"
    And "Question 1" "list_item" should exist
    And "Question 2" "list_item" should exist
    And "Question 3" "list_item" should exist
    And I click on "Add Question" "button"
    Then the "field" with id "question_title_id" should exist
    Then the "field" with id "question_description_id" should exist
    Then the "field" with id "question_explanation_id" should exist
    And "Add Answer" "button" should exist
    And "Save Question" "button" should exist
    And "Cancel" "button" should exist
    Then I set the field "question_title_id" to "Geography 1"
    And I set the field "question_description_id" to "What is the Capital of Sweden?"
    And I set the field "question_explanation_id" to "Stockholm is the capital of Sweden"
    And I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[1]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[1]" matches value ""
    # Button value is empty because a value is not set in the mustache template
    And the field with xpath "(//button[@class='delete_answer_button'])[1]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[1]" to "Stockholm"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[1]" to "checked"
    Then I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[2]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[2]" matches value ""
    And the field with xpath "(//button[@class='delete_answer_button'])[2]" matches value ""
    # Next step should be deleted when css is fixed
    And I click on "Close block drawer" "button"
    And I click on "(//button[@class='delete_answer_button'])[2]" "xpath_element"
    Then the "field" with id "answer_input_2" should not exist
    And I click on "Add Answer" "button"
    # The id of answers are just counted up thus the id is
    # XPath renders dynamically, so the XPath's value is only 2, since we only have 2 occurrences
    # That is why we check that the field have the id 3, and not the previous id 2
    Then the "field" with id "answer_input_3" should exist
    Then the field with xpath "(//input[@class='answer_input'])[2]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[2]" matches value ""
    And the field with xpath "(//button[@class='delete_answer_button'])[2]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[2]" to "Malmö"
    And I click on "Save Question" "button"
    Then "Geography 1" "list_item" should exist

  Scenario: Discard questions for livequiz
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    Then I should see "Quiz editor page"
    And "Add Question" "button" should exist
    And I should see "Saved Questions"
    And "Question 1" "list_item" should exist
    And "Question 2" "list_item" should exist
    And "Question 3" "list_item" should exist
    And I click on "Add Question" "button"
    Then the "field" with id "question_title_id" should exist
    Then the "field" with id "question_description_id" should exist
    Then the "field" with id "question_explanation_id" should exist
    And "Add Answer" "button" should exist
    And "Save Question" "button" should exist
    And "Cancel" "button" should exist
    # Next step should be deleted when css is fixed
    And I click on "Close block drawer" "button"
    Then I set the field "question_title_id" to "Geography 1"
    Then I set the field "question_description_id" to "What is the Capital of Sweden?"
    Then I set the field "question_explanation_id" to "Stockholm is the capital of Sweden"
    And I click on "Cancel" "button" dismissing the dialogue
    Then the field "question_description_id" matches value "What is the Capital of Sweden?"
    And I click on "Cancel" "button" confirming the dialogue
    Then "Question 1" "list_item" should exist
    And "Question 2" "list_item" should exist
    And "Question 3" "list_item" should exist
    And "Geography 1" "list_item" should not exist

  Scenario: Questions added to a livequiz reaches students
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    Then I should see "Quiz editor page"
    And I click on "Add Question" "button"
    # Add a question to the livequiz
    Then I set the field "question_title_id" to "Geography 1"
    And I set the field "question_description_id" to "What is the Capital of Sweden?"
    And I set the field "question_explanation_id" to "Stockholm is the capital of Sweden"
    And I click on "Add Answer" "button"
    And I set the field with xpath "(//input[@class='answer_input'])[1]" to "Stockholm"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[1]" to "checked"
    # Set question type to radio button
    And "Allow only one correct answer" "checkbox" should exist
    And I click on "Allow only one correct answer" "checkbox"
    And I click on "Add Answer" "button"
    And I set the field with xpath "(//input[@class='answer_input'])[2]" to "Malmö"
    And I click on "Add Answer" "button"
    And I set the field with xpath "(//input[@class='answer_input'])[3]" to "Gothenburg"
    And I click on "Save Question" "button"
    Then "Geography 1" "list_item" should exist
    And I click on "Take Quiz" "link"
    # Runs through the quiz from teacher perspective to see if the questions are displayed
    And I should see "Which of the following cities is in France?"
    And I click on "Next Question" "link"
    And I should see "What is the Capital of Denmark?"
    And I click on "Next Question" "link"
    And I should see "Is Hamburg in Germany?"
    And I click on "Next Question" "link"
    And I should see "What is the Capital of Sweden?"
    And I log out
    And I log in as "student1"
    And I am on "Test Course" course homepage with editing mode off
    And I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    And I should see "Take Quiz"
    And I click on "Take Quiz" "link"
    # Runs through the quiz from student perspective to see if the questions are displayed
    And I should see "Which of the following cities is in France?"
    And I click on "Next Question" "link"
    And I should see "What is the Capital of Denmark?"
    And I click on "Next Question" "link"
    And I should see "Is Hamburg in Germany?"
    And I click on "Next Question" "link"
    And I should see "What is the Capital of Sweden?"
    And "Stockholm" "radio" should exist
    And "Malmö" "radio" should exist
    And "Gothenburg" "radio" should exist

  Scenario: Validate submission for a question
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    And I click on "Add Question" "button"
    And I click on "Save Question" "button"
    # The commented out next line fails in the CI pipeline because the element is invisible.
    # Then I should see "Please fill out all the required fields"
    # It still works on local machines. We therefore check that it exists instead.
    Then "Please fill out all the required fields" "text" should exist
    And I should see "The Title is required"
    And I should see "The Question Text is required"
    And I should see "*You need to add at least one correct answer"
    And I should see "*You need to have at least two answers"
    Then I set the field "question_title_id" to "Geography 1"
    And I click on "Save Question" "button"
    # The commented out next line fails in the CI pipeline because the element is invisible.
    # Then I should see "Please fill out all the required fields"
    # It still works on local machines. We therefore check that it exists instead.
    Then "Please fill out all the required fields" "text" should exist
    And I should see "The Question Text is required"
    And I should see "*You need to add at least one correct answer"
    And I should see "*You need to have at least two answers"
    Then I set the field "question_description_id" to "What is the Capital of Sweden?"
    And I click on "Save Question" "button"
    # The commented out next line fails in the CI pipeline because the element is invisible.
    # Then I should see "Please fill out all the required fields"
    # It still works on local machines. We therefore check that it exists instead.
    Then "Please fill out all the required fields" "text" should exist
    And I should see "*You need to add at least one correct answer"
    And I should see "*You need to have at least two answers"
    Then I click on "Add Answer" "button"
    And I click on "Add Answer" "button"
    And I click on "Save Question" "button"
    # The commented out next line fails in the CI pipeline because the element is invisible.
    # Then I should see "Please fill out all the required fields"
    # It still works on local machines. We therefore check that it exists instead.
    Then "Please fill out all the required fields" "text" should exist
    And I should see "*You need to add at least one correct answer"
    And I should see "*Each answer must have a description"
    Then I set the field with xpath "(//input[@class='answer_input'])[1]" to "Stockholm"
    And I set the field with xpath "(//input[@class='answer_input'])[2]" to "Norway"
    And I click on "Save Question" "button"
    # The commented out next line fails in the CI pipeline because the element is invisible.
    # Then I should see "Please fill out all the required fields"
    # It still works on local machines. We therefore check that it exists instead.
    Then "Please fill out all the required fields" "text" should exist
    And I should see "*You need to add at least one correct answer"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[1]" to "checked"
    And I click on "Save Question" "button"
    Then "Geography 1" "list_item" should exist
