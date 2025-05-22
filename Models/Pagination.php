<?php

class Pagination
{
    private $_perPage, $_totalRows, $_totalPages;
    public $_currentPage;

    public function __construct($perPage, $totalRows)
    {
        $this->_perPage = $perPage;
        $this->_totalRows = $totalRows;
        $this->_totalPages = ceil($totalRows / $perPage);
        $this->_currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    }

    public function getOffset()
    {
        return ($this->_currentPage - 1) * $this->_perPage;
    }

    public function getPerPage()
    {
        return $this->_perPage;
    }

    public function getTotalRows()
    {
        return $this->_totalRows;
    }

    public function getCurrentPage()
    {
        return $this->_currentPage;
    }

    public function getTotalPages()
    {
        return $this->_totalPages;
    }

    public function hasPreviousPage()
    {
        return $this->_currentPage > 1;
    }

    public function getPreviousPage()
    {
        return $this->hasPreviousPage() ? $this->_currentPage - 1 : null;
    }

    public function hasNextPage()
    {
        return $this->_currentPage < $this->_totalPages;
    }

    public function getNextPage()
    {
        return $this->hasNextPage() ? $this->_currentPage + 1 : null;
    }
}
