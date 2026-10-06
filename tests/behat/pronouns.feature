@local @local_pronouns
Feature: Users can set their pronouns which are shown next to their name
  In order to be addressed correctly
  As a user
  I need to be able to choose my pronouns in my profile and have them displayed next to my name

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | student1 | Student   | One      | student1@example.com |
      | manager1 | Manager   | One      | manager1@example.com |
    And the following "role assigns" exist:
      | user     | role    | contextlevel | reference |
      | manager1 | manager | System       |           |
    And the following config values are set as admin:
      | fullnamedisplay           | firstname lastname alternatename |
      | alternativefullnameformat | firstname lastname alternatename |

  Scenario: The pronouns profile field offers one option per line
    Given I log in as "student1"
    When I open my profile in edit mode
    Then I should see "Pronouns"
    And the "Pronomen | Pronouns" select box should contain "-"
    And the "Pronomen | Pronouns" select box should contain "sie/ihr | she/her"
    And the "Pronomen | Pronouns" select box should contain "er/ihm | he/him"
    And the "Pronomen | Pronouns" select box should contain "dey/dem | they/them"
    And the "Pronomen | Pronouns" select box should not contain "-sie/ihr | she/herer/ihm | he/himdey/dem | they/them"

  Scenario: A user sets their own pronouns and they are shown next to their name
    Given I log in as "student1"
    And I open my profile in edit mode
    When I set the field "Pronomen | Pronouns" to "sie/ihr | she/her"
    And I press "Update profile"
    And I am on the "student1" "user > profile" page
    Then I should see "Student One (sie/ihr | she/her)"

  Scenario: A user removes their pronouns by choosing the empty option
    Given I log in as "student1"
    And I open my profile in edit mode
    And I set the field "Pronomen | Pronouns" to "dey/dem | they/them"
    And I press "Update profile"
    And I am on the "student1" "user > profile" page
    And I should see "Student One (dey/dem | they/them)"
    When I open my profile in edit mode
    And I set the field "Pronomen | Pronouns" to "-"
    And I press "Update profile"
    And I am on the "student1" "user > profile" page
    Then I should see "Student One"
    And I should not see "Student One (dey/dem | they/them)"

  Scenario: An admin sets the pronouns of another user
    Given I am on the "student1" "user > editing" page logged in as "admin"
    When I set the field "Pronomen | Pronouns" to "er/ihm | he/him"
    And I press "Update profile"
    And I am on the "student1" "user > profile" page
    Then I should see "Student One (er/ihm | he/him)"
    And I am on the "admin" "user > profile" page
    And I should not see "(er/ihm | he/him)"

  Scenario: A manager sets the pronouns of another user without changing their own name
    Given I am on the "student1" "user > editing" page logged in as "manager1"
    When I set the field "Pronomen | Pronouns" to "sie/ihr | she/her"
    And I press "Update profile"
    And I am on the "student1" "user > profile" page
    Then I should see "Student One (sie/ihr | she/her)"
    And I am on the "manager1" "user > profile" page
    And I should see "Manager One"
    And I should not see "(sie/ihr | she/her)"
