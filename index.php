<?php

// Include the User model file
require_once('Models/User.php');
require_once ('Models/Location.php');
unset($_GET['searchID']);


// Create a new stdClass object to store view data
$view = new stdClass();

// Set the page title for the view
$view->pageTitle = 'Home Page';

$location = new Location();
$view->location = $location->getLocationCode();




// Create a new User object
$user = new User();

// Check if the loginbutton POST parameter is set
if (isset($_POST["loginbutton"])) {

    // Attempt to log the user in by calling the userLogin method of the $user object
    // and passing in the username and password POST parameters as arguments
    if ($user->userLogin($_POST["username"], $_POST["password"])) {

        // If the login is successful, display a welcome message with the user's login session variable
        echo 'Welcome ' . $_SESSION['login'];

    } else {

        // If the login is unsuccessful, display an alert message
        echo '<script type="text/javascript">alert("Please enter correct details")</script>';
    }
}

// Check if the logoutbutton POST parameter is set
if (isset($_POST["logoutbutton"])) {
    // Call the logoutUser method of the $user object to log the user out
    $user->logoutUser();
    // Display a thank you message
    echo 'Thank you and see you soon';
}

// Check if the user is logged in
if ($user->isIsLoggedIn()) {

    // If the user is logged in, fetch a list of charger points and store it in the $view->chargerPointDataSet variable
    require_once('Models/ChargerPointDataSet.php');
    $chargerPointDataSet = new ChargerPointDataSet();
    $view->chargerPointDataSet = $chargerPointDataSet->fetchAll();

    $view->pageTitle = "Charge Points";


// Check if the search POST parameter is set
    if (isset($_POST["search"])) {

        // Check if the searchBy POST parameter is empty
        if ($_POST['searchBy'] === "") {

            // If the searchBy parameter is empty, display an alert message
            echo '<script type="text/javascript">alert("Please make a selection")</script>';
        } else {

            // If the searchBy parameter is not empty, store the search term and search criteria in variables
            $search = $_POST["searchPostcode"];
            $selection = $_POST["searchBy"];

            // Fetch the search results by calling the searchPoint method of the ChargerPointDataSet object
            // and passing in the search criteria and search term as arguments
            require_once('Models/ChargerPointDataSet.php');
            $chargerPointDataSet = new ChargerPointDataSet();
            $view->chargerPointDataSet = $chargerPointDataSet->searchPoint($search, $selection);
            $view->pageTitle = "Charge Points Search Results";
        }
    }
// Check if the myPoints POST parameter is set
    if (isset($_POST['myPoints'])) {
        // If the myPoints parameter is set, retrieve and display the user's own charger points
        require_once('Models/ChargerPointDataSet.php');
        $chargerPointDataSet = new ChargerPointDataSet();
        $view->chargerPointDataSet = $chargerPointDataSet->getMyPoints($user->getUserID());
        $view->pageTitle = "My Charge Points";


    }

    if (isset($_GET['searchID'])) {
        $_POST['searchID'] = $_GET['searchID'];
        unset($_GET['searchID']);
        // Use $id to retrieve and display the charger point data
        require_once('Models/ChargerPointDataSet.php');
        $chargerPointDataSet = new ChargerPointDataSet();
        $view->chargerPointDataSet = $chargerPointDataSet->getChargerPointDataById($_POST['searchID']);
        $view->pageTitle = "Search Details";


    }


    if (isset($_POST['chargerMap'])) {
        // Assuming $view has been properly initialized
        $view->pageTitle = "Charger Map";


    }


// Check if the editRow POST parameter is set
    if (isset($_POST['editRow'])) {
        // If the editRow parameter is set, retrieve the charger point data for the row specified by the rowId POST parameter
        $rowId = $_POST['rowId'];
        require_once('Models/ChargerPointDataSet.php');
        $chargerPointDataSet = new ChargerPointDataSet();
        $view->chargerPointDataSet = $chargerPointDataSet->getChargerPointDataById($rowId);
        $view->pageTitle = "My Charge Points";
    }

    if (isset($_POST['deleteRow'])) {
        $rowId = $_POST['rowId'];
        var_dump($rowId);
        require_once('Models/ChargerPointDataSet.php');
        $chargerPointDataSet = new ChargerPointDataSet();
        $chargerPointDataSet->deleteChargerPoint($rowId);
    }
    if (isset($_POST["addPoint"])) {
        $address_1 = $_POST['address_1'];
        $address_2 = $_POST['address_2'];
        $postcode = $_POST['postcode'];
        $lat = $_POST['lat'];
        $long = $_POST['long'];
        $cost = $_POST['cost'];

        var_dump($_POST['address_1']);
        var_dump($address_2);
        var_dump($postcode);
        var_dump($lat);
        var_dump($long);
        var_dump($cost);
        var_dump($user->getUserID());
        require_once('Models/Database.php');


        $chargerPointDataSet = new ChargerPointDataSet();
        $condition = $chargerPointDataSet->addNewPoint($address_1, $address_2, $postcode, $lat, $long, $cost, $user->getUserID());


        if ($condition === true) {
            echo '<script type="text/javascript">alert("Charge Point has been added")</script>';
        } else {

            echo '<script type="text/javascript">alert("Charge Point not added")</script>';

        }
    }

    if (isset($_POST['editRow'])) {
        $view->pageTitle = "Edit Charger Point";

    }

    if (isset($_POST['saveChanges'])) {
        require_once('Models/ChargerPointDataSet.php');

        $rowId = $_POST['rowId'];
        $columnName = $_POST['columnName'];
        $columnValue = $_POST['columnValue'];

        $chargerPointDataSet = new ChargerPointDataSet();
        try {
            $chargerPointDataSet->updateRow($rowId, $columnName, $columnValue);
            echo '<script type="text/javascript">alert("Changes have been made"); window.location.href = "index.php";</script>';
        } catch (Exception $e) {
            // Debug: print any error messages
            echo $e->getMessage();
        }
    }
}


// Check if the form has been submitted
if (isset($_POST["registerUser"])) {

    $view->pageTitle = 'Register User';
    // Get the form values
    $username = $_POST["username"];
    $realname = $_POST["realname"];
    $password = $_POST["password"];
    $profilePic = $_POST["profile_photo"];
    $phoneNumber = $_POST["phone_number"];

    require_once('Models/User.php');

// Include the UserDataSet class
    require_once('Models/UserDataSet.php');


    // Create a new UserDataSet object
    $newUser = new UserDataSet();

    // Add the new user to the database
    $condition = $newUser->addUser($username, $realname, $password, $profilePic, $phoneNumber);

    // If the user was successfully added to the database
    if ($condition === true) {
        // Create a new User object
        $user = new User();

        // Attempt to log the user in
        if ($user->userLogin($username, $password)) {
            // If the login is successful, welcome the user and redirect to the index page
            echo 'Welcome ' . $_SESSION['login'];
            echo '<script type="text/javascript">alert("User added"); window.location.href = "index.php";</script>';
        } else {
            // If the login is unsuccessful, display an error message
            echo '<script type="text/javascript">alert("User already registered")</script>';
        }
    }


}





// Include the index.phtml file
require_once('Views/index.phtml');
