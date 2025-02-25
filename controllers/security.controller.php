<?php
session_start();
require_once "../model.php";

// Initialiser la variable $error avec une valeur par défaut
$error = "";
$data = loadData();
$_SESSION['clients'] = $data['clients'];
$clients = $_SESSION['clients'];
// dd($_SESSION['user']);
// $_SESSION['user']= "user";
// unset($_SESSION['user']);
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
    if ($page == 'login') { // Utilisation de == pour la comparaison
        // Vérifier si l'utilisateur est déjà connecté*
        if (isset($_SESSION['user'])) {
            redirect('security', 'dashboard');
            exit;
        }

        // Charger les données JSON
        $jsonFilePath = __DIR__ . '/../data/data.json';
        
        if (!file_exists($jsonFilePath)) {
            die("Erreur : Le fichier de données n'existe pas.");
        }

        $jsonData = file_get_contents($jsonFilePath);
        $data = json_decode($jsonData, true) ?? []; // Éviter une erreur si JSON est vide

        // Vérification de la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');   
            if (empty($email) || empty($password)) {
                $error = "Veuillez remplir tous les champs.";
            } else {
                // Parcourir les utilisateurs pour vérifier les identifiants
                foreach ($clients as $client) { 
                    if ($client['email'] == $email  && $client['password'] == $password) {
                        $_SESSION['user'] = $client;
                        // dd($_SESSION['user']); 
                        redirect('security', 'dashboard');
                       $userFound = true;
                    }
                }

                if (!$userFound) {
                    $error = "Email introuvable.";
                }
            }
        }
    }elseif ($page == 'dashboard') {
        // Vérifier si l'utilisateur est connecté
       
            // Si l'utilisateur est connecté, récupérer ses informations
            $user = $_SESSION['user'];
            echo "Bienvenue sur le dashboard, " . $user['email'] . "!"; 
    
    }
}else {
    renderView("security/login.html.php", ['error' => $error], "security");

}