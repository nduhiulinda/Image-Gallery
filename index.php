<?php include("includes/init.php");

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
  ?>
        <h2>All Dogs</h2>
  <?php
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

      <a href="dog.php?<?php echo http_build_query(array('dog_id' => $image["id"])) ?>">
      <img src= "uploads/dogs/<?php echo $image["id"].".".$image["file_ext"] ?>" alt="<?php echo $image["name"] ?>"/>
      </a>
      <figcaption><?php echo htmlspecialchars($image["name"]) ?></figcaption>

      <!-- Source: "<?php echo $image["citation"] ?>" by Dogtime-->
      </figure>
      <div>
      <cite>Source: <a href=" <?php echo $image["citation"] ?>"> Dogtime</a></cite>
      </div>

      </div>

     <?php }
   }
 ?>

</main>

</body>

</html>
