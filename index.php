<?php include("includes/init.php");

$del_confirmation = FALSE;
if (isset($_POST["delete_image"])){
  $dog_id = trim($_POST["dog_id"]);
  $dog_id = filter_input(INPUT_POST, "dog_id", FILTER_VALIDATE_INT);
  $file_name = trim($_POST["file_name"]);
  $file_name = filter_input(INPUT_POST, "file_name", FILTER_SANITIZE_STRING);

  $params = array(
    ':dog_id' => $dog_id
  );

  $sql_1 = "DELETE FROM dogs WHERE dogs.id = :dog_id ;";
  $sql_2 = "DELETE FROM dogs_tags WHERE dogs_tags.dog_id = :dog_id;";
  if (exec_sql_query($db, $sql_1, $params)){
    $records= exec_sql_query($db, $sql_2, $params);
    $delink= unlink($file_name);
    if ($records && $delink){
      $del_confirmation = TRUE;
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php");?>
  <title>DOGGOS</title>
</head>

<body>
  <header>
    <?php include("includes/header.php"); ?>
  </header>
<main>


<?php
  include("includes/uploads.php");
 //$db = open_or_init_sqlite_db('secure/site.sqlite', 'secure/init.sql');
 $sql = "SELECT * FROM dogs ORDER BY dogs.name;";
 $params = array (
   ":file_name" => $file_name
 );
 $records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
   if (count($records)>0){
     foreach ($records as $image){
      ?>
      <div class="images">
      <figure>

      <!-- <div class="dropdown">
      <button id="dropdown"><img id="ellipsis" src="images/ellipsis.png" alt="ellipsis">
      <img id="close" class="hidden" src="images/close.png" alt="close">
      </button>

    <div class="dropdown-content">
      <ul id = "edit_options" class="hidden"> -->
      <div>
    <form id="delete_image" method=
  "POST" action="index.php">
      <input type="hidden" name="dog_id" value="<?php echo $image["id"]; ?>">
      <input type="hidden" name="file_name" value=" <?php echo $image["id"].".".$image["file_ext"]; ?>" >
      <button id="delete" name="delete_image" type="submit" value="Delete">Delete Image </button>
</form>
    </div>
      <!-- </ul>
      </div> </div> -->

      <a href="dog.php?<?php echo http_build_query(array('dog_id' => $image["id"])) ?>">
      <img src= "uploads/dogs/<?php echo $image["id"].".".$image["file_ext"] ?>" />
      <figcaption><?php echo htmlspecialchars($image["name"]) ?></figcaption>
      </a>
      <!-- Source: "<?php echo $image["citation"] ?>" by Dogtime-->
      <cite>Source: <a href=" <?php echo $image["citation"] ?>"> Dogtime</a></cite>
      </figure>
      </div>

     <?php }
   }
 ?>

</main>

<?php include("includes/footer.php"); ?>

</body>

</html>
