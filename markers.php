<?php
// Including the ChargerPointDataSet.php file, which contains the ChargerPointDataSet class
require_once ('Models/ChargerPointDataSet.php');

// Initializing a new instance of the ChargerPointDataSet class
$chargerPointDataSet = new ChargerPointDataSet();

// Calling the fetchAll() method of the ChargerPointDataSet class to retrieve all charger points
// and then encoding the result as a JSON string using json_encode() function
echo json_encode($chargerPointDataSet->fetchAll());
