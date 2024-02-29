<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<?php 
$client=true;
ob_start();
include_once("header.php");
include_once("main.php");

$query2="SELECT * from region_maroc ORDER BY nom_region ASC";
$pdostmt2=$pdo->prepare($query2); 
$pdostmt2->execute();

?>

<script>
      //update client
       function update_client(id){
        // console.log(id);
        $.ajax({
            type:"GET",
            url:'ajaxData.php?updated_client='+id,
            //type de retour des information
            dataType:'json',
            success: function(response){
                console.log(response);
                $("#client_id").val(response.msg.idClient);
                $("#inputnom").val(response.msg.nom);
                $("#inputtel").val(response.msg.num_tele);
                $("#inputregion option[value='"+response.msg.code_region+"']").prop("selected",true);
                $("#inputville").html("<option value="+response.msg.IdProvince+">"+response.msg.nom_province+"</option>");
                $("#clientModalLabel").html("Modifier un client");
                $("#btn").html("Modifier");
                $("#ClientModal").modal("show");
                
            }

        })
    }
    //delete client
    function delete_client(id){
        $.ajax({
            type:"GET",
            url:'ajaxData.php?deleted_client='+id,
            dataType:"json",
            success: function(response){
                if(response.status){
                    toastr.success(response.msg)
                }
                else{
                    toastr.error(response.msg);
                }
            },
            complete: function(){
            setInterval("location.reload()",600)
            },
            
        });
    }
    // Code à exécuter lorsque le DOM est prêt
  $(document).ready(function(){
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
            // console.log(response.msg);
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
        // console.log(xhr.responseText); // Afficher les détails de l'erreur dans la console
        }
      })
    });

    //afficher un client (read)
    function getClient(){
        $.ajax({
            type:"GET",
            url: 'ajaxData.php?clients=true',
            dataType: 'html',
            success: function(response) {
                $("#clients").html(response);
                // console.log(response);
                $("#datatable").dataTable({
              oLanguage: {
                sLengthMenu: "Afficher _MENU_ enregistrements",
                sSearch: "Recherche",
                sInfo: "Total d'enregistrements (_END_ / _TOTAL_)",
                oPaginate: {
                  sNext: "Suivant",
                  sPrevious: "Précédent",
                },
              },
              lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Tous"],
              ], // Spécifie les options de longueur du menu
              pageLength: 5, // Spécifie le nombre de lignes par page par défaut
            });
            }
        })
    };
    getClient();
  })
</script>
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
            <h5 id="clientModalLabel" class="modal-title fs-5" > Ajouter un client</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> 
        <form class="row g-3" method="POST" id="addclientform">
            <div class="modal-body">
            
                    <div class="col-md-6">
                        <label for="inputnom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="inputnom" name="inputnom" required>
                        <input type="hidden" name="client_id" id="client_id">
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
                <button type="submit" class="btn btn-primary" id="btn">Ajouter</button>            
            </div>
        </form>
        </div>
    </div>
    </div>
    
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
    <tbody id="clients"> 
    </tbody>
    </table>
  </div>
</main>

<?php 
ob_end_flush(); 
include_once("footer.php");
?>