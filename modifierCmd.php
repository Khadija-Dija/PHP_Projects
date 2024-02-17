<?php

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
    $commande=true;
    include_once("header.php");
    include_once("main.php");

    $query="select idClient from client";
    $mon_objstmt=$pdo->prepare($query);
    $mon_objstmt->execute();

    $query2="select idArticle from article";
    $objstmt2=$pdo->prepare($query2);
    $objstmt2->execute();

    if(!empty($_POST["inputqte"])&&!empty($_POST["inputdate"])){
        $query="update commande set idClient=:idcl,date=:date where idCmd=:idcmd";
        $pdostmt=$pdo->prepare($query);
        $pdostmt->execute(["idcl"=>$_POST["inputidcl"],"date"=>$_POST["inputdate"],"idcmd"=>$_POST["cmd_id"]]);
      
        $query2="update ligne_commande set idarticle=:idart,idCommande=:idcmd,quantite=:quant where idCommande=:idcmd";
        $pdostmt2=$pdo->prepare($query2);
        $pdostmt2->execute(["idart"=>$_POST["inputidarticle"],"idcmd"=>$_POST["cmd_id"],"quant"=>$_POST["inputqte"]]);
        $pdostmt2->closeCursor();
        header("Location:commandes.php");
    }

    if(!empty($_GET["idcmd"])){
        
      $idcmd= `echo $_GET[idcmd]`;
    //   echo $idcmd;
      $query="select * from commande,ligne_commande where ligne_commande.idCommande=commande.idCmd and commande.idCmd=:id_Cmd";
     // $query_cmd = "SELECT * FROM commande WHERE idCmd = :id_Cmd";
     // $query_ligne_cmd="SELECT * FROM ligne_commande WHERE idCommande = :id_Cmd";
      $objstmt=$pdo->prepare($query);
      $objstmt->execute(["id_Cmd"=>$idcmd]);
      $row=$objstmt->fetch(PDO::FETCH_ASSOC);
        // var_dump($row);
   
?>
<h1 class="mt-5">Modifier une commande</h1>
<form class="row g-3" method="POST">
  <input type="hidden" name="cmd_id" value="<?php echo $_GET["idcmd"] ?>"/>
  <div class="col-md-6">
    <label for="inputidcl" class="form-label">ID client</label>
    <select class="form-control" name="inputidcl" required >
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
    <label for="inputdate" class="form-label">Date</label>
    <input type="date" class="form-control" id="inputdate" name="inputdate" value="<?php echo $row["date"]?>" required>
  </div>
  <div class="col-md-6">
    <label for="inputidarticle" class="form-label">Article</label>
    <select class="form-control" name="inputidarticle" required >
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
    <input type="number" class="form-control" id="inputqte" name="inputqte" value="<?php echo $row["quantite"]?>" required>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Modifier</button>
  </div>
</form>
</div>
</main>

<?php

ob_end_flush(); 
    }
    include_once("footer.php");
?>