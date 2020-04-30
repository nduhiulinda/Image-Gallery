<?php include("includes/init.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php

$tag_id = trim($_GET["tag_id"]);
$tag_id = filter_input(INPUT_GET, "tag_id", FILTER_VALIDATE_INT);
$sql = "SELECT * FROM dogs_tags INNER JOIN dogs ON dogs.id = dogs_tags.dog_id WHERE dogs_tags.tag_id=$tag_id ORDER BY dogs.name;";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
foreach ($records as $tag){
    $name = htmlspecialchars($tag["name"]);
    $file_name = "uploads/dogs/".$tag["dog_id"] . "." . $tag["file_ext"];
}

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
    var_dump($file_name);
    $records= exec_sql_query($db, $sql_1, $params)->fetchAll(PDO::FETCH_ASSOC);
    $delink= unlink($file_name);
    if ($records && $delink){
      $del_confirmation = TRUE;
    }
  }
}

?>
<head>
  <?php include("includes/head.php"); ?>

  <title><?php
  $sql = "SELECT name FROM tags WHERE tags.id = $tag_id;";
  $records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
  foreach ($records as $tag){
    $name = htmlspecialchars($tag["name"]);
  }
  echo $name
  ?>
  </title>
</head>

<body>
  <header>
    <?php include("includes/header.php"); ?>
  </header>

<main>
<?php
  include("includes/uploads.php");

$sql = "SELECT * FROM dogs_tags INNER JOIN dogs ON dogs.id = dogs_tags.dog_id WHERE dogs_tags.tag_id=$tag_id ORDER BY dogs.name;";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
   if (count($records)>0){
     foreach ($records as $image){
      ?>
      <div class="images">
        <figure>
        <div>
        <?php
            $sql = "SELECT * FROM dogs ORDER BY dogs.name;";
            $params = array (
              ":file_name" => $file_name
            );
            $records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
              if (count($records)>0){
                foreach ($records as $dog){
                  $dog_id = $dog["id"];
                  $dog_file = $dog["file_ext"];
                }
              }
                ?>
            <div>
            <form id="delete_image" method=
          "POST" action="tag.php?tag_id=<?php echo $tag_id?>">
              <input type="hidden" name="dog_id" value="<?php echo $image["dog_id"]; ?>">
              <input type="hidden" name="file_name" value=" <?php echo $image["dog_id"].".". $image["file_ext"]; ?>" >
              <button onclick = "alert('Are you sure you want to delete this image?')" id="delete" name="delete_image" type="submit" value="Delete">Delete Image </button>
        </form>
                </div>

                  <a href="dog.php?<?php echo http_build_query(array('dog_id' => $image["id"])) ?>">
                <img src= "uploads/dogs/<?php echo $image["dog_id"].".".$image["file_ext"]?> "/>
                <figcaption><?php echo htmlspecialchars($image["name"]) ?> </figcaption></a>
                <!-- Source: "<?php echo $image["citation"]?>" by Dogtime-->
              <cite>Source:<a href=" <?php echo $image["citation"]?>">Dogtime</a></cite>
            </figure>
          </div>

  <?php


     }
   }
?>

</main>

<?php include("includes/footer.php"); ?>


</body>

</html>
