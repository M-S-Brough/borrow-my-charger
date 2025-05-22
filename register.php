<?php
$view = new stdClass();
$view->pageTitle = 'Register User';


require_once('Models/User.php');

// Include the UserDataSet class
require_once('Models/UserDataSet.php');

// Check if the form has been submitted
if (isset($_POST["register"])) {
    // Get the form values
    $username = $_POST["username"];
    $realname = $_POST["realname"];
    $password = $_POST["password"];
    $profilePic = $_POST["profile_photo"];
    $phoneNumber = $_POST["phone_number"];

    // Include the Database class
    require_once('Models/Database.php');

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

// Include the register view
require_once('Views/register.phtml');


