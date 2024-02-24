
<?php 
ob_start();
$client=true;
include_once("header.php");
include_once("main.php");

?>
<!-- Begin page content -->

  <h1 class="mt-5">Ajouter un client</h1>

  <!-- <form class="row g-3" method="POST">
    <div class="col-md-6">
      <label for="inputnom" class="form-label">Nom</label>
      <input type="text" class="form-control" id="inputnom" name="inputnom" required>
    </div>
    <div class="col-md-6">
      <label for="inputtel" class="form-label">Telephone</label>
      <input type="text" class="form-control" id="inputtel" name="inputtel" required>
    </div>
    <div class="col-md-6">
      <label for="inputregion" class="form-label">Région</label>
      <select  class="form-control" id="inputregion" name="inputregion" required>
      <option value="">Sectionner une région</option>
      <?php while($row=$pdostmt2->fetch(PDO::FETCH_ASSOC)): ?>
      <option value="<?php echo $row["code_region"] ?>"><?php echo $row["nom_region"] ?></option>
      <?php endwhile ?>
      </select>  
    </div>
    <div class="col-md-6">
      <label for="inputville" class="form-label">Province</label>
      <select  class="form-control" id="inputville" name="inputville" required>
      <option value="">Sectionner d'abord une région</option> 
    </select>  
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Ajouter</button>
    </div>
  </form> -->
</div>
</main>

<?php 
include_once("footer.php");
?>    