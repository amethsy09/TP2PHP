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
    $dataString = "<?php\n";
    foreach ($data as $key => $value) {
        $dataString .= "\$$key = " . var_export($value, true) . ";\n";
    }

    // Sauvegarde dans le fichier
    file_put_contents($filePath, $dataString);
}


// // fonction dump die
// function dd($var) {
//     echo '<pre>';
//     var_dump($var);
//     echo '</pre>';
//     die(); // Arrête l'exécution du script
// }


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
function jsonToArray1(string $key=null){
    $json = file_get_contents('../data/data.json');
    $tab = json_decode($json, true)?? [];
    if($key!=null){
        return $tab[$key];
        }
    return $tab;
}
// Fonction pour gérer la déconnexion
// function logout() {
//     unset($_SESSION['user']);
//     session_destroy();  
//     renderView("security/login.html.php", [], "security");
//     exit();
// }
