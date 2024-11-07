<?php

require_once '../src/models/Portfolio.php';

class HomeService
{
    private $portfolio;

    public function __construct()
    {
        $this->portfolio = new Portfolio();
    }

    public function getHomeContent()
    {
        return $this->portfolio->getAllContent();
    }

    public function addContactinfo($name, $email, $subject, $message)
    {
        // Validation des données
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            return "Tous les champs sont requis.";
        }

        return $this->portfolio->addContact($name, $email, $subject, $message);
    }
}
