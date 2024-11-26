@mod @mod_livequiz @javascript

Feature: Reuse previously created questions in livequiz activity

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

    Scenario: Reuse questions in livequiz
      When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
      Then I should see "Quiz editor page"
      And "Import Question" "button" should exist
      And I click on "Import Question" "button"
      Then "Import Question(s)" "button" should exist
      And "Discard Changes" "button" should exist
      And I should see "previously made questions:"
      And I wait "3" seconds
      And "Question 1" "checkbox" should exist
      And "Question 2" "checkbox" should exist
      And "Question 3" "checkbox" should exist
      And I click on "Question 1" "checkbox"
      And I click on "Import Question(s)" "button"
      Then I should see "Saved Questions"
      And "Question 1" "list_item" should exist
      And "Question 2" "list_item" should exist
      And "Question 3" "list_item" should exist



