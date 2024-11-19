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
    And I log in as "student1"
    And I am on "Test Course" course homepage with editing mode off

  Scenario: Show a participations of a livequiz
    #Testing taht participations for a livequiz can be shown and that the results of that participation can be shown
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    And I should see "Take Quiz"
    And I click on "Take Quiz" "link"
    And I should see "This is about France"
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
    And I click on "Submit Quiz" "button"
    Then I should see "You have successfully submitted the quiz"
    And "Back to quiz menu" "link" should exist
    And I click on "Back to quiz menu" "link"
    Then "Participation 1" "link" should exist
    #Making another participation to test multiple can be shown
    And I should see "Take Quiz"
    And I click on "Take Quiz" "link"
    And I should see "This is about France"
    And "Nice" "checkbox" should exist
    And I click on "Nice" "checkbox"
    And "Next Question" "link" should exist
    And I click on "Next Question" "link"
    And "Aalborg" "radio" should exist
    And I click on "Aalborg" "radio"
    And "Next Question" "link" should exist
    And I click on "Next Question" "link"
    And "No" "radio" should exist
    And I click on "No" "radio"
    And "Submit Quiz" "button" should exist
    And I click on "Submit Quiz" "button"
    Then I should see "You have successfully submitted the quiz"
    And "Back to quiz menu" "link" should exist
    And I click on "Back to quiz menu" "link"
    Then "Participation 1" "link" should exist
    And "Participation 2" "link" should exist
    And I click on "Participation 1" "link"
    Then I should see "This is about France"
    Then the "Nice" answer should be checked
    Then the "Aalborg" answer should be checked
    Then the "No" answer should be checked
    And "Back to quiz menu" "link" should exist
    And I click on "Back to quiz menu" "link"
    Then "Participation 1" "link" should exist
    And "Participation 2" "link" should exist
