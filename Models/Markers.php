<?php
require_once 'Models/Database.php';
require_once 'Models/ChargerPointData.php';
require_once 'Models/ChargerPointDataSet.php';
require_once 'Models/UserData.php';

class Markers
{
    // Properties to store the database connection and instance
    protected $_dbConnection, $_dbInstance;

    // Constructor to establish a database connection
    public function __construct()
    {
        // Get the database instance and connection
        $this->_dbInstance = Database::getInstance();
        $this->_dbConnection = $this->_dbInstance->getDbConnection();
    }


}