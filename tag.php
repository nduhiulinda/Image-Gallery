<?php include("includes/init.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php

$tags_id = $_GET["tag_id"];
$db = open_or_init_sqlite_db('secure/site.sqlite', 'secure/init.sql');
$sql = "SELECT * FROM dogs_tags INNER JOIN dogs ON dogs.id = dogs_tags.dogs_id WHERE dogs_tags.tags_id=$tags_id ORDER BY dogs.name;";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
foreach ($records as $tag){
    $name = htmlspecialchars($tag["name"]);
    $file_name = "uploads/dogs/".$tag["dogs_id"] . "." . $tag["file_ext"];
}

?>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title><?php echo $name ?></title>
</head>

<body>
  <header>
    <?php include("includes/header.php"); ?>
  </header>
<main>
<?php
$sql = "SELECT * FROM dogs_tags INNER JOIN dogs ON dogs.id = dogs_tags.dogs_id WHERE dogs_tags.tags_id=$tags_id ORDER BY dogs.name;";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
   if (count($records)>0){
     foreach ($records as $image){
      echo "<li><a href=\"dog.php?". http_build_query(array('dog_id' => $image["id"])). "\">" . "<img src= \"uploads/dogs/" . $image["dogs_id"] . "." . $image["file_ext"] . "\" />". htmlspecialchars($image["name"]) . "</a> " . "</li>";

     }
   }
?>

<button><a href="upload.php" alt="upload icon">
<img src="images/upload_button.png"/>
<strong> Upload </strong></a>
</button>

</main>

</body>

</html>
