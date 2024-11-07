<?php

require_once '../src/models/Portfolio.php';

class FilterService
{
    private $portfolio;

    public function __construct()
    {
        $this->portfolio = new Portfolio();
    }

    public function getAllFilters()
    {
        return $this->portfolio->getAllFilters();
    }
}
