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
    And I am on "Test Course" course homepage with editing mode off

Scenario: Open a livequiz on course
  When I click on "livequiz_tester" "link" in the "livequiz" activity
  And I should see "Live Quiz"
  And I should see "this is the livequiz view page"
  And I should see "Test description"

Scenario: Delete livequiz
  Given I am on "Test Course" course homepage with editing mode on
  When I click on "action-menu-toggle-2" "link" in the "livequiz" activity
  And I should see "Edit settings"
  And I should see "Move"
  And I should see "Move right"
  And I should see "Hide"
  And I should see "Assign roles"
  And I should see "Delete"
  And I click on "Delete" "link"
  And I wait until the page is ready
  And I should see "Delete activity?"
  #And I should see "This will delete livequiz and any user data it contains."
  And I click on "Delete" "link"
  And I wait "1" seconds
  Then I should not see "Live Quiz"
