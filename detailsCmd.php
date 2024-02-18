<?php

ob_start();
    $index=true;
    include_once("header.php");
    include_once("main.php");

    $query="select idClient from client";
    $mon_objstmt=$pdo->prepare($query);
    $mon_objstmt->execute();

    $query2="select idArticle from article";
    $objstmt2=$pdo->prepare($query2);
    $objstmt2->execute();

 

    if(!empty($_GET["idcmd"])){
        
      $idcmd= `echo $_GET[idcmd]`;
    //   echo $idcmd;
      $query="select * from commande,ligne_commande, client where commande.idClient=client.idClient and ligne_commande.idCommande=commande.idCmd and commande.idCmd=:id_Cmd";
     // $query_cmd = "SELECT * FROM commande WHERE idCmd = :id_Cmd";
     // $query_ligne_cmd="SELECT * FROM ligne_commande WHERE idCommande = :id_Cmd";
    $objstmt=$pdo->prepare($query);
    $objstmt->execute(["id_Cmd"=>$idcmd]);
    $row=$objstmt->fetch(PDO::FETCH_ASSOC);
        // var_dump($row);
        
      //modifier les nombre de vues
    $query_vues="update commande set vues=:views where idCmd=:idcmd";
    $objstmt_vues=$pdo->prepare($query_vues);
    $objstmt_vues->execute(["idcmd"=>$idcmd,"views"=>$row["vues"]+1]);

     //afficher le nombre de vue qui a etait incrementer depuis la table commande
     $query_vues_select="select * from commande where idCmd=:idcmd";
     $objstmt_vues_select=$pdo->prepare($query_vues_select);
     $objstmt_vues_select->execute(["idcmd"=>$idcmd]);
    $row_selected=$objstmt_vues_select->fetch(PDO::FETCH_ASSOC);

?>
    <div style="float:right; color:blue;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
        </svg>
        <?php echo $row_selected["vues"] ?>
    </div>
    <h1 class="mt-5">Details de la commande</h1>
    <form class="row g-3" method="">

    <div class="col-md-6">
        <label for="inputidcl" class="form-label">ID client</label>
        <select class="form-control" name="inputidcl" disabled >
            <?php 
            foreach($mon_objstmt->fetchAll(PDO::FETCH_NUM) as $tab){
                foreach($tab as $elmt){
                    if($elmt==$row["idClient"]){
                    $selected="selected";
                    }else{
                    $selected="";
                    }
                    echo "<option value=".$elmt." ".$selected.">".$elmt."</option>";
                }
            }   
            ?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="inputnom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="inputnom" name="inputnom" value="<?php echo $row["nom"]?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="inputville" class="form-label">Ville</label>
        <input type="text" class="form-control" id="inputville" name="inputville" value="<?php echo $row["ville"]?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="inputtel" class="form-label">Telephone</label>
        <input type="text" class="form-control" id="inputtel" name="inputtel" value="<?php echo $row["num_tele"]?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="inputdate" class="form-label">Date</label>
        <input type="date" class="form-control" id="inputdate" name="inputdate" value="<?php echo $row["date"]?>" disabled>
    </div>
    <div class="col-md-6">
        <label for="inputidarticle" class="form-label">Article</label>
        <select class="form-control" name="inputidarticle" disabled >
            <?php 
            foreach($objstmt2->fetchAll(PDO::FETCH_NUM) as $tab){
                foreach($tab as $elmt){
                if($elmt==$row["idarticle"]){
                    $selected="selected";
                }else{
                    $selected="";
                }
                echo "<option value=".$elmt." ".$selected.">".$elmt."</option>";
                }
            }   
            ?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="inputqte" class="form-label">Quantité</label>
        <input type="number" class="form-control" id="inputqte" name="inputqte" value="<?php echo $row["quantite"]?>" disabled>
    </div>

    <div class="col-12">
        <a href="index.php" type="submit" class="btn btn-primary">Fermer</a>
    </div>
    </form>
</div>
</main>

<?php
 }
  
    $mon_objstmt->closeCursor();  
    $objstmt2->closeCursor();
    $objstmt->closeCursor();
    $objstmt_vues->closeCursor();
    $objstmt_vues_select->closeCursor();
    ob_end_flush();
    
    include_once("footer.php");
?>