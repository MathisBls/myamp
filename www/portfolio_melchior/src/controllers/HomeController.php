<?php

require_once '../src/services/HomeService.php';
require_once '../src/services/ArtworkService.php';
require_once '../src/services/FilterService.php';

class HomeController
{
    private $homeService;
    private $artworkService;
    private $filterService;

    public function __construct()
    {
        $this->homeService = new HomeService();
        $this->artworkService = new ArtworkService();
        $this->filterService = new FilterService();
    }

    public function index()
    {
        $content = $this->homeService->getHomeContent();
        $latestArtworks = $this->artworkService->getLastThreeArtworks();

        $selectedFilterId = isset($_GET['filter_id']) ? (int)$_GET['filter_id'] : 0;

        if ($selectedFilterId) {
            $latestArtworks = $this->artworkService->getArtworksByFilter($selectedFilterId);
        } else {
            $latestArtworks = $this->artworkService->getLastThreeArtworks();
        }

        $filters = $this->filterService->getAllFilters();

        include '../templates/home.php';
    }
}
