<?php
define("WEBROOT", "http://mouhamed.sy.ecole221.sn:8000/");
require_once "../orm.php";
// require_once "../modals/client.model.php";
// require_once "../modals/commande.model.php";
require_once "..//config/helpers.php";
$controllers= [
    "client" =>"../controllers/clients.controller.php",
     "commandes" =>"../controllers/commandes.controller.php",
     "security" =>"../controllers/security.controller.php"
];
// require_once isset($_GET['controller']) && array_key_exists($_GET['controller'], $controllers) ? $controllers[$_GET['controller']] : (isset($_GET['controller']) ? $controllers["client"] : $controllers["security"]);
if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
    if (array_key_exists($controller, $controllers)) {
        require_once $controllers[$controller];
    } else {
        // Si le contrôleur n'existe pas, charger le contrôleur  (client)
        require_once $controllers["client"];
    }
} else {
    // Sinon  charger le contrôleur de sécurité
    require_once $controllers["security"];
}