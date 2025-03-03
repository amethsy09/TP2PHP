<?php
function renderView(string $view,array $datas=[], string $layout="base"){
    ob_start();
    extract($datas);
    require_once "../views/$view";
    $content = ob_get_clean();
    require_once "../views/layout/$layout.layout.html.php";
}
function redirect($controller, $page) {
    if (defined('WEBROOT')) {
        header('Location: ' . WEBROOT . '?controller=' .($controller) . '&page='.($page));
        exit;
    } else {
        echo "Erreur : La constante WEBROOT n'est pas définie.";
    }
}
function dd($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die(); // Arrête l'exécution du script
}
function logout() {
    unset($_SESSION['user']);
    session_destroy();  
    renderView("security/login.html.php", [], "security");
    exit();
}