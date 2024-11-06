@mod @mod_livequiz @javascript

Feature: View livequiz activity
  as a student

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email             |
      | student1 | stu       | dent     | student1@mail.com |
    And the following "courses" exist:
      | fullname    | shortname |
      | Test Course | TC        |
    And the following "course enrolments" exist:
      | user | course | role |
      | student1 | TC | student |
    And the following "activity" exists:
    # Create a livequiz activity before the test
      | activity | livequiz         |
      | course   | TC               |
      | idnumber | 1                |
      | name     | livequiz_europe_quiz    |
      | intro    | Test description |
      | section  | 0                |
    And I log in as "student1"
    And I am on "Test Course" course homepage with editing mode off

  Scenario: Show a livequiz with questions
    #Testing we can open the livequiz activity
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    And I should see "THIS IS THE INDEXPAGE OF livequiz_europe_quiz"
    And I should see "Take Quiz"
    And I click on "Take Quiz" "link"
    And I should see "Which of the following cities is in France?"
    And I should see "This is about France"
    And "Paris" "checkbox" should exist
    And "Champagne" "checkbox" should exist
    And "Nice" "checkbox" should exist
    And "Next Question" "link" should exist
    And I click on "Next Question" "link"
    Then I should see "What is the Capital of Denmark?"
    And I should see "This is about Denmark"
    And "Aarhus" "radio" should exist
    And "Aalborg" "radio" should exist
    And "Copenhagen" "radio" should exist
    And "Next Question" "link" should exist
    And I click on "Next Question" "link"
    Then I should see "Is Hamburg in Germany?"
    And I should see "German cities"
    And "Yes" "radio" should exist
    And "No" "radio" should exist
    And "Previous Question" "link" should exist
    And I click on "Previous Question" "link"
    Then I should see "What is the Capital of Denmark?"
    And I should see "This is about Denmark"
    And "Aarhus" "radio" should exist
    And "Aalborg" "radio" should exist
    And "Copenhagen" "radio" should exist
    And I press the "back" button in the browser

  Scenario: Submit a livequiz
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    And I click on "Take Quiz" "link"
    And "Submit Quiz" "button" should exist
    And I click on "Paris" "checkbox"
    And I click on "Submit Quiz" "button"
    And I should see "Results for attempt"
    And "Paris" "checkbox" should exist
    And "Champagne" "checkbox" should exist
    And "Nice" "checkbox" should exist
    And "Aarhus" "radio" should exist
    And "Aalborg" "radio" should exist
    And "Copenhagen" "radio" should exist
    And "Yes" "radio" should exist
    And "No" "radio" should exist
    And I press the "back" button in the browser
    Then I should see "You are not allowed to go back after submitting the quiz"