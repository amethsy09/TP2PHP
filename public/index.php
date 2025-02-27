<?php
define("WEBROOT", "http://mouhamed.sy.ecole221.sn:8000/");
require_once "../model.php";
require_once "..//config/helpers.php";
$controllers= [
    "client" =>"../controllers/clients.controller.php",
     "commandes" =>"../controllers/commandes.controller.php",
     "security" =>"../controllers/security.controller.php"
];
require_once isset($_GET['controller']) && array_key_exists($_GET['controller'], $controllers) ? $controllers[$_GET['controller']] : (isset($_GET['controller']) ? $controllers["client"] : $controllers["security"]);

// if (isset($_GET['controller'])) {
//     $controller = $_GET['controller'];
//     if (array_key_exists($controller, $controllers)) {
//         require_once $controllers[$controller];
//     }
//     else{
//     require_once $controllers["client"];

// }
// }  else{
//     require_once $controllers["security"];

// }

// if ($controller=="clients") {
    //     require_once "../controllers/clients.controller.php";
   
    // }elseif ($controller=="commandes") {
    //     require_once "../controllers/commandes.controller.php";

    // }
    // elseif ($controller=="security") {
    //     require_once "../controllers/security.controller.php";

    // }