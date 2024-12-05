@mod @mod_livequiz @javascript
Feature: Delete teacher participation
  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
    And the following "courses" exist:
      | fullname    | shortname |
      | Test Course | TC        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | TC     | editingteacher |
    And the following "activity" exists:
      # Create a livequiz activity before the test
      | activity | livequiz             |
      | course   | TC                   |
      | idnumber | 1                    |
      | name     | livequiz_europe_quiz |
      | intro    | Test description     |
      | section  | 0                    |
    And I use demodata for the course "TC" and activity "livequiz"
    And I log in as "teacher1"
    And I am on "Test Course" course homepage with editing mode on

  Scenario: Delete teacher participations
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    Then I should see "Quiz editor page"
    And "Question 1" "list_item" should exist
    And I should see "Take Quiz"
    And I click on "Take Quiz" "link"
    And "Submit Quiz" "button" should exist
    And I click on "Paris" "checkbox"
    And I click on "Submit Quiz" "button" confirming the dialogue
    And I should see "Results for attempt"
    And I should see "Back to Live Quiz menu"
    And I click on "Back to Live Quiz menu" "link"
    And I should see "Quiz editor page"
    And I click on "//span[@class='question_list_text' and text()='Question 1'][1]" "xpath_element"
    # Check if fields are filled with correct values from demo data
    And the field "question_title_id" matches value "Question 1"
    # Edit the question title
    Then I set the field "question_title_id" to "Question 1 - Edited"
    # Close editing menu
    And "Save Question" "button" should exist
    And I click on "Save Question" "button"
    # Check if title was changed in list
    And "Question 1 - Edited" "list_item" should exist
    # Check if the question can be delete
    When I click on "(//li[.//span[text()='Question 1 - Edited']])[1]//button[contains(@class, 'delete-question')]" "xpath_element" confirming the dialogue
    Then "Question 1 - Edited" "list_item" should not exist
