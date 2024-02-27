
<?php 
$index=true;
include_once("header.php");
include_once("main.php");
$query = "SELECT c.nom, c.num_tele, c.IdProvince, cmd.idCmd,cmd.date, art.description, art.prix_unitaire, lc.quantite, prvc.nom_province, rgn.nom_region  FROM client AS c,commande AS cmd, article AS art, province_maroc AS prvc, region_maroc AS rgn , ligne_commande AS lc 
  WHERE c.idClient=cmd.idClient 
  AND  cmd.idCmd=lc.idCommande
  AND art.idArticle=lc.idarticle
  AND c.IdProvince=prvc.idProvince
  AND prvc.code_region=rgn.code_region;
  
";
$pdostmt=$pdo->prepare($query);
$pdostmt->execute();
?>

<!-- Begin page content -->

    <h1 class="mt-5">Acceuil</h1>

    <table id="datatable" class="display">
    <thead>
        <tr>
            <th></th>
            <th>Nom</th>
            <th>Numero Telephone</th>
            <th>Région</th>
            <th>Province</th>
            <th>Date</th>
            <th>DESCRIPTION</th>
            <th>PRIX UNITAIRE</th>
            <th>Quantite</th>
            <!-- <th>Total</th> -->
        </tr>
    </thead>
    <tbody>  
        <?php while( $ligne=$pdostmt->fetch(PDO::FETCH_ASSOC)):; 
        ?>
        <tr>
            <td>
                <a href="detailsCmd.php?idcmd=<?php echo $ligne["idCmd"]?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                    </svg>
                </a>
            </td>
            <td><?php echo $ligne["nom"] ?></td>
            <td><?php echo $ligne["num_tele"] ;?></td>
            <td><?php echo $ligne["nom_region"] ;?></td>
            <td><?php echo $ligne["nom_province"] ;?></td>
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
<script src="codeDT.js">

</script>