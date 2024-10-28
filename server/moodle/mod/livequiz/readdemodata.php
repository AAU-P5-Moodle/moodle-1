<?php
namespace mod_livequiz;
use mod_livequiz\classes\livequiz;
require_once 'classes\livequiz.php';

// Read the JSON file
$json = file_get_contents('demodata.json');

// Check if the file was read successfully
if ($json === false) {
    die('Error reading the JSON file');
}

// Decode the JSON file
$json_data = json_decode($json, true);

// Check if the JSON was decoded successfully
if ($json_data === null) {
    die('Error decoding the JSON file');
}

$json_data = $json_data["quiz1"];
$Quiz = new livequiz($json_data["id"], $json_data["name"], $json_data["course"], $json_data["intro"], $json_data["introformat"], $json_data["timecreated"], $json_data["timemodified"], $json_data["questions"]);


// Display data
echo "<pre>";
print_r($Quiz);
echo "</pre>";

?>