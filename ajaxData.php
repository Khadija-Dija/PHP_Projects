<?php 
include_once("main.php");
if(!empty($_POST["code_region"])){
    
    $query="SELECT * FROM province_maroc WHERE code_region = :code_reg ORDER BY nom_province ASC";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["code_reg"=>$_POST["code_region"]]);

    while($row=$pdostmt->fetch(PDO::FETCH_ASSOC)):  
    echo "<option value='" . $row["idProvince"] . "'>" . $row["nom_province"] . "</option>";
    endwhile;
    $pdostmt->closeCursor();
}
else{
    echo "code region vide";
}
?>