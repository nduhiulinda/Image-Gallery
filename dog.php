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
?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/site.css" media="all" />



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
    <button><a href="" >Edit Tags</a>
    </button>
    <button>Delete Image</a>
    </button>
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
