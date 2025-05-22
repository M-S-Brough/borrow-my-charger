<?php

require_once ('Models/Database.php');
require_once ('Models/UserData.php');

class UserDataSet
{
    // Member variable to store an instance of the Database class
    protected $_dbInstance;
    // Member variable to store a handle to a database connection
    public $_dbHandle;

    public function __construct() {
        // Get an instance of the Database class and a handle to a database connection
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    // Fetch all users from the database and return an array of UserData objects
    public function fetchAllUsers() {
        $sqlQuery = 'SELECT * FROM users';

        // prepare a PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        // execute the PDO statement
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row);
        }
        return $dataSet;
    }

    // Search for users with a username that contains the given search string and return an array of UserData objects
    public function searchUsers($search) {
        $sqlQuery = "SELECT * FROM users WHERE users.username LIKE '$search'";

        // prepare a PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        // execute the PDO statement
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row);
        }
        return $dataSet;
    }

    public function login($username, $password) {
        $sqlQuery = "SELECT * FROM users WHERE username = :username";

        // prepare a PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(':username', $username);
        // execute the PDO statement
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            // User does not exist
            return 0;
        }

        $hashed_password = $user['password'];
        if (password_verify($password, $hashed_password)) {
            // Passwords match
            return 1;
        } else {
            // Passwords do not match
            return 0;
        }
    }


    public function addUser($username, $realname, $password, $profilePic, $phoneNumber) {
        // Check if user is already registered
        $statement = $this->login($username, $password);

        if ($statement > 0) {
            // User already exists
            return false;
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);

            $sqlQuery = "INSERT INTO users (username, realname, password, profile_photo, phone_number) VALUES (:username, :realname, :password, :profilePic, :phoneNumber)";

            // prepare a PDO statement
            $statement = $this->_dbHandle->prepare($sqlQuery);

            $statement->bindParam(':username', $username);
            $statement->bindParam(':realname', $realname);
            $statement->bindParam(':password', $password);
            $statement->bindParam(':profilePic', $profilePic);
            $statement->bindParam(':phoneNumber', $phoneNumber);
            // execute the PDO statement
            $statement->execute();
            return true;
        }
    }


    // Return an array of UserData objects for a user with the given username and password
    public function getUserDetails($username, $password) {
        $sqlQuery = "SELECT * FROM users WHERE username= :username AND password= :password ";

        // prepare a PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', $password);
        // execute the PDO statement
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row);
        }
        return $dataSet;

    }

    // Return the $_Uid member variable of the UserData object
    public function getUserID() {
        return $this->_Uid;
    }
}