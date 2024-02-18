<?php 
ob_start();
$article=true;
include_once("header.php");
include_once("main.php");


if(!empty($_FILES["inputimg"]["size"])&&!empty($_POST["inputdesc"]) && !empty($_POST["inputprixUni"])&&$_FILES["inputimg"]["size"]<$_POST["MAX-FILE-SIZE"]):
    //verifier si le dossier images existe dans le serveur qui contiendra les images qui seront envoyées
    if(!is_dir("images"))
    {
        mkdir("images");
    }
        //limiter les extensions
        $extension=pathinfo($_FILES["inputimg"]["name"],PATHINFO_EXTENSION);
    if(!in_array($extension,['jpg','jpeg','png'])){
        echo "l'extention que vous avez choisi n'est pas autorisée";
    }else{
        //deplacer notre dossier a partir du repertoire tempon vers le rep de notre serveur
        //time() permet de differencier entre les images  meme s'il s'agit de la meme image
        $path="images/".time()."_".$_FILES["inputimg"]["name"];
        $upload= move_uploaded_file($_FILES["inputimg"]["tmp_name"],$path);
    if($upload){
        // prévenir les attaques par injection SQL: on utilise les paramètres nommés(nom,ville,telephone) dans les requêtes préparées
        $query1="insert into article(description,prix_unitaire) values (:desc, :prix_uni)";
        $pdostmt1=$pdo->prepare($query1);
        $pdostmt1->execute(["desc"=>$_POST["inputdesc"], "prix_uni"=>$_POST["inputprixUni"]]);
        //recuperer l'id de larticle
        $id_art=$pdo->lastInsertId();

        //inserer l'image de larticle dans le tableau images 
        $query2="insert into images(description_img,chemin_img,taille_img,idarticle) values(:desc, :chemin, :taille, :idarticle)";
        $pdostmt2=$pdo->prepare($query2);
        $pdostmt2->execute(["desc"=>$_FILES["inputimg"]["name"],"chemin"=>$path,"taille"=>$_FILES["inputimg"]["size"],"idarticle"=>$id_art]);
        $pdostmt1->closeCursor();
        $pdostmt2->closeCursor();

        header("Location:articles.php"); 
    }
    else{
          echo "transfert KO".$_FILES["inputimg"]["error"];
    }
  
    }

endif;    
ob_end_flush();  
?>
<!-- Begin page content -->

    <h1 class="mt-5">Ajouter un article</h1>
    <!-- enctype="multipart/form-data"  permet d'envoyer des fichier sur notre serveur-->
    <form class="row g-3" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MAX-FILE-SIZE" value="1000000"></input>
        <div class="col-md-6">
            <label for="inputdesc"  >Description</label>
            <textarea class="form-control" placeholder="mettez la description" id="inputdesc" name="inputdesc" required></textarea>
        </div>
        <div class="col-md-6">
            <label for="inputprixUni" class="form-label">Prix Unitaire</label>
            <input type="text" class="form-control" id="inputprixUni" name="inputprixUni" required>
        </div>
        <div class="col-md-12">
            <label for="inputimg" class="form-label">Charger vos images</label>
            <input type="file" class="form-control" id="inputimg" name="inputimg" required>
            <p>PNG, JPEG, JPG</p>
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