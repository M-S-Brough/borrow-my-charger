<?php
require_once('UserDataSet.php');
require_once('UserData.php');

class User
{
    // Member variables to store information about the user
    protected $_username;
    protected $_isLoggedIn;
    protected $_userID;
    protected $_profilePic;
    protected $_fullName;

    public function __construct()
    {
        // Start a new session
        session_start();

        // Initialize member variables with default values
        $this->_username = "blank";
        $this->_isLoggedIn = false;
        $this->_userID = "0";
        $this->_profilePic = "";
        $this->_fullName = "";

        // If there is an active session with a login, set the member variables to the values stored in the session
        if (isset($_SESSION['login'])) {
            $this->_username = $_SESSION['login'];
            $this->_userID = $_SESSION['Uid'];
            $this->_isLoggedIn = true;
            $this->_profilePic = $_SESSION['pic'];
            $this->_fullName = $_SESSION['name'];
        }
    }

    // Getters for the member variables
    public function getUsername()
    {
        return $this->_username;
    }

    public function isIsLoggedIn()
    {
        return $this->_isLoggedIn;
    }

    public function getUserID()
    {
        return $this->_userID;
    }

    // Function to attempt to log the user in with the given username and password
    public function userLogin($username, $password)
    {
        // Create an instance of the UserDataSet class
        $newLogin = new UserDataSet();

        // Attempt to get user details with the given username and password
        $check = $newLogin->getUserDetails($username, $password);

        // If a user was found
        if (count($check) > 0) {
            // Set member variables and session variables to the values of the found user
            $_SESSION['login'] = $username;
            $_SESSION['Uid'] = $check[0]->getUID();
            $_SESSION['pic'] = $check[0]->getProfilePic();
            $_SESSION['name'] = $check[0]->getRealName();
            $this->_isLoggedIn = true;
            $this->_username = $username;
            $this->_userID = $check[0]->getUID();
            $this->_profilePic = $check[0]->getProfilePic();
            $this->_fullName = $check[0]->getRealName();
            return true;
        } // If no user was found, set isLoggedIn to false
        else {
            $this->_isLoggedIn = false;
            return false;
        }
    }

    public function logoutUser()
    {
        // Clear member variables and unset session variables
        $this->_username = "blank";
        $this->_isLoggedIn = false;
        $this->_userID = "0";
        unset($_SESSION['login']);
        unset($_SESSION['Uid']);
        unset($_SESSION['pic']);
        // End the session
        session_destroy();
    }
}
