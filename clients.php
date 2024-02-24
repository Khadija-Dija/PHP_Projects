<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    // Code à exécuter lorsque le DOM est prêt

    // Attacher un événement à l'élément #inputregion
    $("#inputregion").on("change", function(){
      var code_region = $("#inputregion").val();

      if(code_region){
        // Effectuer une requête AJAX lorsque la région est sélectionnée
        $.ajax({
          type: 'POST',
          url: 'ajaxData.php',
          data: 'code_region=' + code_region,
          success: function(response){
            // console.log(response);
            $("#inputville").html(response);
          }
        });
      } else {
        $("#inputville").html("<option value=''>Sélectionner d'abord votre région</option>");
      }
    });

    // Attacher un événement submit au formulaire #addclientform
    $('#addclientform').submit(function(e) {
      e.preventDefault(); // Empêcher la soumission du formulaire par défaut
      console.log("avant le submit");
      $.ajax({
        type: 'POST',
        url: 'ajaxData.php',
        data: $('#addclientform').serialize(),
        dataType: 'json',
        success: function(response) {
            console.log("success");
          // Vérifier si la soumission a été réussie
          if (response.value) {
            // console.log(response);
            toastr.success(response.msg); // Afficher une notification de succès
            console.log(response.msg);
            $('#ClientModal').modal('hide'); // Fermer le modal Bootstrap
            $('#addclientform')[0].reset(); //vider le formulaire
            $('#inputville').val(''); //vider la case province
          } else {
            toastr.error(response.msg); // Afficher une notification d'erreur
          }
        },
        // refraiche la page a chaque ajout du client
        complete: function(){
            setInterval("location.reload()",600)
        },
        error: function(xhr, status, error) {
            console.log(error);
        console.log(xhr.responseText); // Afficher les détails de l'erreur dans la console
        }
      })
    })


  });
</script>



<?php 

$client=true;
ob_start();
include_once("header.php");
include_once("main.php");
$count=0;

$query2="SELECT * from region_maroc ORDER BY nom_region ASC";
$pdostmt2=$pdo->prepare($query2); 
$pdostmt2->execute();
$listId=[];
$query="select idClient from client where idClient in (select idClient from commande where commande.idClient =client.idClient)";
$pdostmt=$pdo->prepare($query);
$pdostmt->execute();
foreach($pdostmt->fetchAll(PDO::FETCH_NUM) as $tabValues){
    foreach($tabValues as $tabElements){
        $listId[]=$tabElements;
    }

};

?>

<!-- Begin page content -->

    <h1 class="mt-5">Clients</h1>

    <button type="button" class="btn btn-primary"  style="float:right; margin-bottom:20px;" data-bs-toggle="modal" data-bs-target="#ClientModal" data-bs-whatever="@mdo">
        <!-- <a href="addClient.php" class="btn btn-primary mb-4"> -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
            <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
        </svg>
        <!-- </a> -->
    </button>

    <div class="modal fade" id="ClientModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" > Ajouter un client</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> 
        <form class="row g-3" method="POST" id="addclientform">
            <div class="modal-body">
            
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
            
            </div>             
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Ajouter</button>            
        </div>
        </form>
        </div>
    </div>
    </div>



<?php 
    $query="SELECT * from client AS C , region_maroc AS R, province_maroc AS P WHERE
     C.IdProvince = P.IdProvince and P.code_region= R.code_region
       ";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute();
  //  var_dump($pdostmt->fetchAll(PDO::FETCH_ASSOC));
?>
    <table id="datatable" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOM</th>
            <th>Région</th>
            <th>Préfecture/Province</th>
            <th>NUM_TELE</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>  
        <?php while( $ligne=$pdostmt->fetch(PDO::FETCH_ASSOC)):; 
        $count++;
        ?>
        <tr>
          
            <td><?php echo $ligne["idClient"] ?></td>
            <td><?php echo $ligne["nom"] ;?></td>
            <td><?php echo $ligne["nom_region"] ;?></td>
            <td><?php echo $ligne["nom_province"] ;?></td>
            <td><?php echo $ligne["num_tele"] ;?></td>
            <td>
                <a href="modifierClient.php?id=<?php echo $ligne["idClient"] ?>" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                </svg>
                </a>
                <button type="button" class="btn btn-danger" <?php if(in_array($ligne["idClient"],$listId)){echo "disabled";}?>  data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $count?>" >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                </svg>
                </button>
            </td>

        </tr>

        <!-- Modal -->
        <div class="modal fade" id="deleteModal<?php echo $count?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Voulez vous vraiment supprimer ce client?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuuler</button>
                <a href="delete.php?id=<?php echo $ligne["idClient"] ?>"  class="btn btn-danger">Supprimer</a>
            </div>
            </div>
        </div>
        </div>
        <?php endwhile?>

    </tbody>
    </table>
  </div>
</main>

<?php 
ob_end_flush(); 
include_once("footer.php");


?>