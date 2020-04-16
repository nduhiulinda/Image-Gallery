<?php include("includes/init.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>TODO</title>
</head>

<body>
<main>
 <?php if($tag=="All" ) { ?>
   <h1>All Dogs<h1>
   <?php
   $sql= "SELECT dogs.file_name FROM dogs ORDER BY dogs.name;";
   $params=array();
   $records = exec_sql_query($db, $sql, $params)->fetchAll();
   if (count($records)>0){
     foreach ($records as $image){ ?>
        <img src="<?php echo ($image) ?>" alt=""><a href="..."></img>
        <?php
     }
   }
 }
   else{ ?>
     <h1><?php echo $tag?><h1>
     <?php
     $sql = "...";
     $params=array();
     $records = exec_sql_query($db, $sql, $params)->fetchAll();
   if (count($records)>0){
     foreach ($records as $image){ ?>
        <img src="<?php echo ($image) ?>" alt=""><a href="..."></img> <?php
     }
   }
  }
     ?>

 </main>
  <!-- TODO: This should be your main page for your site. Remove this file when you're ready!-->

</body>

</html>
