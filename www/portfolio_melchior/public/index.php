<?php
session_start();

foreach (glob('../src/controllers/*.php') as $controllerFile) {
    require_once $controllerFile;
}

$route = isset($_GET['route']) ? $_GET['route'] : 'home';

switch ($route) {
    case 'home':
        $controller = new HomeController();
        break;

    case 'oeuvre':
        $controller = new OeuvreController();
        break;

    case 'filtered_artworks':
        $controller = new FilteredArtworksController();
        break;

    case 'sendMail':
        include '../templates/send_mail.php';
        exit;
        break;

    default:
        http_response_code(404);
        include '404.php';
        exit;
}

if (isset($controller)) {
    $controller->index();
}

include '../templates/components/footer.php';

?>
