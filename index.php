<?php include("includes/init.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>DOGGOS</title>
</head>

<body>
  <header>
    <?php include("includes/header.php"); ?>
  </header>
<main>

<?php
 $db = open_or_init_sqlite_db('secure/site.sqlite', 'secure/init.sql');
 $sql = "SELECT * FROM dogs ORDER BY dogs.name;";
 $params = array (
   ":file_name" => $file_name
 );
 $records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
   if (count($records)>0){
     foreach ($records as $image){

      echo "<li><a href=\"dog.php?". http_build_query(array('dog_id' => $image["id"])). "\">" . "<img src= \"uploads/dogs/" . $image["id"] . "." . $image["file_ext"] . "\" />". htmlspecialchars($image["name"]) . "</a> " . "</li>";

     }
   }
 ?>
<cite>Icons made by <a href="https://www.flaticon.com/authors/catalin-fertu" title="Catalin Fertu">Catalin Fertu</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a></cite>
<button><a href="upload.php" alt="upload icon">
<img src="images/upload_button.png"/>
<strong> Upload </strong></a>
</button>

</main>

</body>

</html>
