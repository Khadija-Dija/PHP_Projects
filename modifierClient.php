<?php 
ob_start();
include_once("header.php");
include_once("main.php");
$client=true;
//verifier si les champs non null
if(!empty($_GET["id"])){
    //recuperer le client qu'on souhaite modifier 
    $query="select * from client where idClient=:id";
    $pdostmt=$pdo->prepare($query);
    
    $pdostmt->execute(["id"=>$_GET["id"]]);
    while($row=$pdostmt->fetch(PDO::FETCH_ASSOC)):
 
?>
<!-- Begin page content -->

    <h1 class="mt-5">Modifier un client</h1>

    <form class="row g-3" method="POST">
    <input type="hidden" name="myId" value=<?php echo $row["idClient"] ?>>
  <div class="col-md-6">
    <label for="inputnom" class="form-label">Nom</label>
    <input type="text" class="form-control" id="inputnom" name="inputnom" value="<?php echo $row["nom"] ?>" required>
  </div>
  <div class="col-md-6">
    <label for="inputville" class="form-label">Ville</label>
    <input type="text" class="form-control" id="inputville" name="inputville" value="<?php echo $row["ville"] ?>" required>
  </div>
  <div class="col-12">
    <label for="inputtel" class="form-label">Telephone</label>
    <input type="text" class="form-control" id="inputtel" name="inputtel" value="<?php echo $row["num_tele"] ?>" required>
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary">Modifer</button>
  </div>
</form>


    </div>
</main>
<?php 
endwhile;
   //liberer l'objet pdostmt de la memoire apres l'utilisation 
    $pdostmt->closeCursor();
   
}
//2 eme requete pour modifer les champs (pour recuperer l'id on a utiliser le champs input de type hidden)
if(!empty($_POST)){
    $query="update client set nom=:nom, ville=:ville, num_tele=:tel  where idClient=:id";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["nom"=>$_POST["inputnom"], "ville"=>$_POST["inputville"], "tel"=>$_POST["inputtel"],"id"=>$_POST["myId"]]);
    //Redirection vers la page client apres l'insertion
    header("Location:clients.php"); 
}
ob_end_flush(); 
?>
<?php 
include_once("footer.php");
?>    