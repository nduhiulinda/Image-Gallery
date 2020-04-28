<?php include("includes/init.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php

$tag_id = $_GET["tag_id"];
$db = open_or_init_sqlite_db('secure/site.sqlite', 'secure/init.sql');
$sql = "SELECT * FROM dogs_tags INNER JOIN dogs ON dogs.id = dogs_tags.dog_id WHERE dogs_tags.tag_id=$tag_id ORDER BY dogs.name;";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
foreach ($records as $tag){
    $name = htmlspecialchars($tag["name"]);
    $file_name = "uploads/dogs/".$tag["dog_id"] . "." . $tag["file_ext"];
}

?>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/site.css" media="all" />

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
      echo "<div class=\"images\"><figure><a href=\"dog.php?". http_build_query(array('dog_id' => $image["id"])). "\">" . "<img src= \"uploads/dogs/" . $image["dog_id"] . "." . $image["file_ext"] . "\" /><figcaption>". htmlspecialchars($image["name"]) . "</figcaption></a> <!-- Source: ".$image["citation"]." by Dogtime-->
      <cite>Source:<a href=\"".$image["citation"]."\">Dogtime</a></cite>" . "</figure></div>";

     }
   }
?>

</main>

<?php include("includes/footer.php"); ?>


</body>

</html>
