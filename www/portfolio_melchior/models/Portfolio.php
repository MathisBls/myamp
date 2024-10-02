<?php

require_once '../config/config.php';

class Portfolio {

private $pdo;

public function __construct()
{
    global $pdo;
    $this->pdo = $pdo;
}

}

?>
