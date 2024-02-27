<?php 
session_start();
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
   
        if(empty($_POST["client_id"])){
        // prévenir les attaques par injection SQL: on utilise les paramètres nommés(nom,ville,telephone) dans les requêtes préparées
        $query="insert into client(nom,IdProvince,num_tele) values (:nom, :id_prov, :telephone)";
        $pdostmt=$pdo->prepare($query);
        $result=$pdostmt->execute(["nom"=>$_POST["inputnom"], "id_prov"=>$_POST["inputville"], "telephone"=>$_POST["inputtel"]]);
        $msg="Ajouter avec succès !!";

        if($result){
            $response=[
                "value"=>true,
                "msg"=>$msg,
            ];
        }
        else{
            $response=[
                "value"=>false,
                "msg"=>$pdostmt->errorInfo(),
            ];
        };
    }
    //si le client id n'exist pas on va faire un update
    else{
        $query="update client set nom=:nom, IdProvince=:province, num_tele=:tel  where idClient=:id";
        $pdostmt=$pdo->prepare($query);
        $result=$pdostmt->execute(["nom"=>$_POST["inputnom"], "province"=>$_POST["inputville"], "tel"=>$_POST["inputtel"],"id"=>$_POST["client_id"]]);
        $msg="Modifier avec succès !!";

        if($result){
            $response=[
                "value"=>true,
                "msg"=>$msg,
            ];
        }
        else{
            $response=[
                "value"=>false,
                "msg"=>$pdostmt->errorInfo(),
            ];
        };

    }

    echo json_encode($response) ;
    $pdostmt->closeCursor();
}
if(!empty($_GET["clients"])){
   
    $query="SELECT * from client AS C , region_maroc AS R, province_maroc AS P WHERE
     C.IdProvince = P.IdProvince and P.code_region= R.code_region";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute();

  //  var_dump($pdostmt->fetchAll(PDO::FETCH_ASSOC));

   
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
        <a onclick= "update_client(<?php echo $ligne['idClient']; ?>)" class="btn btn-success">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
              <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
          </svg>
          </a>
          <button onclick= "delete_client(<?php echo $ligne['idClient']; ?>)"    type="button" class="btn btn-danger" <?php if(in_array($ligne["idClient"],$listId)){echo "disabled";}?>   echo $count?> 
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
              <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
          </svg>
          </button>
      </td>

  </tr>

  <?php endwhile;
}
//recuperer le client en question
if(!empty($_GET["updated_client"])){

    $query="SELECT * from client AS C , region_maroc AS R, province_maroc AS P WHERE
            C.IdProvince = P.IdProvince and P.code_region= R.code_region and idClient=:id";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["id"=>$_GET["updated_client"]]);
    $result=$pdostmt->fetch(PDO::FETCH_ASSOC);
    if($result){
        $response=[
            "value"=>true,
            "msg"=>$result,
        ];
    }
    else{
        $response=[
            "value"=>false,
            "msg"=>$pdostmt->errorInfo(),
        ];
    }
    echo json_encode($response);

}
if(!empty($_GET["deleted_client"])){
    
    $query="delete from client where idClient=:id";
    $pdostmt=$pdo->prepare($query);
    $result=$pdostmt->execute(["id"=>$_GET["deleted_client"]]);
    $msg="Supprimer avec succès !!!";
    //liberer l'objet pdostmt de la memoire apres l'utilisation 
    if($result){
        $response=[
            "value"=>true,
            "msg"=>$msg,
        ];
    }
    else{
        $response=[
            "value"=>true,
            "msg"=>$objstmt->errorInfo(),
        ];
    }
    echo json_encode($response);
    $pdostmt->closeCursor();
}
//register
if(!empty($_POST["username_register"])&&!empty($_POST["email_register"])&&!empty($_POST["password_register"])&&!empty($_POST["confirm-password_register"])){
  //  verifier si username n'existe pas dans la DB
    $query3="select username from users where username=:name";
    $pdostmt3=$pdo->prepare($query3);
    $pdostmt3->execute(["name"=>$_POST["username_register"]]);
    $username=$pdostmt3->fetch(PDO::FETCH_ASSOC);
    if ($username) {
        $msg = "Ce nom existe déjà.";
        $response = [
            "username" => $msg
        ];
    }else{
       
        // echo "le nom est".$_POST["username_register"];
        //verifier si l'email n'existe pas dans la DB
        $query2="select email from users where email=:mail";
        $pdostmt2=$pdo->prepare($query2);
        $pdostmt2->execute(["mail"=>$_POST["email_register"]]);
        $myresult=$pdostmt2->fetch(PDO::FETCH_ASSOC);

        if(!$myresult){
            $query="insert into users(username,email,password) values (:username, :email, :pwd)";
            $pdostmt=$pdo->prepare($query);
            $result=$pdostmt->execute(["username"=>$_POST["username_register"], "email"=>$_POST["email_register"], "pwd"=>password_hash($_POST["password_register"],PASSWORD_DEFAULT)]);
            $msg="Enregister avec succès!!";

            if($result){
                $response=[ 
                    "msg"=>$msg,
                    "value"=>true
                ];
               
            }
            else{
                $response=[
                    "msg"=>$pdostmt->errorInfo(),
                    "value"=>false

                ];
               
            }
        }else{
                $msg="Cet email exist dèja";
                $response=[
                    "email"=>$msg
                ];
              
            }
    }
   
    echo json_encode($response);
    $pdostmt3->closeCursor();
}
//login
if(!empty($_POST["username_login"])&&!empty($_POST["password_login"])){
    //verifier si le username existe deja
    $query="select * from users where username=:name";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["name"=>$_POST["username_login"]]);
    $user=$pdostmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($username);
    // exit();
    if(!$user){
        $msg="Cet utilisateur n'exist pas";
        $response=[ 
            "user"=>$msg
        ];
    } else {
        //verifier le mot de passe
        $pass=password_verify($_POST["password_login"],$user["password"]);
         
        if(!$pass){
        $msg="Ce password est erroné";  
        $response = [
            "value" => false, 
            "msg" => $msg ,
        
        ];
        }
        else{
            //recuperer le nom du username connecter
            //variable de session user
            $_SESSION["user"]= $user["username"];
            $msg="Connexion réussite";  
            $response = [
                "value" => true, 
                "msg" => $msg ,
            
            ];
        }
    }
    echo json_encode($response);
}


?>