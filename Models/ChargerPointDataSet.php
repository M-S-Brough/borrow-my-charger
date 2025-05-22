<?php

// Require the necessary classes
require_once 'Models/Database.php';
require_once 'Models/ChargerPointData.php';
require_once 'Models/UserData.php';

class ChargerPointDataSet
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

    // Method to fetch all rows from the charge_points table, along with related rows from the users table
    public function fetchAll()
    {
        // Select all rows from the charge_points table, along with the related rows from the users table using an INNER JOIN
        $sqlQuery = 'SELECT * FROM charge_points INNER JOIN users ON users.id = charge_points.owner';

        // Prepare a PDO statement
        $statement = $this->_dbConnection->prepare($sqlQuery);

        // Execute the PDO statement
        $statement->execute();

        // Initialize an empty array to store the data
        $dataSet = [];

        // Fetch each row as an associative array
        while ($row = $statement->fetch()) {
            // Create a ChargerPointData object and add it to the array
            $dataSet[] = new ChargerPointData($row);
        }

        // Return the array of ChargerPointData objects
        return $dataSet;
    }

    public function fetchAllSearch($query = null) {
        $sqlQuery = 'SELECT * FROM charge_points INNER JOIN users ON users.id = charge_points.owner';
        if ($query) {
            $sqlQuery .= ' WHERE charge_points.name LIKE ? OR users.name LIKE ?';
            $statement = $this->_dbConnection->prepare($sqlQuery);
            $statement->execute(["%$query%", "%$query%"]);
        } else {
            $statement = $this->_dbConnection->prepare($sqlQuery);
            $statement->execute();
        }
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new ChargerPointData($row);
        }
        return json_encode($dataSet);
    }


    // Method to fetch the rows from the charge_points table associated with the user with the specified username, along with related rows from the users table
    public function getProfilePic($username)
    {
        // Select all rows from the charge_points table, along with the related rows from the users table using an INNER JOIN, where the username matches the specified username
        $sqlQuery = "SELECT * FROM charge_points INNER JOIN users ON users.id = charge_points.owner WHERE users.username= '$username'";

        // Prepare a PDO statement
        $statement = $this->_dbConnection->prepare($sqlQuery);

        // Execute the PDO statement
        $statement->execute();

        // Initialize an empty array to store the data
        $dataSet = [];

        // Fetch each row as an associative array
        while ($row = $statement->fetch()) {
            // Create a ChargerPointData object and add it to the array
            $dataSet[] = new ChargerPointData($row);
        }

        // Return the array of ChargerPointData objects
        return $dataSet;
    }

    // Method to search for rows in the charge_points table that match the specified search string in the specified column, along with related rows from the users table
    public function searchPoint($search, $selection)
    {
        // Select all rows from the charge_points table, along with the related rows from the users table using an INNER JOIN, where the specified column contains the search string
        $sqlQuery = "SELECT * FROM charge_points INNER JOIN users ON users.id = charge_points.owner WHERE " . $selection . " LIKE :search";

        // Prepare a PDO statement and bind the search string as a parameter
        $statement = $this->_dbConnection->prepare($sqlQuery);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        // Execute the PDO statement
        $statement->execute();

        // Initialize an empty array to store the data
        $dataSet = [];

        // Fetch each row as an associative array
        while ($row = $statement->fetch()) {
            // Create a ChargerPointData object and add it to the array
            $dataSet[] = new ChargerPointData($row);
        }


        // Return the array of ChargerPointData objects
        return $dataSet;
    }

    public function searchPoint2($search)
    {
        // Select all rows from the charge_points table, along with the related rows from the users table using an INNER JOIN, where the specified column contains the search string
        $sqlQuery = "SELECT * FROM charge_points INNER JOIN users ON users.id = charge_points.owner WHERE charge_points.address_2 LIKE :search";

        // Prepare a PDO statement and bind the search string as a parameter
        $statement = $this->_dbConnection->prepare($sqlQuery);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        // Execute the PDO statement
        $statement->execute();

        // Initialize an empty array to store the data
        $dataSet = [];

        // Fetch each row as an associative array
        while ($row = $statement->fetch()) {
            // Create a ChargerPointData object and add it to the array
            $dataSet[] = new ChargerPointData($row);
        }


        // Return the array of ChargerPointData objects
        return $dataSet;
    }

    public function searchLocation($latitude, $longitude, $radius)
    {
        // Calculate the minimum and maximum latitude and longitude values for the search radius
        $minLat = $latitude - ($radius / 69);
        $maxLat = $latitude + ($radius / 69);
        $minLng = $longitude - ($radius / (69 * cos(deg2rad($latitude))));
        $maxLng = $longitude + ($radius / (69 * cos(deg2rad($latitude))));

        // Select all rows from the charge_points table where the latitude and longitude values fall within the search radius
        $sqlQuery = "SELECT * FROM charge_points WHERE lat BETWEEN :minLat AND :maxLat AND 'long' BETWEEN :minLng AND :maxLng";

        // Prepare a PDO statement and bind the search parameters as parameters
        $statement = $this->_dbConnection->prepare($sqlQuery);
        $statement->bindValue(':minLat', $minLat, PDO::PARAM_STR);
        $statement->bindValue(':maxLat', $maxLat, PDO::PARAM_STR);
        $statement->bindValue(':minLng', $minLng, PDO::PARAM_STR);
        $statement->bindValue(':maxLng', $maxLng, PDO::PARAM_STR);

        // Execute the PDO statement
        $statement->execute();

        // Initialize an empty array to store the data
        $dataSet = [];

        // Fetch each row as an associative array
        while ($row = $statement->fetch()) {
            // Create a ChargerPointData object and add it to the array
            $dataSet[] = new ChargerPointData($row);
        }

        // Return the array of ChargerPointData objects
        return $dataSet;
    }



    // Method to fetch the rows from the charge_points table associated with the user with the specified user ID, along with related rows from the users table
    public function getMyPoints($userID)
    {
        // Select all rows from the charge_points table, along with the related rows from the users table using an INNER JOIN, where the user ID matches the specified user ID
        $sqlQuery = 'SELECT * FROM charge_points INNER JOIN users ON users.id = charge_points.owner WHERE users.id = :userID';

        // Prepare a PDO statement and bind the user ID as a parameter
        $statement = $this->_dbConnection->prepare($sqlQuery);
        $statement->bindParam(':userID', $userID);

        // Execute the PDO statement
        $statement->execute();

        // Initialize an empty array to store the data
        $dataSet = [];

        // Fetch each row as an associative array
        while ($row = $statement->fetch()) {
            // Create a ChargerPointData object and add it to the array
            $dataSet[] = new ChargerPointData($row);
        }

        // Return the array of ChargerPointData objects
        return $dataSet;
    }

    // Method to fetch the rows from the charge_points table that have the specified row ID, along with related rows from the users table
    public function getChargerPointDataById($rowId)
    {
        // Select all rows from the charge_points table, along with the related rows from the users table using an INNER JOIN, where the CPid column matches the specified row ID
        $sqlQuery = "SELECT * FROM charge_points INNER JOIN users ON users.id = charge_points.owner WHERE charge_points.CPid = '$rowId'";

        // Prepare a PDO statement
        $statement = $this->_dbConnection->prepare($sqlQuery);

        // Execute the PDO statement
        $statement->execute();

        // Initialize an empty array to store the data
        $dataSet = [];

        // Fetch each row as an associative array
        while ($row = $statement->fetch()) {
            // Create a ChargerPointData object and add it to the array
            $dataSet[] = new ChargerPointData($row);
        }

        // Return the array of ChargerPointData objects
        return $dataSet;
    }
    // Method to add a new row to the charge_points table with the specified values
    public function addNewPoint($address1, $address2, $postcode, $lat, $long, $cost, $owner)
    {
        // Insert a new row into the charge_points table with the specified values for the address_1, address_2, postcode, lat, long, cost, and owner columns
        $sqlQuery = "INSERT INTO charge_points (address_1, address_2, postcode, lat, `long`, cost, `owner`) VALUES (:address1, :address2, :postcode, :lat, :long, :cost, :owner)";

        // Prepare a PDO statement and bind the values as parameters
        $statement = $this->_dbConnection->prepare($sqlQuery);
        $statement->bindParam(':address1', $address1);
        $statement->bindParam(':address2', $address2);
        $statement->bindParam(':postcode', $postcode);
        $statement->bindParam(':lat', $lat);
        $statement->bindParam(':long', $long);
        $statement->bindParam(':cost', $cost);
        $statement->bindParam(':owner', $owner);

        // Execute the PDO statement
        $statement->execute();

        // Return true to indicate that the operation was successful
        return true;
    }

    // Method to delete a row from the charge_points table with the specified CPid value
    public function deleteChargerPoint($rowId)
    {
        // Delete a row from the charge_points table where the CPid column has the specified value
        $sqlQuery = "DELETE FROM charge_points WHERE CPid = :rowId";

        // Prepare a PDO statement and bind the rowId as a parameter
        $statement = $this->_dbConnection->prepare($sqlQuery);
        $statement->bindParam(':rowId', $rowId);

        // Execute the PDO statement
        $statement->execute();
    }
    public function generateDataSet() {
        $chargePoints = $this->fetchAll();
        $markers = array();

        foreach ($chargePoints as $chargePointData) {
            $marker = array(
                'lat' => $chargePointData->getLat(),
                'lng' => $chargePointData->getLong(),
                // Add other relevant properties to the marker array
            );
            $markers[] = $marker;
        }

        return $markers;

}

    public function retrieveData()
    {
        $sqlQuery = "SELECT * FROM charge_points AS chargepoints INNER JOIN users u on chargepoints.owner = u.id";
        // Prepare a PDO statement
        $statement = $this->_dbConnection->prepare($sqlQuery);

        // Execute the PDO statement
        $statement->execute();

        // Initialize an empty array to store the data
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new ChargerPointData($row);
        }
        return $dataSet;

    }


    // Method to update a row in the charge_points table
    public function updateRow($rowId, $columnName, $columnValue)
    {
        // Check if the specified column name is valid
        $validColumns = ['address_1', 'address_2', 'postcode', 'cost'];
        if (!in_array($columnName, $validColumns)) {
            throw new Exception("Invalid column name: $columnName");
        }

        // Prepare an UPDATE statement to update the specified column value in the specified row
        $sqlQuery = "UPDATE charge_points SET $columnName = :columnValue WHERE CPid = :rowId";

        // Prepare a PDO statement and bind the parameters
        $statement = $this->_dbConnection->prepare($sqlQuery);
        $statement->bindValue(':rowId', $rowId, PDO::PARAM_INT);
        $statement->bindValue(':columnValue', $columnValue);

        // Execute the PDO statement
        $statement->execute();
    }




}