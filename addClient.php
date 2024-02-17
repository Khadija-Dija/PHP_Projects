<?php 
ob_start();
include_once("header.php");
include_once("main.php");
$client=true;
//verifier si les champs non null
if(!empty($_POST["inputnom"])&&!empty($_POST["inputville"])&&!empty($_POST["inputtel"])):
    // prévenir les attaques par injection SQL: on utilise les paramètres nommés(nom,ville,telephone) dans les requêtes préparées
    $query="insert into client(nom,ville,num_tele) values (:nom, :ville, :telephone)";
    
    $pdostmt=$pdo->prepare($query);
    
    $pdostmt->execute(["nom"=>$_POST["inputnom"], "ville"=>$_POST["inputville"], "telephone"=>$_POST["inputtel"]]);
   
    //liberer l'objet pdostmt de la memoire apres l'utilisation 
    $pdostmt->closeCursor();
    //Redirection vers la page client apres l'insertion
    header("Location:clients.php"); 
endif;
 ob_end_flush();  
?>
<!-- Begin page content -->

    <h1 class="mt-5">Ajouter un client</h1>

    <form class="row g-3" method="POST">
  <div class="col-md-6">
    <label for="inputnom" class="form-label">Nom</label>
    <input type="text" class="form-control" id="inputnom" name="inputnom" required>
  </div>
  <div class="col-md-6">
    <label for="inputville" class="form-label">Ville</label>
    <input type="text" class="form-control" id="inputville" name="inputville" required>
  </div>
  <div class="col-12">
    <label for="inputtel" class="form-label">Telephone</label>
    <input type="text" class="form-control" id="inputtel" name="inputtel" required>
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