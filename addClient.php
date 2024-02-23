<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  //ne s'exutera que lorsque la page dom sera prete pour l'executuin du cose js

  $(document).ready(function(){
    //on permet d'attacher un evenement(change) a notre element
    $("#inputregion").on("change",function(){
      //stocker la valeur choisi a partir de la liste deroulate
      var code_region=$("#inputregion").val();

      //si il a choisi 
      if(code_region){
        //effectuer une requete http
        $.ajax({
          type: 'POST',
          url: 'ajaxData.php',
          data: 'code_region='+code_region,
          success: function(response){
            //integrer la reponse comme contenu html sue la liste deroulante ville
            // alert(response);
            $("#inputville").html(response);
          }
        });
      }
      //si il a  rien choisi on va met sur le champs ville 
      else{
        $("#inputville").html("<option value=''> Selectionner d'abord votre région</option>");
      }


    });
  })
</script>
<?php 
ob_start();
include_once("header.php");
include_once("main.php");
$client=true;
$query2="SELECT * from region_maroc ORDER BY nom_region ASC";
$pdostmt2=$pdo->prepare($query2); 
$pdostmt2->execute();

//verifier si les champs non null
if(!empty($_POST["inputnom"])&&!empty($_POST["inputville"])&&!empty($_POST["inputtel"])):
    // prévenir les attaques par injection SQL: on utilise les paramètres nommés(nom,ville,telephone) dans les requêtes préparées
    $query="insert into client(nom,IdProvince,num_tele) values (:nom, :id_prov, :telephone)";
    $pdostmt=$pdo->prepare($query);
    
    $pdostmt->execute(["nom"=>$_POST["inputnom"], "id_prov"=>$_POST["inputville"], "telephone"=>$_POST["inputtel"]]);
   
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
    <label for="inputtel" class="form-label">Telephone</label>
    <input type="text" class="form-control" id="inputtel" name="inputtel" required>
  </div>
  <div class="col-md-6">
    <label for="inputregion" class="form-label">Région</label>
    <select  class="form-control" id="inputregion" name="inputregion" required>
    <option value="">Sectionner une région</option>
    <?php while($row=$pdostmt2->fetch(PDO::FETCH_ASSOC)): ?>
     <option value="<?php echo $row["code_region"] ?>"><?php echo $row["nom_region"] ?></option>
    <?php endwhile ?>
    </select>  
  </div>
  <div class="col-md-6">
    <label for="inputville" class="form-label">Province</label>
    <select  class="form-control" id="inputville" name="inputville" required>
    <option value="">Sectionner d'abord une région</option> 
  </select>  
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