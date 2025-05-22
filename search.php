<?php

// include the ChargerPointDataSet class
require_once 'Models/ChargerPointDataSet.php';

// create a new instance of the ChargerPointDataSet class
$chargerPointDataSet = new ChargerPointDataSet();

// get the q parameter, the text typed in, from URL
$q = $_REQUEST["q"];

// initialize an empty string for the suggestions
$hint = "";

// lookup all hints from the database if $q is different from ""
if ($q !== "") {
    // call the searchPoint2 method with the search string as parameter
    $results = $chargerPointDataSet->searchPoint2($q);

    // loop through each result to generate the HTML for the suggestions
    foreach($results as $result) {
        $id = $result->getId();
        // check if this is the first result to generate HTML accordingly
        if ($hint === "") {
            // create HTML for the suggestion with an image, address, cost and a button to book
            $hint = "<img src='images/location.png' style='width:25px;height:25px;'>" . $result->getAddress() . " - Price: £"  . $result->getCost() . " <button class='btn btn-danger' onclick='location.href=\"index.php\"; showConfirmation()'>Book</button><br>";
        } else {
            // append HTML for the suggestion with an image, address, cost and a button to book
            $hint .= "<img src='images/location.png' style='width:25px;height:25px;'>" . $result->getAddress() . " - Price: £" . $result->getCost() . " <button class='btn btn-danger' onclick='location.href=\"index.php\"; showConfirmation()'>Book</button><br>";
        }
    }
}

// Output "no suggestion" if no hint was found or output results
echo $hint === "" ? "no suggestion" : $hint;
