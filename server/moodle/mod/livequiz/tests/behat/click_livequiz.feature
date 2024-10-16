@mod @mod_livequiz @javascript

Feature: Open a LiveQuiz activity
  In order to let students see a livequiz
  As a teacher
  I need to add a livequiz activity to a course

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
      | activity | livequiz         |
      | course   | TC               |
      | idnumber | 1                |
      | name     | livequiz_tester  |
      | intro    | Test description |
      | section  | 0                |
    And I log in as "teacher1"
    And I am on "Test Course" course homepage with editing mode on

Scenario: Open a livequiz on course
  When I click on "livequiz_tester" "link" in the "livequiz" activity
  And I should see "Live Quiz"
  And I wait "5" seconds
