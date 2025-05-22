<?php

class UserData
{
    // Member variables to store information about the user
    public $_Uid, $_username, $_realName, $_password, $_profilePic, $_phoneNumber;

    public function __construct($dbRow) {
        // Initialize member variables with values from the $dbRow associative array
        $this->_Uid = $dbRow['id'];
        $this->_username = $dbRow['username'];
        $this->_realName = $dbRow['realname'];
        $this->_password = $dbRow['password'];
        $this->_profilePic = $dbRow['profile_photo'];
        $this->_phoneNumber = $dbRow['phone_number'];
    }



    // Getters for the member variables
    public function getUID() {
        return $this->_Uid;
    }

    public function getUsername() {
        return $this->_username;
    }

    public function getRealName() {
        return $this->_realName;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function getProfilePic() {
        return $this->_profilePic;

    }

    public function getPhoneNumber() {
        return $this->_phoneNumber;
    }

    // Return a string containing the user's username and phone number in parentheses
    public function getDetails() {
        return $this->_username . "(" . $this->_phoneNumber . ")";
    }

}
