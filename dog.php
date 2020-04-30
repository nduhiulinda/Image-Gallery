<?php include("includes/init.php"); ?>
<!DOCTYPE html>
<html lang="en">

<?php

$dog_id = trim($_GET["dog_id"]);
$dog_id = filter_input(INPUT_GET, "dog_id", FILTER_VALIDATE_INT);
$sql = "SELECT * FROM dogs WHERE id= $dog_id ORDER BY dogs.name;";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
foreach ($records as $dog){
    $name = htmlspecialchars($dog["name"]);
    $file_name = "uploads/dogs/".$dog["id"] . "." . $dog["file_ext"];
    $citation = $dog["citation"];
}

$del_confirmation = FALSE;
if (isset($_POST["delete_image"])){
  $dog_id = trim($_POST["dog_id"]);
  $dog_id = filter_input(INPUT_POST, "dog_id", FILTER_VALIDATE_INT);
  var_dump("dog id:".$dog_id);
  $file_name = trim($_POST["file_name"]);
  $file_name = filter_input(INPUT_POST, "file_name", FILTER_SANITIZE_STRING);
  $file_name = trim($file_name);
  var_dump("filename:".$file_name);

  $params = array(
    ':dog_id' => $dog_id
  );
  $sql_1 = "DELETE FROM dogs WHERE dogs.id = :dog_id ;";
  $sql_2 = "DELETE FROM dogs_tags WHERE dogs_tags.dog_id = :dog_id;";
  if (exec_sql_query($db, $sql_2, $params)){
    $records= exec_sql_query($db, $sql_1, $params);
    $delink= unlink($file_name);
    $file_name="uploads/dogs/".$file_name;
    if ($records && $delink){
      $del_confirmation = TRUE;
    }
  }
}

?>

<head>
  <?php include("includes/head.php"); ?>

  <title><?php echo $name ?></title>
</head>

<body>
  <header>
    <?php include("includes/header.php"); ?>
  </header>
<main>
<?php include("includes/uploads.php"); ?>

<div class="center">
  <a href="<?php echo $file_name ?>">
  <figure>
  <a href=""><button>Edit Tags
    </button></a>
    <div>
    <form id="delete_image" method="POST" action="dog.php?dog_id=<?php echo $dog_id;?>">
      <input type="hidden" name="dog_id" value="<?php echo $dog_id;?>">
      <input type="hidden" name="file_name" value="<?php echo $file_name;?>">
      <button onclick = "alert('Are you sure you want to delete this image?')" id="delete" name="delete_image" type="submit" value="Delete">Delete Image </button>
</form>
    </div>

<!--
    <span id="yes_confirm" class="hidden">Image Deleted Successfully</span>
    <div id="delete_popup" class="hidden">
      <span>Are you sure you want to delete this image?</span>
      <div>
        <button class="yes_del">Delete</button>
        <button class="no_del">Cancel</button>
      </div>
    </div> -->
  <img src= <?php echo $file_name ?> alt= <?php echo $name ?>/></a>
  <!-- Source: <?php echo $citation ?> -->
  <cite>Source:<a href="<?php echo $citation ?>">Dogtime</a></cite>

  <?php
  $sql = "SELECT * FROM dogs WHERE id= $dog_id ORDER BY dogs.name;";
  $records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
  foreach ($records as $dog){
      $name = htmlspecialchars($dog["name"]);
      $file_name = "uploads/dogs/".$dog["id"] . "." . $dog["file_ext"];
  }
  ?>
  <div class="content">
    <label>Name: </label><button type=button name="dog_name"> <?php echo  $name ?> </button>
  </div>
  <?php
  $sql = "SELECT DISTINCT tags.name FROM dogs_tags INNER JOIN tags ON dogs_tags.tag_id = tags.id WHERE dogs_tags.dog_id = $dog_id ORDER BY tags.name;";
  $records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
  ?>


  <div class="content">
    <label>Tags: </label>
  <?php
  foreach ($records as $tag){
      $name = htmlspecialchars($tag["name"]);
      echo "<button type=button name=\"ass_tags\">$name </button>";
  }
  ?>
  </div>
</figure>
</div>

</main>

<?php include("includes/footer.php"); ?>
</body>

</html>
