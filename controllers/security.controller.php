<?php
session_start();
require_once "../orm.php";
$error = "";
$data = loadData();
$_SESSION['clients'] = $data['clients'];
$clients = $_SESSION['clients'];
// dd($_SESSION['user']);
// $_SESSION['user']= "user";
// unset($_SESSION['user']);
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
    if ($page == 'login') {
                
    
    
        // Vérification de la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');   
    
            if (empty($email) || empty($password)) {
                $error = "Veuillez remplir tous les champs.";
            } else {
                $userFound = false;
                foreach ($_SESSION['clients'] as $client) { 
                    if ($client['email'] === $email && $client['password'] === $password) {
                        $_SESSION['user'] = $client;
                        redirect('security', 'dashboard');
                        break;
                        $userFound = true;
                    }
                }
    
                if (!$userFound) {
                    $error = "Email ou mot de passe incorrect.";
                }
            }
        }
    } elseif ($page == 'dashboard') {
        // Vérifier si l'utilisateur est connecté et afficher ses informations
        if (isset($_SESSION['user'])) {
            renderView("security/dashboard.html.php", ['Dashboard' => $_SESSION['user']], "security");
        } else {
            redirect('security', 'login'); // Rediriger vers la page de login si l'utilisateur n'est pas connecté
        }
    }
    elseif ($page == 'logout') {
       // Supprimer la session utilisateur
       logout();
    //    redirect('security','login');
}
}else {
    renderView("security/login.html.php", ['error' => $error], "security");

} 