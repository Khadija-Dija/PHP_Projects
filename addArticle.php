<?php 
ob_start();
$article=true;
include_once("header.php");
include_once("main.php");

//verifier si les champs non null
if(!empty($_POST["inputdesc"]) && !empty($_POST["inputprixUni"])):
    // prévenir les attaques par injection SQL: on utilise les paramètres nommés(nom,ville,telephone) dans les requêtes préparées
    $query="insert into article(description,prix_unitaire) values (:desc, :prix_uni)";
    
    $pdostmt=$pdo->prepare($query);
    
    $pdostmt->execute(["desc"=>$_POST["inputdesc"], "prix_uni"=>$_POST["inputprixUni"]]);

    //liberer l'objet pdostmt de la memoire apres l'utilisation 
    $pdostmt->closeCursor();
    //Redirection vers la page articles apres l'insertion
    header("Location:articles.php"); 
endif;
ob_end_flush();  
?>
<!-- Begin page content -->

    <h1 class="mt-5">Ajouter un article</h1>

    <form class="row g-3" method="POST">
        <div class="col-md-6">
            <label for="inputdesc"  >Description</label>
            <textarea class="form-control" placeholder="mettez la description" id="inputdesc" name="inputdesc" required></textarea>
        </div>
        <div class="col-md-6">
            <label for="inputprixUni" class="form-label">Prix Unitaire</label>
            <input type="text" class="form-control" id="inputprixUni" name="inputprixUni" required>
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