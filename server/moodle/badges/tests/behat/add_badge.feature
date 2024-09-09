@core @core_badges
Feature: Add badges to the system
  In order to give badges to users for their achievements
  As an admin
  I need to manage badges in the system

  Background:
    Given I am on homepage
    And I log in as "admin"

  @javascript
  Scenario: Accessing the badges
    And I turn editing mode on
    And the following config values are set as admin:
      | unaddableblocks | | theme_boost|
   # TODO MDL-57120 site "Badges" link not accessible without navigation block.
    And I add the "Navigation" block if not present
    And I click on "Site pages" "list_item" in the "Navigation" "block"
    Given I click on "Site badges" "link" in the "Navigation" "block"
    Then I should see "There are no matching badges available for users to earn"

  @javascript @_file_upload
  Scenario: Add a site badge
    Given the following config values are set as admin:
      | badges_defaultissuername    | Test Badge Site      |
      | badges_defaultissuercontact | testuser@example.com |
    And I navigate to "Badges > Add a new badge" in site administration
    And the field "Issuer name" matches value "Test Badge Site"
    And the field "Issuer contact" matches value "testuser@example.com"
    And I set the following fields to these values:
      | Name           | Test badge with 'apostrophe' and other friends (<>&@#) |
      | Version        | v1                                                     |
      | Language       | English                                                |
      | Description    | Test badge description                                 |
      | Image author   | http://author.example.com                              |
      | Image caption  | Test caption image                                     |
      | Tags           | Math, Physics                                          |
      | Issuer contact | issuer@example.com                                     |
    And I upload "badges/tests/behat/badge.png" file to "Image" filemanager
    When I press "Create badge"
    Then I should see "Edit details"
    And I should see "Test badge with 'apostrophe' and other friends (&@#)"
    And I should see "Endorsement"
    And I should see "Related badges (0)"
    And I should see "Alignments (0)"
    And I should not see "Create badge"
    And I select "Overview" from the "jump" singleselect
    And I should see "Issuer details"
    And I should see "Test Badge Site"
    And I should see "issuer@example.com"
    And I should not see "testuser@example.com"
    And I should see "Tags"
    And I should see "Math"
    And I should see "Physics"
    And I navigate to "Badges > Manage badges" in site administration
    And I should not see "There are no matching badges available for users to earn"

  @javascript @_file_upload
  Scenario: Add a badge related
    Given I navigate to "Badges > Add a new badge" in site administration
    And I set the following fields to these values:
      | Name | Test Badge 1 |
      | Version | v1 |
      | Language | French |
      | Description | Test badge related description |
      | Image author | http://author.example.com |
      | Image caption | Test caption image |
    And I upload "badges/tests/behat/badge.png" file to "Image" filemanager
    And I press "Create badge"
    And I navigate to "Badges > Manage badges" in site administration
    And I press "Add a new badge"
    And I set the following fields to these values:
      | Name | Test Badge 2 |
      | Version | v2 |
      | Language | English |
      | Description | Test badge description |
      | Image author | http://author.example.com |
      | Image caption | Test caption image |
    And I upload "badges/tests/behat/badge.png" file to "Image" filemanager
    And I press "Create badge"
    And I select "Related badges (0)" from the "jump" singleselect
    And I should see "This badge does not have any related badges."
    And I press "Add related badge"
    And I follow "Related badges"
    And I follow "Related badges"
    And I set the field "relatedbadgeids[]" to "Test Badge 1 (version: v1, language: French, Site badges)"
    When I press "Save changes"
    Then I should see "Related badges (1)"

  @javascript @_file_upload
  Scenario: Endorsement for Badge
    Given I navigate to "Badges > Add a new badge" in site administration
    And I set the following fields to these values:
      | Name | Test Badge Enrolment |
      | Version | v1 |
      | Language | English |
      | Description | Test badge description |
      | Image author | http://author.example.com |
      | Image caption | Test caption image |
    And I upload "badges/tests/behat/badge.png" file to "Image" filemanager
    When I press "Create badge"
    Then I should see "Edit details"
    And I should see "Endorsement"
    And I select "Endorsement" from the "jump" singleselect
    And I set the following fields to these values:
      | Endorser name | Endorser |
      | Email | endorsement@example.com |
      | Issuer URL | http://example.com  |
      | Claim URL | http://claimurl.example.com |
      | Endorsement comment | Test Endorsement comment |
    And I press "Save changes"
    Then I should see "Changes saved"

  @javascript @_file_upload
  Scenario: Alignments for Badge
    Given I navigate to "Badges > Add a new badge" in site administration
    And I set the following fields to these values:
      | Name | Test Badge |
      | Version | v1 |
      | Language | English |
      | Description | Test badge description |
      | Image author | http://author.example.com |
      | Image caption | Test caption image |
    And I upload "badges/tests/behat/badge.png" file to "Image" filemanager
    When I press "Create badge"
    Then I should see "Test Badge"
    And I should see "Endorsement"
    And I select "Alignments (0)" from the "jump" singleselect
    And I should see "This badge does not have any external skills or standards specified."
    And I press "Add external skill or standard"
    And I set the following fields to these values:
      | Name | Test Badge Alignments |
      | URL | https://alignments.example.com |
      | Description | Test Badge Alignments description |
    When I press "Save changes"
    And I should see "Alignments (1)"

  @javascript @_file_upload
  Scenario: Add a badge from Site badges section
    Given I turn editing mode on
    And the following config values are set as admin:
      | unaddableblocks | | theme_boost|
    # TODO MDL-57120 site "Badges" link not accessible without navigation block.
    And I add the "Navigation" block if not present
    When I click on "Site pages" "list_item" in the "Navigation" "block"
    And I click on "Site badges" "link" in the "Navigation" "block"
    Then I should see "Add a new badge"
    # Add a badge.
    When I press "Add a new badge"
    And I set the following fields to these values:
      | Name | Test badge with 'apostrophe' and other friends (<>&@#) 2 |
      | Version | v1 |
      | Language | English |
      | Description | Test badge description |
      | Image author | http://author.example.com |
      | Image caption | Test caption image |
    And I upload "badges/tests/behat/badge.png" file to "Image" filemanager
    And I press "Create badge"
    Then I should see "Edit details"
    And I should see "Test badge with 'apostrophe' and other friends (&@#) 2"
    And I should see "Endorsement"
    And I should see "Related badges (0)"
    And I should see "Alignments (0)"
    And I should not see "Create badge"
    And I navigate to "Badges > Manage badges" in site administration
    And I should not see "There are no matching badges available for users to earn"
    # See buttons from the "Site badges" page.
    And I am on homepage
    When I click on "Site pages" "list_item" in the "Navigation" "block"
    And I click on "Site badges" "link" in the "Navigation" "block"
    Then I should see "Manage badges"
    And I should see "Add a new badge"

  @javascript @_file_upload
  Scenario: Edit a site badge
    Given the following "core_badges > Badge" exists:
      | name           | Site badge                     |
      | status         | inactive                       |
      | version        | 1                              |
      | language       | ca                             |
      | description    | Test badge description         |
      | image          | badges/tests/behat/badge.png   |
      | imageauthorurl | http://imtheauthor.example.com |
      | imagecaption   | My caption image               |
      | issuercontact  | testuser@example.com           |
    And the following "core_badges > Criterias" exist:
      | badge       | role           |
      | Site badge  | editingteacher |
    And I navigate to "Badges > Manage badges" in site administration
    When I press "Edit" action in the "Site badge" report row
    And I should see "Site badge"
    And the field "Issuer contact" matches value "testuser@example.com"
    And I set the following fields to these values:
      | Name           | Test badge with 'apostrophe' and other friends (<>&@#) |
      | Version        | secondversion                                          |
      | Language       | English                                                |
      | Description    | Modified test badge description                        |
      | Image author   | http://author.example.com                              |
      | Image caption  | Test caption image                                     |
      | Tags           | Math, History                                          |
      | Issuer contact | issuer@invalid.cat                                     |
    And I press "Save changes"
    And I select "Overview" from the "jump" singleselect
    And I expand all fieldsets
    Then I should see "Test badge with 'apostrophe' and other friends (&@#)"
    And I should not see "Site badge"
    And I should see "secondversion"
    And I should not see "firstversion"
    And I should see "Math"
    And I should see "History"
    And I should see "issuer@invalid.cat"
    And I should not see "testuser@example.com"

  Scenario: Default value for issuer name
    When I navigate to "Badges > Add a new badge" in site administration
    Then the field "Issuer name" matches value "Acceptance test site"
    But the following config values are set as admin:
      | badges_defaultissuername    | Test Badge Site      |
    And I navigate to "Badges > Add a new badge" in site administration
    And the field "Issuer name" matches value "Test Badge Site"

  Scenario: Cancel button behaviour when creating badges
    Given the following "course" exists:
      | fullname         | Course 1                           |
      | shortname        | C1                                 |
    And the following "core_badges > Badge" exists:
      | name        | Site Badge 1                 |
      | description | Site badge 1 description     |
      | image       | badges/tests/behat/badge.png |
      | status      | 0                            |
      | type        | 1                            |
    And the following "core_badges > Badge" exists:
      | name        | Course Badge 1               |
      | course      | C1                           |
      | description | Course badge 1 description   |
      | image       | badges/tests/behat/badge.png |
      | status      | 0                            |
      | type        | 2                            |
    # Site badge: cancel when creating.
    When I navigate to "Badges > Add a new badge" in site administration
    And I click on "Cancel" "button"
    Then I should see "Manage badges"
    And I should see "Add a new badge"
    # Site badge: cancel when editing.
    And I press "Edit" action in the "Site Badge 1" report row
    And I click on "Cancel" "button"
    And I should see "Site badge 1"
    And I should not see "Save changes"
    # Course badge: cancel when creating.
    And I am on the "Course 1" "course" page
    And I navigate to "Badges > Manage badges > Add a new badge" in current page administration
    And I click on "Cancel" "button"
    Then I should see "Manage badges"
    And I should see "Add a new badge"
    # Course badge: cancel when editing.
    And I press "Edit" action in the "Course Badge 1" report row
    And I click on "Cancel" "button"
    And I should see "Course badge 1"
    And I should not see "Save changes"
