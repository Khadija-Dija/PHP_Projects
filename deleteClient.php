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
?>