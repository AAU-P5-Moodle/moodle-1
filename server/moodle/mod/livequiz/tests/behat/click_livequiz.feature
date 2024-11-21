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
    # Create a livequiz activity before the test
      | activity | livequiz         |
      | course   | TC               |
      | idnumber | 1                |
      | name     | livequiz_europe_quiz  |
      | intro    | Test description |
      | section  | 0                |
    And I log in as "teacher1"
    And I am on "Test Course" course homepage with editing mode off

Scenario: Open a livequiz on course
  #Testing we can open the livequiz activity
  When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
  And I should see "Live Quiz"
  And I should see "livequiz_europe_quiz"
  And I should see "Test description"
  And I should see "Quiz editor page"

  Scenario: Delete livequiz
  #Testing we can delete the livequiz activity
  Given I am on "Test Course" course homepage with editing mode on
  When I click on "action-menu-toggle-2" "link" in the "livequiz" activity
  #action-menu-toggle-2 is used because behat cannot find the correct action menu toggle
  Then I should see "Edit settings"
  And I should see "Move"
  And I should see "Move right"
  And I should see "Hide"
  And I should see "Assign roles"
  And I should see "Delete"
  #We should see the default action menu options
  And I click on "Delete" "link"
  And I should see "Delete activity?"
  And I should see "This will delete livequiz_europe_quiz and any user data it contains."
  And "Delete" "button" should exist
  And "Cancel" "button" should exist
  #We should see the delete confirmation page
  And I should see "Delete"
  #We use a class selector here since behat cannot find the correct delete button with: I press
  And I click on "Delete" "button" in the "[class=modal-content]" "css_element"
  And I should not see "livequiz"
