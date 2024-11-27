@mod @mod_livequiz @javascript

Feature: Reuse previously created quiz in livequiz activity

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
    And the following "courses" exist:
      | fullname    | shortname |
      | Test Course | TC        |
      | Test Course 2 | TC2        |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | TC | editingteacher |
      | teacher1 | TC2 | editingteacher |
    And the following "activity" exists:
    # Create a livequiz activity before the test
      | activity | livequiz         |
      | course   | TC               |
      | idnumber | 1               |
      | name     | livequiz_europe_quiz |
      | intro    | Test description |
      | section  | 0                |
    And the following "activity" exists:
    # Create a livequiz activity before the test
      | activity | livequiz         |
      | course   | TC2              |
      | idnumber | 2                |
      | name     | livequiz_africa_quiz    |
      | intro    | Test description |
      | section  | 0                |
    And I use demodata "1" for the course "TC" and activity "livequiz" and lecturer "teacher1"
    And I use demodata "2" for the course "TC2" and activity "livequiz" and lecturer "teacher1"
    And I log in as "teacher1"
    And I am on "Test Course" course homepage with editing mode on

    Scenario: Reuse quiz in livequiz
       