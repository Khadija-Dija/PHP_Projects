<?php 
  include_once("connexion.php");
  $pdo=new connect();
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
?>