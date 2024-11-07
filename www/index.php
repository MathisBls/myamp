<?php

$rootDir = __DIR__;

if (isset($_GET['project'])) {
    $projectDir = $rootDir . '/' . basename($_GET['project']);
    $indexFile = findIndexInFolder($projectDir);

    if ($indexFile) {
        $redirectUrl = str_replace($rootDir, '', $indexFile);
    } else {
    }
}

if (isset($redirectUrl)) {
    header('Location: ' . $redirectUrl);
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon_io/favicon.ico" type="image/x-icon">
    <title>MyAMP</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: var(--header-bg);
            color: white;
        }

        h1 {
            margin: 0;
            text-align: center;
        }

        footer {
            background-color: var(--header-bg);
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
            background-color: var(--th-bg);
            color: white;
        }

        tr:hover {
            background-color: var(--tr-hover-bg);
            transition: background-color 0.3s;
        }

        a {
            text-decoration: none;
            color: var(--link-color);
            font-weight: 600;
        }

        a:hover {
            color: #2980b9;
        }

        .folder-icon {
            margin-right: 10px;
            vertical-align: middle;
            filter: var(--folder-icon-color);
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
            background-color: var(--button-bg);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .project-form button:hover {
            background-color: var(--button-bg-hover);
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
            color: #34495e;
            border: 2px solid #34495e;
            cursor: pointer;
            font-weight: 600;
            background-color: white;
            transition: background-color 0.3s, color 0.3s;
        }

        .delete-button:hover {
            background-color: #34495e;
            color: white;
            transition: background-color 0.3s, color 0.3s;
        }

        body.dark .delete-button {
            color: white;
            border-color: rgb(255, 30, 70);
            background-color: rgb(32, 30, 45);
        }

        body.dark .delete-button:hover {
            background-color: rgb(255, 30, 70);
        }

        .theme-switch {
            cursor: pointer;
            background-color: transparent;
            border: 2px solid white;
            color: white;
            padding: 10px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
            position: absolute;
            right: 20px;
        }

        .theme-switch:hover {
            background-color: white;
            color: var(--header-bg);
        }

        body.dark .phpmyadmin-link {
            background-color: rgb(255, 30, 70);
        }

        body.dark .phpmyadmin-link:hover {
            background-color: rgb(200, 25, 60);
        }

        /* Default (light theme) variables */
        :root {
            --header-bg: #2c3e50;
            --th-bg: #34495e;
            --tr-hover-bg: #f1f1f1;
            --folder-icon-color: none;
            --link-color: #2c3e50;
            --button-bg: #3498db;
            --button-bg-hover: #2980b9;
        }

        /* Dark theme variables */
        body.dark {
            background-color: rgb(32, 30, 45);
            color: white;
        }

        body.dark .container {
            background-color: rgb(32, 30, 45);
            color: white;
        }

        body.dark a {
            color: white;
        }

        body.dark th {
            background-color: rgb(255, 30, 70);
        }

        body.dark tr:hover {
            background-color: rgb(40, 37, 54);
        }

        body.dark .folder-icon {
            filter: invert(44%) sepia(77%) saturate(7474%) hue-rotate(329deg) brightness(99%) contrast(109%);
        }

        body.dark .theme-switch {
            border-color: rgb(255, 30, 70);
        }

        body.dark .theme-switch:hover {
            color: rgb(255, 30, 70);
            background-color: rgb(40, 37, 54);
        }

        body.dark .project-form button {
            background-color: rgb(255, 30, 70);
        }

        body.dark .project-form button:hover {
            background-color: rgb(200, 25, 60);
        }

        body.dark footer, body.dark header {
            background-color: rgb(11, 7, 17);
        }

    </style>
</head>
<body>

<header>
    <h1>Your projects</h1>
    <button class="theme-switch" onclick="switchTheme()">Switch Theme</button>
</header>

<div class="container">
    <div class="project-form">
        <form method="POST" action="">
            <input type="text" name="project_name" placeholder="Myproject..." required>
            <button type="submit">Create project</button>
        </form>
    </div>
    <a class="phpmyadmin-link" href="http://localhost/phpmyadmin/index.php" target="_blank">Access phpMyAdmin</a>

    <?php
    function findIndexInFolder($dir) {
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
        foreach ($rii as $file) {
            if ($file->isFile() && strtolower($file->getFilename()) === 'index.php') {
                return $file->getPathname();
            }
        }
        return null;
    }

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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['project_name'])) {
        $projectName = basename($_POST['project_name']);
        $projectDir = $rootDir . '/' . $projectName;

        if (!file_exists($projectDir)) {
            mkdir($projectDir);
            $indexFile = $projectDir . '/index.php';
            $metaTags = <<<EOT
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Welcome to $projectName!">
    <meta name="keywords" content="$projectName, project, example">
    <meta name="author" content="Your Name">
    <title>$projectName</title>
</head>
<body>
    <h1>Welcome to $projectName!</h1>
</body>
</html>
EOT;

            file_put_contents($indexFile, $metaTags);
            echo "<div class='no-project'><h2>Project '$projectName' created successfully.</h2></div>";
        } else {
            echo "<div class='no-project'><h2>The project '$projectName' already exists.</h2></div>";
        }
    }

    if (isset($_GET['delete'])) {
        $projectToDelete = basename($_GET['delete']);
        $projectDirToDelete = $rootDir . '/' . $projectToDelete;
        if (is_dir($projectDirToDelete)) {
            deleteDirectory($projectDirToDelete);
            echo "<div class='no-project'><h2>The project '$projectToDelete' has been deleted successfully.</h2></div>";
        } else {
            echo "<div class='no-project'><h2>The project '$projectToDelete' does not exist.</h2></div>";
        }
    }

    $projects = array_filter(glob('*'), 'is_dir');
    if (!empty($projects)) {
        echo "<table>";
        echo "<thead><tr><th>Project</th><th>Action</th></tr></thead>";
        echo "<tbody>";
        foreach ($projects as $project) {
            if (strcasecmp($project, 'phpmyadmin') !== 0 && strcasecmp($project, 'favicon_io') !== 0) {
                echo "<tr>
                        <td>
                            <a href=\"?project=" . urlencode($project) . "\">
                                <img class='folder-icon' src='https://img.icons8.com/ios/50/000000/folder-invoices.png' alt='Folder Icon' width='24'>$project
                            </a>
                        </td>
                        <td>
                            <a href=\"?delete=" . urlencode($project) . "\" onclick=\"return confirm('Are you sure you want to delete this project?')\">
                                <button class='delete-button'>Delete</button>
                            </a>
                        </td>
                      </tr>";
            }
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='no-project'><h2>No projects found.</h2></div>";
    }
    ?>

</div>

<footer>
    <p>&copy; 2024 Projets. All rights reserved.</p>
</footer>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark');
        }
    });

    function switchTheme() {
        document.body.classList.toggle('dark');

        if (document.body.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    }
</script>

</body>
</html>
