<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/styles.css">
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Della+Respira&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Melchior Portfolio</title>
</head>

<header class="background-header font-family-della-respira font-weight-regular container-fluid">
<nav class="navbar navbar-expand-lg navbar-dark p-3">
        <a class="navbar-brand text-white mx-5 fs-5 font-weight-regular titre-header" href="/portfolio_melchior/public/">Melchior</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
        <li class="nav-item mt-3 mt-lg-0">
            <a class="text-white mx-5" href="/portfolio_melchior/public/index.php#biography">Biographie</a>
        </li>
        <li class="nav-item mt-3 mt-lg-0">
            <a class="text-white mx-5" href="/portfolio_melchior/public/index.php#mes-oeuvres">Mes oeuvres</a>
        </li>
        <li class="nav-item mt-3 mt-lg-0">
            <a class="text-white mx-5" href="/portfolio_melchior/public/index.php#contact">Me contacter</a>
        </li>
    </ul>

        </div>
    </nav>
    <div class="d-flex align-items-center justify-content-center h-100">
        <div class="text-center text-white textHeader">
            <h1 id="main-name"><?= $content[0]['main_name']; ?></h1>
        </div>
    </div>
</header>
<script src="../public/js/script.js"></script>

