<?php
require_once 'Models/UserData.php';
class ChargerPointData extends UserData implements JsonSerializable
{
    protected $_CPid, $_address1, $_address2, $_postcode, $_lat, $_long, $_cost, $_owner;


    public function __construct($dbRow) {


        parent::__construct($dbRow);
        $this->_CPid = $dbRow['CPid'];
        $this->_address1 = $dbRow['address_1'];
        $this->_address2 = $dbRow['address_2'];
        $this->_postcode = $dbRow['postcode'];
        $this->_lat = $dbRow['lat'];
        $this->_long = $dbRow['long'];
        $this->_cost = $dbRow['cost'];
        $this->_owner = $dbRow['owner'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_CPid;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->_address1 . ", " . $this->_address2 . ", " . $this->_postcode;
    }



    public function getLocation()
    {
        return $this->_lat . " / " . $this->_long;
    }

    /**
     * @return mixed
     */

    public function getAddress1()
    {
        return $this->_address1;
    }

    public function getAddress2()
    {
        return $this->_address2;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->_postcode;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->_lat;
    }

    /**
     * @return mixed
     */
    public function getLong()
    {
        return $this->_long;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->_cost;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->_owner;
    }




    public function jsonSerialize()
    {
        return [

            'address' => $this->getAddress1(),
            'postcode' => $this->getPostcode(),
            'cost' => $this->getCost(),
        'lat' => $this->getLat(),
        'long' => $this->getLong()

            ];

    }
}