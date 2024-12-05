@mod @mod_livequiz @javascript

Feature: Reuse previously created questions in livequiz activity

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
    And the following "courses" exist:
      | fullname      | shortname |
      | Test Course   | TC        |
      | Test Course 2 | TC2       |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | TC     | editingteacher |
      | teacher1 | TC2    | editingteacher |
    And the following "activity" exists:
      # Create a livequiz activity before the test
      | activity | livequiz             |
      | course   | TC                   |
      | idnumber | 1                    |
      | name     | livequiz_europe_quiz |
      | intro    | Test description     |
      | section  | 0                    |
    And the following "activity" exists:
      # Create a livequiz activity before the test
      | activity | livequiz             |
      | course   | TC2                  |
      | idnumber | 2                    |
      | name     | livequiz_africa_quiz |
      | intro    | Test description     |
      | section  | 0                    |
    And I use demodata "1" for the course "TC" and activity "livequiz" and lecturer "teacher1"
    And I use demodata "2" for the course "TC2" and activity "livequiz" and lecturer "teacher1"
    And I log in as "teacher1"
    And I am on "Test Course" course homepage with editing mode on

  Scenario: Deleted questions are filtered
    #action-menu-toggle-2 is used because behat cannot find the correct action menu toggle
    When I click on "action-menu-toggle-2" "link" in the "livequiz" activity
    #We should see the default action menu options
    And I click on "Delete" "link"
    #We use a class selector here since behat cannot find the correct delete button with: I press
    And I click on "Delete" "button" in the "[class=modal-content]" "css_element"
    And I am on "Test Course 2" course homepage with editing mode on
    And I click on "livequiz_africa_quiz" "link" in the "livequiz" activity
    And I should see "Quiz editor page"
    And I click on "Import Question" "button"
    And "livequiz_europe_quiz" "checkbox" should not exist

  Scenario: Unique questions are filtered
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
    And I click on "Add Question" "button"
    Then I set the field "question_title_id" to "test 1"
    Then I set the field "question_description_id" to "question text"
    Then I set the field "question_explanation_id" to "explanation text"
    # Adding answers to the question
    Then I click on "Add Answer" "button"
    And I set the field with xpath "(//input[@class='answer_input'])[1]" to "answer text 1"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[1]" to "checked"
    Then I click on "Add Answer" "button"
    And I set the field with xpath "(//input[@class='answer_input'])[2]" to "answer text 2"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[2]" to ""
    And I click on "Save Question" "button"
    Then I should see "Saved Questions"
    And I am on "Test Course 2" course homepage with editing mode on
    When I click on "livequiz_africa_quiz" "link" in the "livequiz" activity
    And I should see "Quiz editor page"
    Then I click on "Import Question" "button"
    And "livequiz_europe_quiz" "checkbox" should exist
    And "test 1" "checkbox" should exist
    And I click on "livequiz_europe_quiz" "checkbox"
    And I click on "Import Question(s)" "button"
    And I check that element "test 1" occurs only once in the list



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
    # Switching quiz
    And I am on "Test Course 2" course homepage with editing mode on
    When I click on "livequiz_africa_quiz" "link" in the "livequiz" activity
    And I should see "Quiz editor page"
    And "Import Question" "button" should exist
    And I click on "Import Question" "button"
    Then "Import Question(s)" "button" should exist
    And "Cancel" "button" should exist
    And I should see "Previously made Quizzes and Questions"
    And "livequiz_africa_quiz" "checkbox" should not exist
    And "livequiz_europe_quiz" "checkbox" should exist
    And "test 1" "checkbox" should exist
    And I click on "test 1" "checkbox"
    And I click on "Import Question(s)" "button"
    And I should see "Saved Questions"
    And "test 1" "list_item" should exist
    # Clicking on the question to see if the answers are correct
    And I click on "(//li[.//span[text()='test 1']])[1]//button[contains(@class, 'edit-question-btn')]" "xpath_element"
    And the field "question_title_id" matches value "test 1"
    And the field "question_description_id" matches value "question text"
    And the field "question_explanation_id" matches value "explanation text"
    # Accessing the answers to see if they are correct
    And the field with xpath "(//input[@class='answer_input'])[1]" matches value "answer text 1"
    And the field with xpath "(//input[@class='answer_input'])[2]" matches value "answer text 2"
    # Checking if the answers are correctly checked
    And the field with xpath "(//input[@class='answer_checkbox'])[1]" matches value "checked"
    And the field with xpath "(//input[@class='answer_checkbox'])[2]" matches value ""
    # Testing that changes to one question does not affect the same questions from another livequiz
    Then I click on "Add Answer" "button"
    And I set the field with xpath "(//input[@class='answer_input'])[3]" to "answer text 3"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[1]" to ""
    And I set the field with xpath "(//input[@class='answer_checkbox'])[2]" to "checked"
    And I click on "Save Question" "button"
    And I am on "Test Course" course homepage with editing mode on
    Then I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    And I should see "Quiz editor page"
    And I should see "Saved Questions"
    And I click on "(//li[.//span[text()='test 1']])[1]//button[contains(@class, 'edit-question-btn')]" "xpath_element"
    And the field with xpath "(//input[@class='answer_checkbox'])[1]" matches value "checked"
    And the field with xpath "(//input[@class='answer_checkbox'])[2]" matches value ""
    And I should not see "answer text 3"
