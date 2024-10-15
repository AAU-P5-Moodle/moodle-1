@mod @mod_livequiz @javascript

Feature: Add LiveQuiz activity
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
    And I log in as "teacher1"
    And I am on "Test Course" course homepage with editing mode on


Scenario: Add a livequiz to a course
  Then I wait until the page is ready
  And I should see "Add an activity or resource"
  And I press "Add an activity or resource"
  And I should see "Live Quiz"
  And I click on "Live Quiz" "link"
  And I should see "New Live Quiz"
  And I press "Save and return to course"
  And I wait "5" seconds
  And I should see "livequiz"
  When I click on "livequiz" "link" in the "livequiz" activity
  Then I should see "livequiz"


