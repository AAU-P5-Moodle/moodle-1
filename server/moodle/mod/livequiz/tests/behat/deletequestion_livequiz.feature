@mod @mod_livequiz @javascript

Feature: Delete questions in a livequiz activity
  as a teacher

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

  Scenario: Accept confirm to delete questions in a livequiz
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    Then I should see "Quiz editor page"
    And "Add Question" "button" should exist
    And I should see "Saved Questions"
    And "Question 1" "list_item" should exist
    And "Question 2" "list_item" should exist
    And "Question 3" "list_item" should exist
    And "//li[//span[//@class='question_list_text' and text()='Question 1']]//button[contains(@class, 'delete-question')]" "xpath_element" should exist
    And "//li[//span[//@class='question_list_text' and text()='Question 2']]//button[contains(@class, 'delete-question')]" "xpath_element" should exist
    And "//li[//span[//@class='question_list_text' and text()='Question 3']]//button[contains(@class, 'delete-question')]" "xpath_element" should exist
    # Click on the delete btn for the first appearance of a span element with the title "Question 1"
    # The confirm popup is not shown on screen but this step confirm it
    When I click on "(//li[.//span[text()='Question 1']])[1]//button[contains(@class, 'delete-question')]" "xpath_element" confirming the dialogue
    Then "Question 1" "list_item" should not exist
    And "Question 2" "list_item" should exist
    And "Question 3" "list_item" should exist
    And I click on "Take Quiz" "link"
    # Checks that the new first question is "Question 2"
    And I should see "Question 2"
    And I should see "What is the Capital of Denmark?"
    And "Aarhus" "radio" should exist
    And "Aalborg" "radio" should exist
    And "Copenhagen" "radio" should exist


  Scenario: Cancel confirm to delete questions in a livequiz
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    Then I should see "Quiz editor page"
    And "Add Question" "button" should exist
    And I should see "Saved Questions"
    And "Question 1" "list_item" should exist
    And "Question 2" "list_item" should exist
    And "Question 3" "list_item" should exist
    And "//li[//span[//@class='question_list_text' and text()='Question 1']]//button[contains(@class, 'delete-question')]" "xpath_element" should exist
    And "//li[//span[//@class='question_list_text' and text()='Question 2']]//button[contains(@class, 'delete-question')]" "xpath_element" should exist
    And "//li[//span[//@class='question_list_text' and text()='Question 3']]//button[contains(@class, 'delete-question')]" "xpath_element" should exist
    # Click on the delete btn for the first appearance of a span element with the title "Question 1"
    # The confirm popup is not shown on screen but this step cancel it
    When I click on "(//li[.//span[text()='Question 1']])[1]//button[contains(@class, 'delete-question')]" "xpath_element" dismissing the dialogue
    Then "Question 1" "list_item" should exist
    And "Question 2" "list_item" should exist
    And "Question 3" "list_item" should exist
    And I click on "Take Quiz" "link"
    # Checks that the new first question is "Question 2"
    And I should see "Question 1"
    And I should see "Which of the following cities is in France?"
    And "Paris" "checkbox" should exist
    And "Champagne" "checkbox" should exist
    And "Nice" "checkbox" should exist

  Scenario: Delete the last question in a livequiz
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    Then I should see "Quiz editor page"
    And "Add Question" "button" should exist
    And I should see "Saved Questions"
    And "Question 1" "list_item" should exist
    And "Question 2" "list_item" should exist
    And "Question 3" "list_item" should exist
    And "Take Quiz" "link" should exist
    And "//li[//span[//@class='question_list_text' and text()='Question 1']]//button[contains(@class, 'delete-question')]" "xpath_element" should exist
    And "//li[//span[//@class='question_list_text' and text()='Question 2']]//button[contains(@class, 'delete-question')]" "xpath_element" should exist
    And "//li[//span[//@class='question_list_text' and text()='Question 3']]//button[contains(@class, 'delete-question')]" "xpath_element" should exist
    When I click on "(//li[.//span[text()='Question 1']])[1]//button[contains(@class, 'delete-question')]" "xpath_element" confirming the dialogue
    When I click on "(//li[.//span[text()='Question 2']])[1]//button[contains(@class, 'delete-question')]" "xpath_element" confirming the dialogue
    When I click on "(//li[.//span[text()='Question 3']])[1]//button[contains(@class, 'delete-question')]" "xpath_element" confirming the dialogue
    Then "Question 1" "list_item" should not exist
    And "Question 2" "list_item" should not exist
    And "Question 3" "list_item" should not exist
    And "Take Quiz" "link" should not exist
    And I should see "There are no questions present in this quiz"

  Scenario: Delete question is deleted from students quiz
    # Checks if the teacher have deleted a question from a quiz, the students quiz is also updated
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    Then "Question 1" "list_item" should exist
    And "Question 2" "list_item" should exist
    And "Question 3" "list_item" should exist
    And I click on "(//li[.//span[text()='Question 1']])[1]//button[contains(@class, 'delete-question')]" "xpath_element" confirming the dialogue
    And I log out
    And I log in as "student1"
    And I am on "Test Course" course homepage with editing mode off
    And I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    And I should see "Take Quiz"
    And I click on "Take Quiz" "link"
    # Checks the first question is "Question 2"
    And I should see "What is the Capital of Denmark?"
    And "Aarhus" "radio" should exist
    And "Aalborg" "radio" should exist
    And "Copenhagen" "radio" should exist
    And I should not see "Question 1"
    And I should not see "Which of the following cities is in France?"
    And "Paris" "checkbox" should not exist
    And "Champagne" "checkbox" should not exist
    And "Nice" "checkbox" should not exist

  Scenario: Delete question with participation
    # Checks that deleting a question with a participation causes an alert to appear.
    And I log out
    And I log in as "student1"
    And I am on "Test Course" course homepage with editing mode off
    And I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    And I should see "Take Quiz"
    And I click on "Take Quiz" "link"
    # Answers "Question 1"
    And I should see "Question 1"
    And I should see "Which of the following cities is in France?"
    And "Paris" "checkbox" should exist
    And "Champagne" "checkbox" should exist
    And "Nice" "checkbox" should exist
    And I click on "Paris" "checkbox"
    And "Submit Quiz" "button" should exist
    And I click on "Submit Quiz" "button" confirming the dialogue
    Then I should see "Results for attempt"
    #Log in as lecturer and attempt to delete "Question 1""
    Then I log out
    And I log in as "teacher1"
    And I am on "Test Course" course homepage with editing mode on
    And I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    Then "Question 1" "list_item" should exist
    And "Question 2" "list_item" should exist
    And "Question 3" "list_item" should exist
    Then I enable automatic dismissal of alerts
    When I click on "(//li[.//span[text()='Question 1']])[1]//button[contains(@class, 'delete-question')]" "xpath_element" confirming the dialogue
    # An alert appears here stating that the question cannot be deleted. Due to "Then I enable automatic dismissal of alerts" above, the alert is dismissed.
    Then "Question 1" "list_item" should exist
    And "Question 2" "list_item" should exist
    And "Question 3" "list_item" should exist










