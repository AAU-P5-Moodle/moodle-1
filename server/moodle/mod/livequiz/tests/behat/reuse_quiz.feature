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
      When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
      Then I should see "Quiz editor page"
      And I should see "Import Question"
      And I click on "Import Question" "button"
      And I should see "livequiz_africa_quiz"
      And I should see "African cities: Question 1"
      And I should see "African cities: Question 2"
      And I should see "African cities: Question 3"
      And I click on "livequiz_africa_quiz" "checkbox"
      And the field "livequiz_africa_quiz" matches value "selected"
      And the field "African cities: Question 1" matches value "selected"
      And the field "African cities: Question 2" matches value "selected"
      And the field "African cities: Question 3" matches value "selected"
      And I click on "Import Question(s)" "button"
      And "African cities: Question 1" "list_item" should exist
      And "African cities: Question 2" "list_item" should exist
      And "African cities: Question 3" "list_item" should exist

    Scenario: Not selecting any questions in the import pop-up
      #Testing that we can get an alert and does not close import pop-up if not questions are selected for import.
      When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
      Then I should see "Quiz editor page"
      And I should see "Import Question"
      And I click on "Import Question" "button"
      Then I enable automatic dismissal of alerts
      Then I click on "Import Question(s)" "button" confirming the dialogue
      # The import pop-up should now be visible.
      And I should see "livequiz_africa_quiz"
      And I should see "African cities: Question 1"
      And I should see "African cities: Question 2"
      And I should see "African cities: Question 3"
      And I should see "Import Question(s)"


