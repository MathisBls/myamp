<?php

require_once '../src/services/ArtworkService.php';
require_once '../src/services/HomeService.php';
require_once '../src/services/FilterService.php';

class FilteredArtworksController
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
        $filterId = isset($_GET['filter_id']) ? (int)$_GET['filter_id'] : 0;
        $content = $this->homeService->getHomeContent();
        $filters = $this->filterService->getAllFilters();
    
        // Initialisation de la variable pour le nom du filtre
        $selectedFilterName = "Filtre inconnu";
    
        if ($filterId === 0) {
            $artworks = $this->artworkService->getAllArtworks();
            $selectedFilterName = "Toutes les œuvres";
        } else {
            $artworks = $this->artworkService->getArtworksByFilter($filterId);
            foreach ($filters as $filter) {
                if ($filter['id'] == $filterId) {
                    $selectedFilterName = $filter['name_filter'];
                    break;
                }
            }
        }
    
        include '../templates/filtered_artworks.php';
    }
    
}
