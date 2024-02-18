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

//supprimer une image associer a un article

if(!empty($_GET["id_img"])&&!empty($_GET["id_art"])):
    //suppression depuis le fichier images du serveur
    $query1="select * from images where idImg=:id";
    $pdostmt1=$pdo->prepare($query1); 
    $pdostmt1->execute(["id"=>$_GET["id_img"]]);
    $row=$pdostmt1->fetch(PDO::FETCH_ASSOC);
    //unlink() pour supprimer le fichier correspondant au chemin de l'image stockée dans la base de données
    unlink($row["chemin_img"]);
    $pdostmt1->closeCursor();

    //suppression depuis la base de données
    $query2="delete from images where idImg=:id";
    $pdostmt2=$pdo->prepare($query2); 
    $pdostmt2->execute(["id"=>$_GET["id_img"]]);
    $pdostmt2->closeCursor();

    //redirection vers la meme page
    header("Location:modifierArticle.php?id=".$_GET["id_art"]);
endif;
?>