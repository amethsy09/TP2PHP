<?php
require_once "client.model.php";
function recupToutLesCommandes()
{
    $data = jsonToArray1('commandes');
    return $data; // Retourne toutes les commandes
}

function getAllArticles()
{
    $data = jsonToArray1('articles'); 
    $articles = [];

    if (!isset($data['articles'], $data['commandProduit'])) {
        return []; 
    }

    foreach ($data['commandProduit'] as $commandeProduit) {
        foreach ($data['articles'] as $article) {
            if ((int) $commandeProduit['id_article'] === (int) $article['id']) {
                $articles[] = [
                    'nom' => $article['nom'],
                    'prix_unitaire' => (int) $article['prix'],  
                    'quantite' => (int) $commandeProduit['quantite'] 
                ];
                break; 
            }
        }
    }

    return $articles;
}


function findArticleByName($nom)
{
    $nom = trim($nom); 
    if (empty($nom)) return null;
    $articles = jsonToArray1('articles');
    foreach ($articles as $article) {
        if (stripos($article['nom'], $nom) !== false) {
            return $article;
        }
    }
    return null;
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
function findCommandeByClientTel(){
    
}