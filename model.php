<?php
// require_once "data.php";
define('DATA_FILE', '../data/data.json');

// les fonctions
function loadData()
{
    $jsonData = file_get_contents("../data/data.json"); 
    return json_decode($jsonData, true);
}
function saveData($data)
{
    file_put_contents("../data.json", json_encode($data, JSON_PRETTY_PRINT));
}
function findAllClients()
{ 
    $clients = jsonToArray1('clients');
    $_SESSION['clients'] = $clients; 
    return $_SESSION['clients'];
}
function findClientById($id)
{
    $clients = findAllClients();
    $client = null;
    foreach ($clients as $client) {
        if ($client['id'] == $id) {
            return $client;
        }
    }
    return null;
}

function getClientByTel($tel)
{
    $clients = findAllClients();
    foreach ($clients as $client) {
        if ($client['tel'] == $tel) { 
            return $client;
        }
    }
    return null; // 
}
function saveDataToFile($data) {
    $filePath = __DIR__ . "/data.php";

    // Formatage des données pour générer un tableau PHP valide à partir des données JSON
    $dataString = "<?php\n";
    foreach ($data as $key => $value) {
        $dataString .= "\$$key = " . var_export($value, true) . ";\n";
    }

    // Sauvegarde dans le fichier
    file_put_contents($filePath, $dataString);
}


// fonction dump die
function dd($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die(); // Arrête l'exécution du script
}


// affichage

function afficherclient($client)
{
    echo "Nom : " . $client["nom"] . "\n";
    echo "Prénom : " . $client["prenom"] . "\n";
    echo "Téléphone : " . $client["telephone"] . "\n";
    echo "---------------------------\n";
}
function afficherClients()
{
    $clients = findAllClients();
    foreach ($clients as $client) {
        afficherClient($client);
    }
}
function recupToutLesCommandes()
{
    $data = jsonToArray1('commandes');
    return $data['commandes']; // Retourne toutes les commandes
}

function getAllArticles()
{
    $data = jsonToArray1('articles');
    $articles = [];

    foreach ($data['commandProduit'] as $commandeProduit) {
        foreach ($data as $article) {
            if ($commandeProduit['id_article'] == $article['id']) {
                $articles[] = [
                    'nom' => $article['nom'],
                    'prix_unitaire' => $article['prix'],
                    'quantite' => $commandeProduit['quantite']
                ];
            }
        }
    }
    return $articles;
}

function findArticleByName($nom)
{
    $articles = getAllArticles();
    foreach ($articles as $article) {
        if (stripos($article['nom'], $nom) !== false) {
            return $article;
        }
    }
    return null;
}

function jsonToArray1(string $key=null){
    $json = file_get_contents('../data/data.json');
    $tab = json_decode($json, true)?? [];
    if($key!=null){
        return $tab[$key];
        }
    return $tab;
}
// Fonction pour gérer la déconnexion
function logout() {
    unset($_SESSION['user']);
    session_destroy();  
    renderView("security/login.html.php", [], "security");
    exit();
}
function findArticleById($id) {
    $articles = jsonToArray1('articles');
    foreach ($articles as $article) {
        if ($article['id'] == $id) {
            return $article;
        }
    }
    return null;
}