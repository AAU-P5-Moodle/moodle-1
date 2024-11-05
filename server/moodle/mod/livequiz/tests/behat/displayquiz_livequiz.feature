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
      | name     | livequiz_tester  |
      | intro    | Test description |
      | section  | 0                |
    And I log in as "student1"
    And I am on "Test Course" course homepage with editing mode off

    Scenario: Open a livequiz on course with questions
        #Testing we can open the livequiz activity
        When I click on "livequiz_tester" "link" in the "livequiz" activity
        And I should see "THIS IS THE INDEXPAGE OF livequiz_tester"
        And I should see "Take Quiz"
        And I click on "Take Quiz" "link"
        And I should see "Quiz 1 Question 1"
        And I should see "This is the first quiz question"
        And "Answer 1" "checkbox" should exist
        And "Answer 2" "checkbox" should exist
        And "Answer 3" "checkbox" should exist
        And "Next Question" "link" should exist
        And I click on "Next Question" "link"
        Then I should see "Quiz 1 Question 2"
        And I should see "This is the second quiz question"
        And "Answer 1" "radio" should exist
        And "Answer 2" "radio" should exist
        And "Answer 3" "radio" should exist
        And "Next Question" "link" should exist
        And I click on "Next Question" "link"
        Then I should see "Quiz 1 Question 3"
        And I should see "This is the second quiz question"
        And "True" "radio" should exist
        And "False" "radio" should exist
        And "Previous Question" "link" should exist
        And I click on "Previous Question" "link"
        And I wait "3" seconds
        Then I should see "Quiz 1 Question 2"
        And I should see "This is the second quiz question"
