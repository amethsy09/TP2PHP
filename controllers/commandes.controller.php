<?php
session_start(); // Démarrer la session

// require_once "../model.php";
require_once "../modals/commande.model.php";

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
                    $data = jsonToArray1('commandProduit');
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
        $nomArticle = '';
        // Si un numéro de téléphone est passé dans l'URL, on effectue la recherche
        if (isset($_GET['tel'])) {
            $tel = $_GET['tel'];
            $client = getClientByTel($tel);
            $_SESSION['client'] = $client;
        }
        // Vérifier si une recherche a été effectuée
        $data = jsonToArray1('articles');
        if (isset($_GET['rechercher_article']) && !empty($_GET['article'])) {
            $nomArticle = trim($_GET['article']);
            $_SESSION['articleModifier'] = null;
        }
        // Recherche de l'article dans le tableau
        foreach ($data as $article) {
            if (stripos($article['nom'], $nomArticle) !== false) {
                $_SESSION['articleModifier'] = $article;
                break;
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajoutProduit'])) {
            // Vérification des valeurs du formulaire
            $id = $_POST['id'] ?? null;
            $article = $_POST['article'] ?? null;
            $prix = $_POST['prix'] ?? null;
            $quantite = $_POST['quantite'] ?? null;

            if (!isset($article, $prix, $quantite)) {
                echo "Erreur : Prix, quantité ou article manquant.";
                exit;
            }

            if (!is_numeric($prix) || !is_numeric($quantite)) {
                echo "Erreur : Le prix ou la quantité n'est pas valide.";
                exit;
            }

            // Conversion et calcul du montant
            $prix = (float) $prix;
            $quantite = (int) $quantite;
            $montant = $prix * $quantite;

            // Ajout au panier (session)
            $_SESSION['articles'][] = [
                'id' => $id,
                'article' => $article,
                'prix' => $prix,
                'quantite' => $quantite,
                'montant' => $montant
            ];
        }

        // Calculer le total
        $total = !empty($_SESSION['articles']) ? array_sum(array_column($_SESSION['articles'], 'montant')) : 0;
        $_SESSION['total'] = number_format($total) . ' FCFA';

        // Suppression d'un article
        if (isset($_GET['supprimer'])) {
            $id_to_delete = $_GET['supprimer'];
            unset($_SESSION['articles'][$id_to_delete]);
            $_SESSION['articles'] = array_values($_SESSION['articles']); // Réindexation
            redirect('commandes', 'ajout');
        }

        // Modification d'un article
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modifier_article'])) {
            foreach ($_SESSION['articles'] as &$art) {
                if ($art['id'] == $_POST['id']) {
                    $art['article'] = $_POST['article'];
                    $art['prix'] = $_POST['prix'];
                    $art['quantite'] = $_POST['quantite'];
                    $art['montant'] = (float)$_POST['prix'] * (int)$_POST['quantite'];
                    break;
                }
            }
            redirect('commandes', 'ajout');
        }

        // Commande
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['commander'])) {
            $tel = isset($_POST['tel']) ? trim($_POST['tel']) : '';

            if (empty($tel)) {
                echo "Erreur : Numéro de téléphone manquant.";
                exit;
            }

            // Calcul du montant total
            $montantTotal = array_sum(array_column($_SESSION['articles'], 'montant'));

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

            // Mise à jour des données clients
            $data = findAllClients();
            foreach ($data['clients'] as &$client) {
                if ($client['tel'] == $tel) {
                    $client['commandes'][] = $commande;
                    break;
                }
            }
            saveDataToFile($data);
            redirect('commandes', 'Allcommandes');
        }
    } elseif ($page == "Allcommandes") {
        $Allcommandes = recupToutLesCommandes();
        // Récupérer le contenu de la vue
        $content = ob_get_clean();
        require_once "../views/commande/Allcommandes.html.php";
        if (!isset($_SESSION['clients'])) {
            findAllClients();
        }
    }
}
