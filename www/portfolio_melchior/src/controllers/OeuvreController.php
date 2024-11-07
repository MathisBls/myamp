<?php

require_once '../src/services/ArtworkService.php';
require_once '../src/services/HomeService.php';
require_once '../src/services/FilterService.php';

class OeuvreController
{
    private $artworkService;
    private $homeService;
    private $filterService;

    public function __construct()
    {
        $this->artworkService = new ArtworkService();
        $this->homeService = new HomeService();
        $this->filterService = new FilterService();
    }

    public function index()
    {
        $latestArtworks = $this->artworkService->getLastThreeArtworks();
        $content = $this->homeService->getHomeContent();

        $selectedFilterId = isset($_GET['filter_id']) ? (int)$_GET['filter_id'] : 0;

        $artworkId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        $selectedArtwork = $this->artworkService->getArtworkById($artworkId);

        if ($selectedFilterId) {
            $latestArtworks = $this->artworkService->getArtworksByFilter($selectedFilterId);
        } else {
            $latestArtworks = $this->artworkService->getLastThreeArtworks();
        }
        if (!$selectedArtwork) {
            header('Location: /index.php');
            exit();
        }

        $filters = $this->filterService->getAllFilters();

        include '../templates/artwork.php';
    }
}
