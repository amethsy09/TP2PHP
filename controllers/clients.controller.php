<?php

require_once "../orm.php";
require_once "../lib/utile.php";

// Récupération des données
$data=loadData();
// Récupération des données
$tel = isset($_GET['tel']) ? htmlspecialchars(trim($_GET['tel'])) : '';
$clients = !empty($tel) ? getClientByTel($tel) : findAllClients();

$currentPage = isset($_GET['view']) && is_numeric($_GET['view']) ? (int) $_GET['view'] : 1;
$nbrElement = 3;
$clientListe = lister_par_page($clients, $currentPage, $nbrElement);
$nbrPage = recup_nbrdepage($clients, $nbrElement);

if (isset($_GET['page'])) {
    $page = $_GET['page'];

    if ($page == "liste") {
        renderView("client/list.client.html.php", compact('clientListe', 'nbrPage', 'tel', 'currentPage'), "base");
    } elseif ($page == "detail") {
        $clientId = isset($_GET['client_id']) ? (int) $_GET['client_id'] : null;

        if ($clientId) {
            $client = findClientById($clientId);

            if ($client) {
                renderView("client/list.detail.html.php", compact('client'), "base");
            } else {
                echo "Client non trouvé.";
                exit;
            }
        } else {
            echo "ID de client manquant.";
            exit;
        }
    }
} else {
    renderView("client/list.client.html.php", compact('clientListe', 'nbrPage', 'tel', 'currentPage'), "base");
}

