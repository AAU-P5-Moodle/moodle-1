@mod @mod_livequiz @javascript

Feature: Reuse previously created questions in livequiz activity

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
      | idnumber | 1                |
      | name     | livequiz_europe_quiz    |
      | intro    | Test description |
      | section  | 0                |
    And the following "activity" exists:
    # Create a livequiz activity before the test
      | activity | livequiz         |
      | course   | TC2               |
      | idnumber | 0                |
      | name     | livequiz_europe_quiz_2    |
      | intro    | Test description |
      | section  | 0                |
    And I log in as "teacher1"
    And I am on "Test Course" course homepage with editing mode on

    Scenario: Reuse questions in livequiz
      # Clicking on the second livequiz activity
      When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
      Then I should see "Quiz editor page"
      And "Import Question" "button" should exist
      # Adding a question to reuse later
      And "Add Question" "button" should exist
      And I click on "Add Question" "button"
      Then I set the field "question_title_id" to "test 1"
      Then I set the field "question_description_id" to "question text"
      Then I set the field "question_explanation_id" to "explanation text"
      # Adding answers to the question
      Then I click on "Add Answer" "button"
      And I set the field "answer_input_1" to "answer text 1"
      And I click on "answer_checkbox_1" "checkbox"
      Then I click on "Add Answer" "button"
      And I set the field "answer_input_2" to "answer text 2"
      And I click on "Save Question" "button"
      Then I should see "Saved Questions"
      And "test 1" "list_item" should exist
      And I am on "Test Course 2" course homepage with editing mode on
      When I click on "livequiz_europe_quiz_2" "link" in the "livequiz" activity
      And I should see "Quiz editor page"
      And "Import Question" "button" should exist
      And I click on "Import Question" "button"
      Then "Import Question(s)" "button" should exist
      And "Discard Changes" "button" should exist
      And I should see "previously made questions:"
      And "test 1" "checkbox" should exist
      And I click on "test 1" "checkbox"
      And I click on "Import Question(s)" "button"
      And I should see "Saved Questions"
      And "test 1" "list_item" should exist
