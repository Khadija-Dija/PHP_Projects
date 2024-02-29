
<?php 

include_once("header.php");
include_once("main.php");

//Total Clients
$query1 = "SELECT COUNT(*) as total_rows FROM client";
$statement1 = $pdo->prepare($query1);
$statement1->execute();
$nbr_client = $statement1->fetch(PDO::FETCH_ASSOC);
$totalClients = $nbr_client['total_rows'];
// echo "Clients " . $totalClients;

//Total Users
$query2 = "SELECT COUNT(*) as total_rows FROM users";
$statement2 = $pdo->prepare($query2);
$statement2->execute();
$nbr_users = $statement2->fetch(PDO::FETCH_ASSOC);
$totalUsers = $nbr_users['total_rows'];
// echo "Users " . $totalUsers;

//Total Commandes
$query3 = "SELECT COUNT(*) as total_rows FROM commande";
$statement3 = $pdo->prepare($query3);
$statement3->execute();
$nbr_commandes = $statement3->fetch(PDO::FETCH_ASSOC);
$totalCommandes = $nbr_commandes['total_rows'];
// echo "totalCommandes : " . $totalCommandes;

//Total Articles
$query4 = "SELECT COUNT(*) as total_rows FROM article";
$statement4 = $pdo->prepare($query4);
$statement4->execute();
$nbr_articles = $statement4->fetch(PDO::FETCH_ASSOC);
$totalArticles = $nbr_articles['total_rows'];
// echo "totalArticles: " . $totalArticles;


?>
  <div class="row mt-5">
    <div class="col-md-6 mb-3">
        <div class="card-counter danger">
            <i class="fa fa-users"></i>
            <span class="count-numbers"><?php echo $totalClients ?></span>
            <span class="count-name">Clients</span>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card-counter primary">
            <i class="fa fa-code-fork"></i>
            <span class="count-numbers"><?php echo $totalUsers ?></span>
            <span class="count-name">Users</span>
        </div>
    </div>

    <div class="col-md-6  mb-3">
        <div class="card-counter success">
            <i class="fa fa-database"></i>
            <span class="count-numbers"><?php echo $totalArticles ?></span>
            <span class="count-name">Articles</span>
        </div>
    </div>

    <div class="col-md-6  mb-3">
        <div class="card-counter info">
            <i class="fa fa-shopping-cart"></i>
            <span class="count-numbers"><?php echo $totalCommandes ?></span>
            <span class="count-name">Commandes</span>
        </div>
    </div>
</div>

</div>
</main>

<?php 

include_once("footer.php");
?>
<script src="codeDT.js">

</script>