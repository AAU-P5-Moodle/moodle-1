@mod @mod_livequiz @javascript

Feature: Choose different question type

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
      | student1 | Student   | 1        | student1@example.com |
    And the following "courses" exist:
      | fullname    | shortname |
      | Test Course | TC        |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | TC | editingteacher |
      | student1 | TC | student |
    And the following "activity" exists:
    # Create a livequiz activity before the test
      | activity | livequiz         |
      | course   | TC               |
      | idnumber | 1                |
      | name     | livequiz_europe_quiz    |
      | intro    | Test description |
      | section  | 0                |
    And I log in as "teacher1"
    And I am on "Test Course" course homepage with editing mode on

  Scenario: Choose question type
    When I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
    Then I should see "Quiz editor page"
    And "Add Question" "button" should exist
    # The first question is marked as radio button and has only 1 correct answer
    # This should not cause any problems
    And I click on "Add Question" "button"
    Then the "field" with id "question_title_id" should exist
    Then the "field" with id "question_description_id" should exist
    Then the "field" with id "question_explanation_id" should exist
    And "Add Answer" "button" should exist
    And "Save Question" "button" should exist
    And "Cancel" "button" should exist
    Then I set the field "question_title_id" to "Geography 1"
    And I set the field "question_description_id" to "What is the Capital of Sweden?"
    And I set the field "question_explanation_id" to "Stockholm is the capital of Sweden"
    # Check if "Allow only one correct answer" Checkbox is set
    And "Allow only one correct answer" "checkbox" should exist
    And I click on "Allow only one correct answer" "checkbox"
    Then the field with xpath "(//input[@class='question_type_checkbox'])" matches value "checked"

    And I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[1]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[1]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[1]" to "Stockholm"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[1]" to "checked"
    Then I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[2]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[2]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[2]" to "Goteborg"
    And I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[3]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[3]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[3]" to "Malmö"
    And I click on "Save Question" "button"

    # The second question is not as radio button (and is therefore checkbox) and has 2 correct answers
    # This should not cause any problems
    And I click on "Add Question" "button"
    Then I set the field "question_title_id" to "Geography 2"
    And I set the field "question_description_id" to "Which of these are cities in Germany"
    And I set the field "question_explanation_id" to "Essen and Hamburg is located in Germany"
    And I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[1]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[1]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[1]" to "Essen"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[1]" to "checked"
    Then I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[2]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[2]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[2]" to "Aalborg"
    And I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[3]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[3]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[3]" to "Hamburg"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[3]" to "checked"
    And I click on "Save Question" "button"

    # The third question is marked as radio button but has 2 correct answers
    # This should cause a warning, as having multiple answers for a radio button is not allowed
    And I click on "Add Question" "button"
    Then I set the field "question_title_id" to "Geography 3"
    And I set the field "question_description_id" to "What is the Capital of Denmark?"
    And I set the field "question_explanation_id" to "Copenhagen is the capital of Denmark"
    # Check if "Allow only one correct answer" Checkbox is set
    And "Allow only one correct answer" "checkbox" should exist
    And I click on "Allow only one correct answer" "checkbox"
    Then the field with xpath "(//input[@class='question_type_checkbox'])" matches value "checked"

    And I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[1]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[1]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[1]" to "Copenhagen"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[1]" to "checked"
    Then I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[2]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[2]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[2]" to "Aalborg"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[2]" to "checked"
    And I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[3]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[3]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[3]" to "Holstebro"
    And I click on "Save Question" "button"
    And I should see "*You selected the option to allow only one correct answer, but multiple correct answers are currently marked."
    And I set the field with xpath "(//input[@class='answer_checkbox'])[2]" to ""
    And I click on "Save Question" "button"

    # The fourth question is not marked as a radio button (and is therefore a checkbox) and has only 1 correct answer
    # This should not cause any problems.
    # This test is made to differentiate from the previous way of choosing question type, where number of correct answers were used
    And I click on "Add Question" "button"
    Then I set the field "question_title_id" to "Geography 4"
    And I set the field "question_description_id" to "What is the Capital of Spain?"
    And I set the field "question_explanation_id" to "Madrid is the capital of Spain"
    And I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[1]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[1]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[1]" to "Madrid"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[1]" to "checked"
    Then I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[2]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[2]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[2]" to "Barcelona"
    And I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[3]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[3]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[3]" to "Lisbon"
    And I click on "Save Question" "button"

    # The fifth question is marked as radio button and has 1 correct answer.
    # However it is then edited to have 2 correct answer creating a warning.
    And I click on "Add Question" "button"
    Then I set the field "question_title_id" to "Geography 5"
    And I set the field "question_description_id" to "What is the Capital of Portugal?"
    And I set the field "question_explanation_id" to "Lisbon is the capital of Portugal"
    And I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[1]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[1]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[1]" to "Madrid"
    Then I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[2]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[2]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[2]" to "Barcelona"
    And I click on "Add Answer" "button"
    Then the field with xpath "(//input[@class='answer_input'])[3]" matches value ""
    And the field with xpath "(//input[@class='answer_checkbox'])[3]" matches value ""
    And I set the field with xpath "(//input[@class='answer_input'])[3]" to "Lisbon"
    And I set the field with xpath "(//input[@class='answer_checkbox'])[3]" to "checked"
    And I click on "Save Question" "button"
    #Question 5 is now edited, such that it causes a warning
    And I click on "//span[@class='question_list_text' and text()='Geography 5'][1]" "xpath_element"
    And the field with xpath "(//input[@class='answer_checkbox'])[1]" matches value ""
    And I set the field with xpath "(//input[@class='answer_checkbox'])[1]" to "checked"
    And "Allow only one correct answer" "checkbox" should exist
    And I click on "Allow only one correct answer" "checkbox"
    Then the field with xpath "(//input[@class='question_type_checkbox'])" matches value "checked"
    And I click on "Save Question" "button"
    And I should see "*You selected the option to allow only one correct answer, but multiple correct answers are currently marked."
    And I set the field with xpath "(//input[@class='answer_checkbox'])[1]" to ""
    And I click on "Save Question" "button"

    And I click on "Take Quiz" "link"
    Then I should see "Geography 1"
    #The answer options are shown as radio buttons
    And "Stockholm" "radio" should exist
    And "Next Question" "link" should exist
    And I click on "Next Question" "link"
    Then I should see "Geography 2"
    #The answer options are shown as checkboxes
    And "Essen" "checkbox" should exist
    And "Next Question" "link" should exist
    And I click on "Next Question" "link"
    Then I should see "Geography 3"
    #The answer options are shown as radio buttons
    And "Copenhagen" "radio" should exist
    And "Next Question" "link" should exist
    And I click on "Next Question" "link"
    Then I should see "Geography 4"
    #The answer options are shown as checkboxes
    And "Madrid" "checkbox" should exist
    And "Next Question" "link" should exist
    And I click on "Next Question" "link"
    Then I should see "Geography 5"
    #The answer options are shown as radio buttons
    And "Madrid" "radio" should exist
