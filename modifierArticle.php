<?php 
ob_start();
$article=true;
include_once("header.php");
include_once("main.php");

//verifier si les champs non null
if(!empty($_GET["id"])){
    $id_art= `echo $_GET[id]`;

    //recuperer l'article qu'on souhaite modifier 
    $query1="select * from article where idArticle=:id";
    $pdostmt1=$pdo->prepare($query1);
    $pdostmt1->execute(["id"=>$_GET["id"]]);
    $row1=$pdostmt1->fetch(PDO::FETCH_ASSOC);

    //recuperer les images qui convient au article a partir de la table article
    $query2="select * from images where idarticle=:id_art";
    $pdostmt2=$pdo->prepare($query2);
    $pdostmt2->execute(["id_art"=>$_GET["id"]]);
    $row2=$pdostmt2->fetch(PDO::FETCH_ASSOC);
 
 
?>
<!-- Begin page content -->

    <h1 class="mt-5">Modifier  un article</h1>

    <form class="row g-3" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MAX-FILE-SIZE" value="1000000"></input>
        <input type="hidden" name="myId" value=<?php echo $row1["idArticle"] ?>>
        <div class="col-md-6">
            <label for="inputdesc"  >Description</label>
            <textarea class="form-control" placeholder="mettez la description" id="inputdesc" name="inputdesc" value="" required><?php echo $row1["description"] ?></textarea>
        </div>
        <div class="col-md-6">
            <label for="inputprixUni" class="form-label">Prix Unitaire</label>
            <input type="text" class="form-control" id="inputprixUni" name="inputprixUni" value="<?php echo $row1["prix_unitaire"] ?>"  required>
        </div>
        <div class="col-md-7">
            <label for="inputimg" class="form-label">Charger vos images</label>
            <input type="file" class="form-control" id="inputimg" name="inputimg" >
            <p>PNG, JPEG, JPG</p>
        </div>
        <div class="col-md-5">
            <img src="<?php echo $row2["chemin_img"] ?>" width="100" height="100" >
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
    </form>
    </div>
</main>
<?php 
   //liberer l'objet pdostmt de la memoire apres l'utilisation 
    $pdostmt1->closeCursor();
    $pdostmt2->closeCursor();
   
}

//2 eme requete pour modifer les champs (pour recuperer l'id on a utiliser le champs input de type hidden)
if(!empty($_POST)){
    $query1="update article set description=:desc, prix_unitaire=:pu where idArticle=:id";
    $pdostmt1=$pdo->prepare($query1);
    $pdostmt1->execute(["desc"=>$_POST["inputdesc"], "pu"=>$_POST["inputprixUni"],"id"=>$_POST["myId"]]);

    if(!empty($_FILES["inputimg"]["size"])&&$_FILES["inputimg"]["size"]<$_POST["MAX-FILE-SIZE"]):
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
                //inserer l'image de larticle dans le tableau images 
                $query2="update images set description_img=:desc, chemin_img=:chemin, taille_img=:taille where idarticle=:id";
                $pdostmt2=$pdo->prepare($query2);
                $pdostmt2->execute(["desc"=>$_FILES["inputimg"]["name"],"chemin"=>$path,"taille"=>$_FILES["inputimg"]["size"],"id"=>$_POST["myId"]]);
            
                $pdostmt1->closeCursor();
                $pdostmt2->closeCursor();
            }
            else{
                echo "transfert KO".$_FILES["inputimg"]["error"];
            }

        }
    
    endif;    
  header("Location:articles.php"); 
}
ob_end_flush(); 
?>

<?php 
include_once("footer.php");
?>    