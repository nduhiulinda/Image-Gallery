<?php include("includes/init.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />


  <title>DOGGOS</title>
  <link rel="stylesheet" type="text/css" href="styles/site.css" media="all" />

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

      echo "<div class=\"images\">
      <figure>
      <a href=\"dog.php?". http_build_query(array('dog_id' => $image["id"])). "\">" . "<img src= \"uploads/dogs/" . $image["id"] . "." . $image["file_ext"] . "\" />
      <figcaption>". htmlspecialchars($image["name"]) . "</figcaption>
      </a> " . "
      <!-- Source: ".$image["citation"]." by Dogtime-->
      <cite>Source: <a href=".$image["citation"]."> Dogtime</a></cite>
      </figure>
      </div>";

     }
   }
 ?>

</main>

<?php include("includes/footer.php"); ?>

</body>

</html>
