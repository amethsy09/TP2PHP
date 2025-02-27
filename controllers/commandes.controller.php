<?php
session_start(); // Démarrer la session

require_once "../model.php";
// Gestion de la page 
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
    if ($page == "commandes") {
        ob_start();

        // Charger les données des commandes
        $data = jsonToArray1('commandes');

        // Vérifier si l'ID du client est présent dans la requête GET
        $clientId = isset($_GET['client_id']) ? (int)$_GET['client_id'] : null;

        if ($clientId) {
            // Trouver le client par son ID
            $client = findClientById($clientId);

            if ($client) {
                // Filtrer les commandes par l'ID du client
                $commandes = array_filter($data, function ($commande) use ($clientId) {
                    return $commande['id_client'] == $clientId;
                });

                // Pour chaque commande, on récupère les articles associés
                foreach ($commandes as &$commande) {
                    $commande['articles'] = [];
                    // Chercher les articles associés à cette commande
                    $data=jsonToArray1('commandProduit');
                    foreach ($data as $cmdProduit) {
                        if ($cmdProduit['id_commande'] == $commande['id']) {
                            $article = findArticleById($cmdProduit['id_article']);
                            if ($article) {
                                $commande['articles'][] = [
                                    'nom' => $article['nom'],
                                    'prix' => $article['prix'],
                                    'quantite' => $cmdProduit['quantite'],
                                    'total' => $article['prix'] * $cmdProduit['quantite']
                                ];
                            }
                        }
                    }
                }

                // Charger la vue des commandes
                require_once "../views/commande/list.commandes.html.php";
                
                // Récupérer le contenu de la vue
                $content = ob_get_clean();

                // Charger la mise en page du site
                require_once "../views/layout/base.layout.html.php";
            } else {
                // Client non trouvé
                echo "Client non trouvé.";
                exit;
            }
        } else {
            // ID du client manquant dans la requête
            echo "ID de client manquant.";
            exit;
        }
    } elseif ($page == "ajout") {
        $data = loadData();
        $nom = '';
        $prenom = '';
        $tel = '';

        // Si un numéro de téléphone est passé dans l'URL, on effectue la recherche
        if (isset($_GET['tel'])) {
            $tel = $_GET['tel'];
            $client = getClientByTel($tel);
            $_SESSION['client'] = $client;
        }
        if (!isset($_SESSION['articles'])) {
            $_SESSION['articles'] = [];
        }
        // Recherche d'article)
        if (isset($_GET['rechercher_article'])) {
            $nom_article = $_GET['article'];
            $articleTrouve = findArticleByName($nom_article);

            if ($articleTrouve) {
                $_SESSION['articleModifier'] = $articleTrouve;
            } else {
                echo "Article non trouvé.";
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajouter'])) {
            // Récupérer les valeurs du formulaire
            $id = $_POST['id'] ?? null;
            $article = $_POST['article'];
            $prix_unitaire = $_POST['prix_unitaire'];
            $quantite = $_POST['quantite'];
           if (!empty($_SESSION['tel'])&& isset($_SESSION['tel'] )) {
           $_SESSION['tel'] = $_GET['tel'];
           }
            if (isset($_POST['prix_unitaire']) && isset($_POST['quantite'])) {
                $prix_unitaire = (float) $_POST['prix_unitaire'];
                $quantite = (int) $_POST['quantite'];

                if (is_numeric($prix_unitaire) && is_numeric($quantite)) {
                    $montant = $prix_unitaire * $quantite;
                } else {
                    echo "Erreur : Le prix ou la quantité n'est pas valide.";
                    exit;
                }
            } else {
                echo "Erreur : Prix ou quantité manquants.";
                exit;
            }
            // Calculer le montant
            $prix_unitaire = (float) $_POST['prix_unitaire'];
            $quantite = (int) $_POST['quantite'];
            // Calculer le montant
            $montant = $prix_unitaire * $quantite;

            // Ajouter l'article au tableau de session
            $_SESSION['articles'][] = [
                'id' => $id,
                'article' => $article,
                'prix_unitaire' => $prix_unitaire,
                'quantite' => $quantite,
                'montant' => $montant
            ];
        }
        // calculer le total
        $total = array_sum(array_column($_SESSION['articles'], 'montant'));
        number_format($total) . ' FCFA';
        $_SESSION['total'] = $total;

        if (isset($_GET['supprimer'])) {
            $id_to_delete = $_GET['supprimer'];
            unset($_SESSION['articles'][$id_to_delete]);
            $_SESSION['articles'] = array_values($_SESSION['articles']);
            redirect('commandes', 'ajout');
        }
        // recuperation de l'id
        if (isset($_GET['modifier'])) {
            $idModifier = $_GET['modifier'];
            foreach ($_SESSION['articles'] as $art) {
                if ($art['id'] == $idModifier) {
                    $articleModifier = $art;
                    break;
                }
            }
        }
        // je met a jour l'article a modifier 
        if (isset($_POST['modifier_article'])) {
            foreach ($_SESSION['articles'] as &$art) {
                if ($art['id'] == $_POST['id']) {
                    $art['article'] = $_POST['article'];
                    $art['prix_unitaire'] = $_POST['prix_unitaire'];
                    $art['quantite'] = $_POST['quantite'];
                    break;
                }
            }
            redirect('commandes', 'ajout');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['commander'])) {

            $tel = isset($_POST['tel']) ? trim($_POST['tel']) : '';
            if (empty($tel)) {
                echo "Erreur : Numéro de téléphone manquant.";
                exit;
            }


            // Calcul du montant total
            $montantTotal = 0;
            if (!empty($_SESSION['articles'])) {
                foreach ($_SESSION['articles'] as $article) {
                    $montantTotal += $article['prix_unitaire'] * $article['quantite'];
                }
            }
            // recuperation de l'id
            $idCommande = uniqid();
            $commande = [
                'id' => $idCommande,
                'tel' => $tel,
                'montant' => $montantTotal,
                'statut' => 'En attente',
                'date' => date('Y-m-d H:i:s'),
                'articles' => $_SESSION['articles'],
            ];
            $_SESSION['commandes'][$tel][] = $commande;
            $data = findAllClients();
            foreach ($data as $key => $value) {
                if ($value['telephone'] == $tel) {
                    $data[$key]['commandes'][] = $commande;
                    saveDataToFile($data);
                    break;
                }
            }
            redirect('commandes', 'Allcommandes');
        }
        // $Allcommandes = $_SESSION['commandes'] ?? [];

        require_once "../views/commande/form.commande.html.php";
    } elseif ($page == "Allcommandes") {
        $Allcommandes = recupToutLesCommandes();
        if (!empty($Allcommandes)) {
            renderView("commande/Allcommandes.html.php", compact('Allcommandes'), "base");
        } else {
            echo "Aucune commande trouvée.";
        }
    }
    // require_once "../views/commande/Allcommandes.html.php";
}
