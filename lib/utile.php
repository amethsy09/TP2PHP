<?php
function lister_par_page(array $liste,int $page,int $nbrElement){
    $startIndex= ($page -1) * $nbrElement;
    return array_slice($liste, $startIndex,$nbrElement);
}
function recup_nbrdepage(array $liste,int $nbrElement){
return  (int)ceil(count($liste)/$nbrElement);
}