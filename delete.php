<?php 
include_once("main.php");
//verifier si l'id est non null (ou cas ou on a pas passer par le lien)
if(!empty($_GET["id"])):

    $query="delete from client where idClient=:id";
    
    $pdostmt=$pdo->prepare($query);
    
    $pdostmt->execute(["id"=>$_GET["id"]]);
   
    //liberer l'objet pdostmt de la memoire apres l'utilisation 
    $pdostmt->closeCursor();

    //redirection vers clients.php
    header("Location:clients.php");
endif;
if(!empty($_GET["idarticle"])):

    $query="delete from article where idArticle=:idarticle";
    
    $pdostmt=$pdo->prepare($query);
    
    $pdostmt->execute(["idarticle"=>$_GET["idarticle"]]);
   
    //liberer l'objet pdostmt de la memoire apres l'utilisation 
    $pdostmt->closeCursor();

    //redirection vers articles.php
    header("Location:articles.php");
endif;
if(!empty($_GET["idcmd"])):
    //supprimer la commande de la ligne_commande(forenkey)
    $query="delete from ligne_commande where idCommande=:id";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["id"=>$_GET["idcmd"]]);
    $pdostmt->closeCursor();

    //supprimer la commande de la table commande
    $query2="delete from commande where idCmd=:id";
    $pdostmt2=$pdo->prepare($query2);
    $pdostmt2->execute(["id"=>$_GET["idcmd"]]);
    //liberer l'objet pdostmt de la memoire apres l'utilisation 
    $pdostmt2->closeCursor();

    //redirection vers articles.php
    header("Location:commandes.php");
endif;
?>