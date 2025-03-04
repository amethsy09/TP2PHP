<?php
require_once "client.model.php";
// require_once "./config/helpers.php";
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
function searchProduit(): void
{
    unset($_SESSION["articles"]);

    if (!isset($_POST['nom']) || empty($_POST['nom'])) {
        addToSession("errorProduit", "Veuillez entrer un nom de produit.");
        redirect("commande", ["page" => "ajout"]);
        return;
    }

    $nom = trim($_POST['nom']);  // Suppression des espaces inutiles
    unset($_POST['nom'], $_POST['controller'], $_POST['page']);

    $produit = findArticleByName($nom);

    if ($produit === null) {
        addToSession("errorProduit", "Le produit n'existe pas");
    } else {
        unset($_SESSION["errorProduit"]);
        addToSession("article", $produit);

        $verif = isProduitExist(getFromSession("article", "nom"));
        if ($verif !== null && $verif !== false) { // Vérifie bien l'existence
            $_SESSION["article"]["quantite_stock"] -= $_SESSION["articles"][$verif]["quantite"];
        }
    }

    redirect("commandes", ["page" => "ajout"]);
}

function ajoutProduit():void{
    $verif = isProduitExist(getFromSession("produit","nom"));
    if ($verif === null) {
        $newArticle = [
            "id" =>getFromSession("produit","id"),
            "article" => getFromSession("produit","nom"),
            "prix" => getFromSession("produit","prix"),
            "quantite" => $_POST["quantite"],
            "montant" => $_POST["quantite"] * getFromSession("produit","prix")
        ];
        $_SESSION["articles"][] = $newArticle;
        unset($_SESSION["produit"]);
    } else {
        $_SESSION["articles"][$verif]["quantite"] += $_POST["quantite"];
        $_SESSION["articles"][$verif]["montant"] += $_POST["quantite"] * getFromSession("produit","prix");
        unset($_SESSION["produit"]);
    }
    $_SESSION["montant"] = montantTotal();
    redirect("commandes","ajout");

}

function removeArticle(): void{
    unset($_SESSION["articles"][$_POST["index"]]);
    $_SESSION["montantTotal"] = montantTotal();
   redirect("commandes","ajout");
}

function ajoutCommande():void{
    $id=getId("commandes");
    $commande = [
        "id"=>$id,
        "client_id" => intval(getFromSession("client","id")) ,
        "montant" => getFromSession("montantTotal"),
        "date" => date("Y-m-d"),
        "status"=>"impayer"
    ];
    addCommande($commande);
    foreach ($_SESSION["articles"] as $produit) {
        $newCM=[
            "commande_id"=>$id,
            "produit_id"=>$produit["id"],
            "quantite"=>intval($produit["quantite"])
        ];
        addCommandeProduit($newCM);
        updateQte($produit["id"],intval($produit["quantite"]));
    }

     unset($_SESSION["client"], $_SESSION["montantTotal"], $_SESSION["articles"], $_SESSION["produit"]);
     redirect("commandes","liste");
}
function addToSession(string $key,mixed $value):void{
    $_SESSION[$key]=$value;
}
function getFromSession(string $key,$key2=null):mixed{
    return $key2==null?$_SESSION[$key]:$_SESSION[$key][$key2];
}
function addCommande(array $commande):void{
    arrayToJson("commandes", $commande);
  }
 function addCommandeProduit(array $commandeP):void{
    arrayToJson("commandProduit", $commandeP);
  }
  function isProduitExist(string $nom): int|null
{
    foreach ($_SESSION["articles"] as $key => $value) {
        if ($value["article"] == $nom) {
            return $key;
        }
    }
    return null;
}
function arrayToJson(string $key, array $val):void{
    $datas=jsonToArray1();
    $datas[$key][]=$val;
    $json=json_encode($datas);
    file_put_contents("../data/data.json",$json);
  }
  function arrayToJsonUpdate(string $key, array $val):void{
    $datas=jsonToArray1();
    $datas[$key]=$val;
    $json=json_encode($datas);
    file_put_contents("../data/data.json",$json);
  }
  
function getId(string $key):int{
    return count(jsonToArray1($key)) + rand(30,365) ;
 }
 function updateQte($id,$quantite){
    $produits=getAllArticles();
    foreach ($produits as $key => $produit) {
        if ($produit['id'] == $id) {
            $produits[$key]['quantite_stock'] -= $quantite;
            break;
        }
    }
    arrayToJsonUpdate("produits",$produits);

}
function montantTotal(): int
{
    $total = 0;
    foreach ($_SESSION["articles"] as $article) {
        $total += $article["montant"];
    }
    return $total;
}