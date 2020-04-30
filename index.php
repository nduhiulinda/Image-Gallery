<?php include("includes/init.php");

$del_confirmation = FALSE;
if (isset($_POST["delete_image"])){
  $dog_id = trim($_POST["dog_id"]);
  $dog_id = filter_input(INPUT_POST, "dog_id", FILTER_VALIDATE_INT);
  $file_name = trim($_POST["file_name"]);
  $file_name = filter_input(INPUT_POST, "file_name", FILTER_SANITIZE_STRING);
  $file_name = trim($file_name);
  $params = array(
    ':dog_id' => $dog_id
  );
  $sql_1 = "DELETE FROM dogs WHERE dogs.id = :dog_id ;";
  $sql_2 = "DELETE FROM dogs_tags WHERE dogs_tags.dog_id = :dog_id;";
  if (exec_sql_query($db, $sql_2, $params)){
    $file_name="uploads/dogs/".$file_name;
    $records= exec_sql_query($db, $sql_1, $params)->fetchAll(PDO::FETCH_ASSOC);
    $delink= unlink($file_name);
    if ($records && $delink){
      $del_confirmation = TRUE;
    }
  }
}

$show_new_tag_confirmation = FALSE;
if (isset($_POST["new_tag"])){
  $dog_id = trim($_POST["dog_id"]);
  $dog_id = filter_input(INPUT_POST, "dog_id", FILTER_VALIDATE_INT);
  $tag_name = trim($POST["tag_name"]);
  $tag_name = filter_input(INPUT_POST, "tag_name", FILTER_SANITIZE_STRING);
  $params_1 = array(
    ':tag_name' => $tag_name
  );
  $sql_1= "INSERT INTO tags (name) VALUES (:tag_name);";
  $add_tag = exec_sql_query($db, $sql_1, $params_1)->fetchAll(PDO::FETCH_ASSOC);
  $new_tag_id = $db->lastInsertID("id");
  $sql_2 = "INSERT INTO dogs_tags (dog_id, tag_id) VALUES (:dog_id, :tag_id);";
  $params_2 = array(
    ':dog_id' => $dog_id,
    ':tag_id' => $new_tag_id
  );
  $rel_tag = exec_sql_query($db, $sql_2, $params_2)->fetchAll(PDO::FETCH_ASSOC);
  if ($rel_tag){
    $show_new_tag_confirmation = TRUE;
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


    <!-- <div class="wrap-collabsible">
  <input id="collapsible" class="toggle" type="checkbox">
  <img  for="" id="ellipsis" src="images/ellipsis.png" alt="ellipsis">
  <div class="collapsible-content">
    <div class="content-inner">
    <form id="delete_image" method=
  "POST" action="index.php">
      <input type="hidden" name="dog_id" value="<?php echo $image["id"]; ?>">
      <input type="hidden" name="file_name" value=" <?php echo $image["id"].".".$image["file_ext"]; ?>" >
      <button onclick = "alert('Are you sure you want to delete this image?')" id="delete" name="delete_image" type="submit" value="Delete">Delete Image </button>
</form>
    </div>
    </div>
  </div>
</div> -->

      <div class="dropdown">
      <input id="dropdown" type="checkbox"><img for="dropdown" id="ellipsis" src="images/ellipsis.png" alt="ellipsis">
      <img id="close" class="hidden" src="images/close.png" alt="close">
     </input>

    <div class="dropdown-content">
      <ul id = "edit_options" class="hidden">
        <div class="content_inner">

    <!-- <div>
    <a href="#edit_tags"><button>Edit Tags</button></a>
    </div>
    <div id="edit_tags" class="popup">
        <div>
        <form id="new_tag" method=
      "POST" action="index.php">
          <input type="hidden" name="dog_id" value="<?php echo $image["id"]; ?>">
          <button class="new_tag" name="new_tag" type="submit" value="new_tag">Add a New Tag</button>
    </form>
        </div>
        <div>
        <form id="existing_tag" method=
      "POST" action="index.php">
          <input type="hidden" name="dog_id" value="<?php echo $image["id"]; ?>">
          <button class="existing_tag" name="existing_tag" type="submit" value="existing_tag">Add an Existing Tag</button>
    </form>
        </div>
        <div>
        <form id="del_tag" method=
      "POST" action="index.php">
          <input type="hidden" name="dog_id" value="<?php echo $image["id"]; ?>">
          <button class="del_tag" name="del_tag" type="submit" value="del_tag">Delete a Tag</button>
    </form>
        </div>
  </div> -->

      <!-- <div> -->
    <form id="delete_image" method=
  "POST" action="index.php">
      <input type="hidden" name="dog_id" value="<?php echo $image["id"]; ?>">
      <input type="hidden" name="file_name" value=" <?php echo $image["id"].".".$image["file_ext"]; ?>" >
      <button onclick = "alert('Are you sure you want to delete this image?')" id="delete" name="delete_image" type="submit" value="Delete">Delete Image </button>
</form>
    </div>
      <!-- </ul> -->
      </div> </div>

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
