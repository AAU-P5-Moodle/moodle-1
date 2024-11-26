@mod @mod_livequiz @javascript

Feature: Delete questions in a livequiz activity
  as a teacher

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
    And the following "courses" exist:
      | fullname    | shortname |
      | Test Course | TC        |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | TC | editingteacher |
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
    And "//button[@id='316000-delete-btn']" "xpath_element" should exist
    And "//button[@id='316001-delete-btn']" "xpath_element" should exist
    And "//button[@id='316002-delete-btn']" "xpath_element" should exist
    # See comment in the step definition
    And I confirm the popup
    When I click on "//button[@id='316000-delete-btn']" "xpath_element"
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
    And "//button[@id='316000-delete-btn']" "xpath_element" should exist
    And "//button[@id='316001-delete-btn']" "xpath_element" should exist
    And "//button[@id='316002-delete-btn']" "xpath_element" should exist
    # See comment in the step definition
    When I cancel the popup
    When I click on "//button[@id='316000-delete-btn']" "xpath_element"
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

