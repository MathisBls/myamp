<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos Projets</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
        }

        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #34495e;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
            transition: background-color 0.3s;
        }

        a {
            text-decoration: none;
            color: #2c3e50;
            font-weight: 600;
        }

        a:hover {
            color: #2980b9;
        }

        .folder-icon {
            margin-right: 10px;
            vertical-align: middle;
        }

        .no-project {
            text-align: center;
            font-size: 1.2em;
            color: #e74c3c;
        }

        .project-form {
            margin-bottom: 20px;
        }

        .project-form input[type="text"] {
            padding: 10px;
            width: 80%;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .project-form button {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .project-form button:hover {
            background-color: #2980b9;
        }

        .phpmyadmin-link {
            display: inline-block;
            margin-top: 10px;
            padding: 10px;
            background-color: #34495e;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .phpmyadmin-link:hover {
            background-color: #2c3e50;
            transition: background-color 0.2s;
            color: white;
        }

        .delete-button {
            padding: 5px 10px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<header>
    <h1>Liste des Projets</h1>
</header>

<div class="container">
    <div class="project-form">
        <form method="POST" action="">
            <input type="text" name="project_name" placeholder="Nom du nouveau projet" required>
            <button type="submit">Créer le Projet</button>
        </form>
    </div>
    <a class="phpmyadmin-link" href="http://localhost/phpmyadmin/index.php">Accéder à phpMyAdmin</a>

    <?php
    // Fonction pour trouver le fichier index.php dans le dossier du projet
    function findIndexInFolder($dir) {
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
        foreach ($rii as $file) {
            if ($file->isFile() && strtolower($file->getFilename()) === 'index.php') {
                return $file->getPathname();
            }
        }
        return null;
    }

    // Fonction pour supprimer un dossier et son contenu
    function deleteDirectory($dir) {
        if (!is_dir($dir)) {
            return;
        }
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? deleteDirectory("$dir/$file") : unlink("$dir/$file");
        }
        rmdir($dir);
    }

    $rootDir = __DIR__;

    // Vérifie si un projet est sélectionné et redirige vers le index.php
    if (isset($_GET['project'])) {
        $projectDir = $rootDir . '/' . basename($_GET['project']);
        $indexFile = findIndexInFolder($projectDir);

        if ($indexFile) {
            header('Location: ' . str_replace($rootDir, '', $indexFile));
            exit;
        } else {
            echo "<div class='no-project'><h2>Aucun fichier 'index.php' trouvé dans le projet sélectionné.</h2></div>";
        }
    }

    // Gestion de la création d'un nouveau projet
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['project_name'])) {
        $projectName = basename($_POST['project_name']);
        $projectDir = $rootDir . '/' . $projectName;

        if (!file_exists($projectDir)) {
            mkdir($projectDir);  // Créer le dossier du projet
            $indexFile = $projectDir . '/index.php';
            // Créer un fichier index.php avec un code par défaut
            file_put_contents($indexFile, "<?php\n\necho 'Bienvenue sur le projet $projectName!';\n?>");
            echo "<div class='no-project'><h2>Projet '$projectName' créé avec succès.</h2></div>";
        } else {
            echo "<div class='no-project'><h2>Le projet '$projectName' existe déjà.</h2></div>";
        }
    }

    // Gestion de la suppression d'un projet
    if (isset($_GET['delete'])) {
        $projectToDelete = basename($_GET['delete']);
        $projectDirToDelete = $rootDir . '/' . $projectToDelete;
        if (is_dir($projectDirToDelete)) {
            deleteDirectory($projectDirToDelete);
            echo "<div class='no-project'><h2>Le projet '$projectToDelete' a été supprimé avec succès.</h2></div>";
        } else {
            echo "<div class='no-project'><h2>Le projet '$projectToDelete' n'existe pas.</h2></div>";
        }
    }

    // Lister les projets existants
    $projects = array_filter(glob('*'), 'is_dir');
    if (!empty($projects)) {
        echo "<table>";
        echo "<thead><tr><th>Projet</th><th>Action</th></tr></thead>";
        echo "<tbody>";
        foreach ($projects as $project) {
            // Vérification pour exclure le dossier phpmyadmin (insensible à la casse)
            if (strcasecmp($project, 'phpmyadmin') !== 0) {
                echo "<tr>
                        <td>
                            <a href=\"?project=" . urlencode($project) . "\">
                                <img class='folder-icon' src='https://img.icons8.com/ios/50/000000/folder-invoices.png' alt='Folder Icon' width='24'>$project
                            </a>
                        </td>
                        <td>
                            <a href=\"?delete=" . urlencode($project) . "\" onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');\">
                                <button class='delete-button'>Supprimer</button>
                            </a>
                        </td>
                      </tr>";
            }
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='no-project'><h2>Aucun projet trouvé.</h2></div>";
    }
    ?>

</div>

<footer>
    <p>&copy; 2024 Projets. Tous droits réservés.</p>
</footer>

</body>
</html>
