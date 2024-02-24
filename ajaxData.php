<?php 
  include_once("connexion.php");
  $pdo=new connect();
  $count=0;
  $listId=[];
  $query="select idClient from client where idClient in (select idClient from commande where commande.idClient =client.idClient)";
  $pdostmt=$pdo->prepare($query);
  $pdostmt->execute();
  foreach($pdostmt->fetchAll(PDO::FETCH_NUM) as $tabValues){
      foreach($tabValues as $tabElements){
          $listId[]=$tabElements;
      }
  
  };


if(!empty($_POST["code_region"])){
    
    $query="SELECT * FROM province_maroc WHERE code_region = :code_reg ORDER BY nom_province ASC";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["code_reg"=>$_POST["code_region"]]);

    while($row=$pdostmt->fetch(PDO::FETCH_ASSOC)):  
    echo "<option value='" . $row["idProvince"] . "'>" . $row["nom_province"] . "</option>";
    endwhile;
    $pdostmt->closeCursor();
};
//verifier si les champs non null
if(!empty($_POST["inputnom"])&&!empty($_POST["inputville"])&&!empty($_POST["inputtel"])){
    // prévenir les attaques par injection SQL: on utilise les paramètres nommés(nom,ville,telephone) dans les requêtes préparées
    $query="insert into client(nom,IdProvince,num_tele) values (:nom, :id_prov, :telephone)";
    $pdostmt=$pdo->prepare($query);
    $result=$pdostmt->execute(["nom"=>$_POST["inputnom"], "id_prov"=>$_POST["inputville"], "telephone"=>$_POST["inputtel"]]);

    if($result){
        $response=[
            "value"=>true,
            "msg"=>"Ajout avec succès !",
        ];
    }
    else{
        $response=[
            "value"=>false,
            "msg"=>$pdostmt->errorInfo(),
        ];
    };
    echo json_encode($response) ;
    $pdostmt->closeCursor();
}
if(!empty($_GET["clients"])){
   
    $query="SELECT * from client AS C , region_maroc AS R, province_maroc AS P WHERE
     C.IdProvince = P.IdProvince and P.code_region= R.code_region";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute();

  //  var_dump($pdostmt->fetchAll(PDO::FETCH_ASSOC));
}
   
 while( $ligne=$pdostmt->fetch(PDO::FETCH_ASSOC)):; 
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


?>