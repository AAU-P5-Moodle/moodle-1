@mod @mod_livequiz @javascript

Feature: View explanation of a question
    Background:
        Given the following "users" exist:
            | username | firstname | lastname | email             |
            | student1 | stu       | dent     | student1@mail.com |
        And the following "courses" exist:
            | fullname    | shortname |
            | Test Course | TC        |
        And the following "course enrolments" exist:
            | user     | course | role    |
            | student1 | TC     | student |
        And the following "activity" exists:
            # Create a livequiz activity before the test
            | activity | livequiz             |
            | course   | TC                   |
            | idnumber | 1                    |
            | name     | livequiz_europe_quiz |
            | intro    | Test description     |
            | section  | 0                    |
        And I use demodata for the course "TC" and activity "livequiz"
        And I log in as "student1"
        And I am on "Test Course" course homepage with editing mode off

    Scenario: Show explanation of a question
        And I click on "livequiz_europe_quiz" "link" in the "livequiz" activity
        And I should see "Take Quiz"
        And I click on "Take Quiz" "link"
        And I click on "Paris" "checkbox"
        And I should see "Submit Quiz"
        And I click on "Submit Quiz" "button" confirming the dialogue
        Then I should see "Results for attempt"
        And I should see "Paris is a city in France, Nice is a city in France"
        And I should see "Danish capital"
        And I should see "Hamburg is a city in Northern Germany"

