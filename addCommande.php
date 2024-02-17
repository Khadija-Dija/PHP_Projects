<?php 
ob_start();
$commande=true;
include_once("header.php");
include_once("main.php");
//recuperer les id des clients
$query="select idClient from client";
$objstmt=$pdo->prepare($query);
$objstmt->execute();

//recuperer les id des articles
$query2="select idArticle from article";
$objstmt2=$pdo->prepare($query2);
$objstmt2->execute();

//verifier si les champs non null
if(!empty($_POST["inputIdClient"])&&!empty($_POST["inputdate"])):
    // prévenir les attaques par injection SQL: on utilise les paramètres nommés(nom,ville,telephone) dans les requêtes préparées
    $query="insert into commande(idClient,date) values (:idclient, :date)";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["idclient"=>$_POST["inputIdClient"], "date"=>$_POST["inputdate"]]);
    //recuperer le dernier id ajouter dans la table commande pour q'uon puisse l'ajouter dans la table ligne_commande
    $idcmd=$pdo->lastInsertId();

    //insertion dans la table ligne_commande
    $query2="insert into ligne_commande(idCommande,idarticle,quantite) values (:idcmd,:idart,:qte)";
    $pdostmt2=$pdo->prepare($query2);
    $pdostmt2->execute(["idcmd"=>$idcmd, "idart"=>$_POST["inputidArt"], "qte"=>$_POST["inputqte"]]);
    //liberer l'objet pdostmt de la memoire apres l'utilisation 
    $pdostmt2->closeCursor();
    //Redirection vers la page commande apres l'insertion
    header("Location:commandes.php"); 
endif;
 ob_end_flush();  
?>
<!-- Begin page content -->

    <h1 class="mt-5">Ajouter une commande</h1>

    <form class="row g-3" method="POST">
    <div class="col-md-6">
        <label for="inputIdClient" class="form-label">ID client</label>
        <select class="form-control" name="inputIdClient" required>
            <?php 
            foreach($objstmt->fetchAll(PDO::FETCH_NUM) as $tabClients){
                foreach($tabClients as $client){
                    echo "<option value=".$client .">".$client ."</option>";
                }
            } 
            ?>
        </select>
    </div>
  <div class="col-md-6">
    <label for="inputdate" class="form-label">Date</label>
    <input type="date" class="form-control" id="inputdate" name="inputdate" required>
  </div>

  <div class="col-md-6">
    <label for="inputidArt" class="form-label">Article</label>
    <select class="form-control" name="inputidArt" required>
            <?php 
            foreach($objstmt2->fetchAll(PDO::FETCH_NUM) as $tabArticles){
                foreach($tabArticles as $article){
                    echo "<option value=".$article .">".$article ."</option>";
                }
            } 
            ?>
        </select>
  </div>
  <div class="col-md-6">
    <label for="inputqte" class="form-label">Quantité</label>
    <input type="number" class="form-control" id="inputqte" name="inputqte" required>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Ajouter</button>
  </div>
</form>
    </div>
</main>

<?php 
include_once("footer.php");
?>    