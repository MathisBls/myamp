<?php

require_once '../src/models/Portfolio.php';

class ArtworkService
{
    private $portfolio;

    public function __construct()
    {
        $this->portfolio = new Portfolio();
    }

    public function getAllArtworks()
    {
        return $this->portfolio->getAllArtworks();
    }

    public function getLastThreeArtworks()
    {
        return $this->portfolio->getLastThreeArtworks();
    }

    public function getArtworkById($id)
    {
        return $this->portfolio->getArtworkById($id);
    }

    public function getArtworksByFilter($filterId)
    {
        return $this->portfolio->getArtworksByFilter($filterId);
    }

}
