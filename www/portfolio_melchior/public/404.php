<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Non Trouvée</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/styles.css">
    <style>
        body {
    background-color: var(--color-dark-purple);
    color: var(--color-primary);
}

.not-found {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    text-align: center;
}

h1 {
    font-size: 3em;
    margin-bottom: 20px;
}

.btn {
    margin-top: 20px;
    background-color: var(--color-primary);
    color: var(--color-dark-purple);
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 1.2em;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: var(--color-primary);
}

.btn:active {
    background-color: var(--color-primary) !important;
}

    </style>
</head>
<body>
    <div class="not-found">
        <h1>404 - Page Non Trouvée</h1>
        <p>Désolé, la page que vous recherchez n'existe pas.</p>
        <a href="/portfolio_melchior/public/" class="btn btn-primary">Retour à l'accueil</a>
    </div>
</body>
</html>
