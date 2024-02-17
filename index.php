
<?php 
$index=true;
$count = 0;
include_once("header.php");
include_once("main.php");
$query = "SELECT c.nom, c.num_tele, c.ville, cmd.date, art.description, art.prix_unitaire,lc.quantite FROM client AS c,commande AS cmd, article AS art, ligne_commande AS lc 
  WHERE c.idClient=cmd.idClient 
  AND  cmd.idCmd=lc.idCommande
  AND art.idArticle=lc.idarticle;
";
$pdostmt=$pdo->prepare($query);
$pdostmt->execute();
?>

<!-- Begin page content -->

    <h1 class="mt-5">Acceuil</h1>

    <table id="datatable" class="display">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Numero Telephone</th>
            <th>Ville</th>
            <th>Date</th>
            <th>DESCRIPTION</th>
            <th>PRIX UNITAIRE</th>
            <th>Quantite</th>
            <!-- <th>Total</th> -->
        </tr>
    </thead>
    <tbody>  
        <?php while( $ligne=$pdostmt->fetch(PDO::FETCH_ASSOC)):; 
        $count++;
        ?>
        <tr>
          
            <td><?php echo $ligne["nom"] ?></td>
            <td><?php echo $ligne["num_tele"] ;?></td>
            <td><?php echo $ligne["ville"] ;?></td>
            <td><?php echo $ligne["date"] ;?></td>
            <td><?php echo $ligne["description"] ;?></td>
            <td><?php echo $ligne["prix_unitaire"] ;?></td>
            <td><?php echo $ligne["quantite"] ;?></td>
            <!-- <td><?php echo $ligne["quantite"]*$ligne["prix_unitaire"];?></td> -->
        </tr>
        <?php endwhile?>

    </tbody>
    </table>
   
  </div>
</main>

<?php 
$pdostmt->closeCursor();
include_once("footer.php");
?>