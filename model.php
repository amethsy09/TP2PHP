<?php
// require_once "data.php";
define('DATA_FILE', 'data.json');

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
    $data = loadData();
    // Stocke les clients en session
    $_SESSION['clients'] = $data['clients']; 
    return $_SESSION['clients'];
}function findClientById($id)
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
        if ($client['tel'] == $tel) { // Correction de la clé 'tel'
            return $client;
        }
    }
    return null; // Retourne null si aucun client trouvé
}
// function saveClientsToFile($clients) {
//     $filePath = __DIR__ ."/data.php";
//     $data = "<?php\nreturn " . str_replace("array (", "[", var_export($clients, true));
//     $data = str_replace(")", "]", $data) . ";\n";
//     file_put_contents($filePath,$data);
//   }
function saveClientsToFile($client) {
    $filePath = __DIR__ . "/data.php";
    // On génère un tableau PHP valide en formatant correctement les tableaux imbriqués
    $data = "<?php\n$"."clients =" . var_export($client, true) . ";\n";
    file_put_contents($filePath, $data);
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
    $data = loadData();
    return $data['commandes']; // Retourne toutes les commandes
}

function getAllArticles()
{
    $data = loadData();
    $articles = [];

    foreach ($data['commandProduit'] as $commandeProduit) {
        foreach ($data['articles'] as $article) {
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
function jsonToArray(){
    $json = file_get_contents('data.json');
    $tab = json_decode($json, true)?? [];
    return $tab;
}
function jsonToArray1(string $key=null){
    $json = file_get_contents('data.json');
    $tab = json_decode($json, true)?? [];
    if($key!=null){
        return $tab[$key];
        }
    return $tab;
}
// Fonction pour gérer la déconnexion
function logout() {
    // session_unset();  
    session_destroy();  
    header('Location: connexion.php');
    redirect('security','login');
    exit();
}