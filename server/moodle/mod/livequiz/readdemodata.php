<?php
/**
 * Temporary read demo data file
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_livequiz;
defined('MOODLE_INTERNAL') || die();
use mod_livequiz\classes\livequiz;
require_once('classes\livequiz.php');

// Read the JSON file.
$json = file_get_contents('demodata.json');

// Check if the file was read successfully.
if ($json === false) {
    die('Error reading the JSON file');
}

// Decode the JSON file.
$jsondata = json_decode($json, true);

// Check if the JSON was decoded successfully.
if ($jsondata === null) {
    die('Error decoding the JSON file');
}

$jsondata = $jsondata["quiz1"];
$quiz = new livequiz(
    $jsondata["id"],
    $jsondata["name"],
    $jsondata["course"],
    $jsondata["intro"],
    $jsondata["introformat"],
    $jsondata["timecreated"],
    $jsondata["timemodified"],
    $jsondata["questions"]
);


// Display data.
echo "<pre>";
print_r($quiz);
echo "</pre>";
