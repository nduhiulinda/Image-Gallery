<?php include("includes/init.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php

$dogs_id = $_GET["dog_id"];
$db = open_or_init_sqlite_db('secure/site.sqlite', 'secure/init.sql');
$sql = "SELECT * FROM dogs WHERE id= $dogs_id ORDER BY dogs.name;";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
foreach ($records as $dog){
    $name = htmlspecialchars($dog["name"]);
    $file_name = "uploads/dogs/".$dog["id"] . "." . $dog["file_ext"];
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

<img src= <?php echo $file_name ?> alt= <?php echo $name ?>/>
<?php
$sql = "SELECT * FROM dogs WHERE id= $dogs_id ORDER BY dogs.name;";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
foreach ($records as $dog){
    $name = htmlspecialchars($dog["name"]);
    $file_name = "uploads/dogs/".$dog["id"] . "." . $dog["file_ext"];
}
?>
<p>Name: </p><button type=button name="dog_name"> <?php echo  $name ?> </button>

<?php
$sql = "SELECT DISTINCT tags.name FROM dogs_tags INNER JOIN tags ON dogs_tags.tags_id = tags.id WHERE dogs_tags.dogs_id = $dogs_id ORDER BY tags.name;";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<p>Tags: </p>
<?php
foreach ($records as $tag){
    $name = htmlspecialchars($tag["name"]);
    echo "<button type=button name=\"ass_tags\">$name </button>";
}
?>

<button><a href="upload.php" alt="upload icon">
<img src="images/upload_button.png"/>
<strong> Upload </strong></a>
</button>

</main>

</body>

</html>
