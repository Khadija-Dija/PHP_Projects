
<?php 
// session_start();
// error_reporting(E_ALL); 
// ini_set('display_errors', 1);
include_once("header.php");
include_once("main.php");
$pdo=new connect();
$count = 0;
$listId=[];
$query="SELECT idArticle FROM article
        WHERE idArticle IN (SELECT idArticle 
            FROM ligne_commande 
            WHERE ligne_commande.idarticle =article.idArticle)
        OR idArticle IN (SELECT idArticle 
            FROM images 
            WHERE images.idarticle = article.idArticle)";
$pdostmt=$pdo->prepare($query);
$pdostmt->execute();
foreach($pdostmt->fetchAll(PDO::FETCH_NUM) as $tabValues){
    foreach($tabValues as $tabElements){
        $listId[]=$tabElements;
    }
};

//Article##################################################################
//addArticle
if (!empty($_FILES["inputimg"]["size"]) && !empty($_POST["inputdesc"]) && !empty($_POST["inputprixUni"]) && $_FILES["inputimg"]["size"] < $_POST["MAX-FILE-SIZE"]) {
 
    if (!is_dir("images")) {
        mkdir("images");
    }
    
    $extension = pathinfo($_FILES["inputimg"]["name"], PATHINFO_EXTENSION);
    if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
        $response = [
            "value" => false,
            "msg" => "L'extension que vous avez choisie n'est pas autorisée"
        ];

    } else {
        $path = "images/" . time() . "_" . $_FILES["inputimg"]["name"];
        $upload = move_uploaded_file($_FILES["inputimg"]["tmp_name"], $path);
        if ($upload) {
            $query1 = "INSERT INTO article(description,prix_unitaire) VALUES (:desc, :prix_uni)";
            $pdostmt1 = $pdo->prepare($query1);
            $success = $pdostmt1->execute(["desc" => $_POST["inputdesc"], "prix_uni" => $_POST["inputprixUni"]]);
          
            if ($success) {
                $id_art = $pdo->lastInsertId();
                $query2 = "INSERT INTO images(description_img,chemin_img,taille_img,idarticle) VALUES(:desc, :chemin, :taille, :idarticle)";
                $pdostmt2 = $pdo->prepare($query2);
                $result = $pdostmt2->execute(["desc" => $_FILES["inputimg"]["name"], "chemin" => $path, "taille" => $_FILES["inputimg"]["size"], "idarticle" => $id_art]);
                
                if ($result) {
                    $response = [
                        "value" => true,
                        "msg" => "Ajouté avec succès"
                    ];
                  
                } else {
                    $response = [
                        "value" => false,
                        "msg" => "Erreur d'ajout"
                    ];
                  
                }
            } else {
                $response = [
                    "value" => false,
                    "msg" => "Erreur d'ajout"
                ];
             
            }
        } else {
            $response = [
                "value" => false,
                "msg" => "Transfert KO" . $_FILES["inputimg"]["error"]
            ];
        
        }
        echo json_encode($response);
    }
    
    echo json_encode($response);
}

?>