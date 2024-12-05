@mod @mod_livequiz @javascript

Feature: View livequiz activity
  as a student and show participations

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
    And I use demodata for the course "TC" and activity "livequiz"
    And I log in as "student1"
    And I am on "Test Course" course homepage with editing mode off

  Scenario: Show a participations of a livequiz
    #Testing that participations for a livequiz can be shown and that the results of that participation can be shown
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    And I should see "Take Quiz"
    And I click on "Take Quiz" "link"
    And I should see "Which of the following cities is in France?"
    And "Paris" "checkbox" should exist
    And I click on "Paris" "checkbox"
    And "Next Question" "link" should exist
    And I click on "Next Question" "link"
    And "Copenhagen" "radio" should exist
    And I click on "Copenhagen" "radio"
    And "Next Question" "link" should exist
    And I click on "Next Question" "link"
    And "Yes" "radio" should exist
    And I click on "Yes" "radio"
    And "Submit Quiz" "button" should exist
    And I click on "Submit Quiz" "button" confirming the dialogue
    Then I should see "Results for attempt"
    Then I should see "Which of the following cities is in France?"
    Then the "Paris" answer should be checked
    Then the "Copenhagen" answer should be checked
    Then the "Yes" answer should be checked
    And "Back to Live Quiz menu" "link" should exist
    And I click on "Back to Live Quiz menu" "link"
    Then "Go to participation 1" "button" should exist
    #Making another participation to test multiple can be shown
    And I should see "Take Quiz"
    And I click on "Take Quiz" "link"
    And I should see "Which of the following cities is in France?"
    And "Paris" "checkbox" should exist
    Then the "Paris" answer should not be checked
    And "Nice" "checkbox" should exist
    And I click on "Nice" "checkbox"
    And "Next Question" "link" should exist
    And I click on "Next Question" "link"
    And "Aalborg" "radio" should exist
    And "Copenhagen" "radio" should exist
    Then the "Copenhagen" answer should not be checked
    And I click on "Aalborg" "radio"
    And "Next Question" "link" should exist
    And I click on "Next Question" "link"
    And "No" "radio" should exist
    And "Yes" "radio" should exist
    Then the "Yes" answer should not be checked
    And I click on "No" "radio"
    And "Submit Quiz" "button" should exist
    And I click on "Submit Quiz" "button" confirming the dialogue
    Then I should see "Results for attempt"
    And "Back to Live Quiz menu" "link" should exist
    And I click on "Back to Live Quiz menu" "link"
    Then "Go to participation 1" "button" should exist
    And "Go to participation 2" "button" should exist
    And I press "Go to participation 1"
    Then I should see "Which of the following cities is in France?"
    Then the "Nice" answer should be checked
    Then the "Aalborg" answer should be checked
    Then the "No" answer should be checked
    And "Back to Live Quiz menu" "link" should exist
    And I click on "Back to Live Quiz menu" "link"
    Then "Go to participation 1" "button" should exist
    And "Go to participation 2" "button" should exist
