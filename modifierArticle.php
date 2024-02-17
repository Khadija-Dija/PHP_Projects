<?php 
ob_start();
$article=true;
include_once("header.php");
include_once("main.php");

//verifier si les champs non null
if(!empty($_GET["id"])){
    //recuperer l'article qu'on souhaite modifier 
    $query="select * from article where idArticle=:id";
    $pdostmt=$pdo->prepare($query);
    
    $pdostmt->execute(["id"=>$_GET["id"]]);
    while($row=$pdostmt->fetch(PDO::FETCH_ASSOC)):

 
?>
<!-- Begin page content -->

    <h1 class="mt-5">Ajouter un article</h1>

    <form class="row g-3" method="POST">
    <input type="hidden" name="myId" value=<?php echo $row["idArticle"] ?>>
        <div class="col-md-6">
            <label for="inputdesc"  >Description</label>
            <textarea class="form-control" placeholder="mettez la description" id="inputdesc" name="inputdesc" value="" required><?php echo $row["description"] ?></textarea>
        </div>
        <div class="col-md-6">
            <label for="inputprixUni" class="form-label">Prix Unitaire</label>
            <input type="text" class="form-control" id="inputprixUni" name="inputprixUni" value="<?php echo $row["prix_unitaire"] ?>"  required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Modifier</button>
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
    $query="update article set description=:desc, prix_unitaire=:pu where idArticle=:id";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["desc"=>$_POST["inputdesc"], "pu"=>$_POST["inputprixUni"],"id"=>$_POST["myId"]]);
    //Redirection vers la page client apres l'insertion
    header("Location:articles.php"); 
}
ob_end_flush(); 
?>

<?php 
include_once("footer.php");
?>    