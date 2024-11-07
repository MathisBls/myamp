<?php

require_once '../config/config.php';

class Portfolio
{

    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function getAllContent()
    {
        $stmt = $this->pdo->query('SELECT * FROM t_content');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //FETCH_ASSOC : retourne un tableau indexé par le nom de la colonne comme retourné dans le jeu de résultats
    }

    public function getAllArtworks()
    {
        $stmt = $this->pdo->query('SELECT * FROM t_artwork');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArtworkById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM t_artwork WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getLastThreeArtworks()
    {
        $stmt = $this->pdo->query('SELECT * FROM t_artwork ORDER BY date DESC LIMIT 3');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFilters()
    {
        $stmt = $this->pdo->query('SELECT * FROM t_filter');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArtworksByFilter($filterId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM t_artwork WHERE filter_id = :filter_id');
        $stmt->execute(['filter_id' => $filterId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addContact($name, $email, $subject, $message)
    {
        $stmt = $this->pdo->prepare('INSERT INTO t_contact (name, email, subject, message) VALUES (:name, :email, :subject, :message)');
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        ]);
        return $stmt->rowCount() > 0;
    }

}
