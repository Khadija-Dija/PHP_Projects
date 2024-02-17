
<?php 
$client=true;
include_once("header.php");
include_once("main.php");
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
?>


<!-- Begin page content -->

    <h1 class="mt-5">Clients</h1>
    <a href="addClient.php" class="btn btn-primary mb-4" style="float:right">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
        <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
    </svg>
    </a>
<?php 
    $query="select * from client";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute();
  //  var_dump($pdostmt->fetchAll(PDO::FETCH_ASSOC));
?>
    <table id="datatable" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOM</th>
            <th>Ville</th>
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
            <td><?php echo $ligne["ville"] ;?></td>
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
include_once("footer.php");
?>