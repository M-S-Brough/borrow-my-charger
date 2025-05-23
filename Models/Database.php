<?php
class Database
{
    /**
     * @var Database
     */
    protected static $_dbInstance = null;

    /**
     * @var PDO
     */
    protected $_dbHandle;

    /**
     * @return Database
     */
    public static function getInstance()
    {
        $username = 'age929';
        $password = 'JaxGDB2018';
        $host = 'age929.poseidon.salford.ac.uk';
        $dbName = 'age929_students';
        if (self::$_dbInstance === null) { //checks if the PDO exists
            // creates new instance if not, sending in connection info
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }
        return self::$_dbInstance;
    }
    /**
     * @param $username
     * @param $password
     * @param $host
     * @param $database
     */
    public function __construct($username, $password, $host, $database)
    {
        try {
            // creates the database handle with connection info
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            // creates the database handle with connection info
            //$this->_dbHandle = new PDO('mysql:host=' . $host . ';dbname=' . $database,  $username, $password);

        } catch (PDOException $e) { // catch any failure to connect to the database
            echo $e->getMessage();
        }
    }

    /**
     * @return PDO
     */
    public function getdbConnection()
    {
        return $this->_dbHandle; // returns the PDO handle to be used                                        elsewhere
    }

    public function __destruct()
    {
        $this->_dbHandle = null; // destroys the PDO handle when nolonger needed                                        longer needed
    }


}