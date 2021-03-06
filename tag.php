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


?>
<head>
  <?php include("includes/head.php"); ?>

  <title><?php
  $tagg_name;
  $sql = "SELECT name FROM tags WHERE tags.id = $tag_id;";
  $records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
  foreach ($records as $tag){
    $name = htmlspecialchars($tag["name"]);
    $tagg_name = $name;
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

  echo "<h2>".$tagg_name."</h2>";

$sql = "SELECT * FROM dogs_tags INNER JOIN dogs ON dogs.id = dogs_tags.dog_id WHERE dogs_tags.tag_id=$tag_id ORDER BY dogs.name;";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
   if (count($records)>0){
     foreach ($records as $image){
      ?>
      <div class="images">
        <figure>
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

                  <a href="dog.php?<?php echo http_build_query(array('dog_id' => $image["id"])) ?>">
                <img src= "uploads/dogs/<?php echo $image["dog_id"].".".$image["file_ext"]?> " alt="<?php echo $image["name"] ?>"/></a>
                <figcaption><?php echo htmlspecialchars($image["name"]) ?> </figcaption>
                <!-- Source: "<?php echo $image["citation"]?>" by Dogtime-->
                </figure>
              <cite>Source:<a href=" <?php echo $image["citation"]?>">Dogtime</a></cite>

          </div>

  <?php


     }
   } else{?>
        <h3>No Images to Display :( </h3>
     <?php
   }
?>

</main>

</body>

</html>
