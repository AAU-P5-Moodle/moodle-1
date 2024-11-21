@mod @mod_livequiz @javascript

Feature: View livequiz activity
  as a student

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
    # And I use demodata for the course "TC" and activity "livequiz"
    And I log in as "teacher1"
    And I am on "Test Course" course homepage with editing mode on

  Scenario: Add questions to a livequiz
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    Then I should see "Quiz editor page"
    And "Add Question" "button" should exist
    And I should see "Saved Questions"
    And "Which of the following cities is in France?" "list_item" should exist
    And "What is the Capital of Denmark?" "list_item" should exist
    And "Is Hamburg in Germany" "list_item" should exist
    And I click on "Add Question" "button"
    Then "Enter question" "field" should exist
    And "Add Answer" "button" should exist
    And "Save Question" "button" should exist
    And "Discard" "button" should exist
    Then I set the field "Enter question" to "What is the Capital of Sweden?"
    Then I click on "Add Answer" "button"
    And "Enter answer 1" "field" should exist
    Then the checkbox with id "answer_checkbox_1" should exist
    And I set the field "Enter answer 1" to "Stockholm"
    And I click on "answer_checkbox_1" "checkbox"
    Then I click on "Add Answer" "button"
    And "Enter answer 2" "field" should exist
    Then the checkbox with id "answer_checkbox_2" should exist
    And I set the field "Enter answer 2" to "Malmö"
    And I click on "Save Question" "button"
    # This should be done automatically, so next step should be deleted
    And I reload the page
    Then "What is the Capital of Sweden?" "list_item" should exist

  Scenario: Discard questions for livequiz
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    Then I should see "Quiz editor page"
    And "Add Question" "button" should exist
    And I should see "Saved Questions"
    And "Which of the following cities is in France?" "list_item" should exist
    And "What is the Capital of Denmark?" "list_item" should exist
    And "Is Hamburg in Germany" "list_item" should exist
    And I click on "Add Question" "button"
    Then "Enter question" "field" should exist
    And "Add Answer" "button" should exist
    And "Save Question" "button" should exist
    And "Discard" "button" should exist
    # Next step should be deleted when css is fixed
    And I click on "Close block drawer" "button"
    Then I set the field "Enter question" to "What is the Capital of Sweden?"
    And I click on "Discard" "button"
    Then I should see "Are you sure you want to discard changes?"
    And "No" "button" should exist
    And "Yes" "button" should exist
    And I click on "No" "button"
    Then the field "Enter question" matches value "What is the Capital of Sweden?"
    And I click on "Discard" "button"
    And I click on "Yes" "button"
    # This should be done automatically, so next step should be deleted
    And I reload the page
    Then "Which of the following cities is in France?" "list_item" should exist
    And "What is the Capital of Denmark?" "list_item" should exist
    And "Is Hamburg in Germany" "list_item" should exist
    And "What is the Capital of Sweden?" "list_item" should not exist