<?php include("includes/init.php");

$dog_id = trim($_GET["dog_id"]);
$dog_id = filter_input(INPUT_GET, "dog_id", FILTER_VALIDATE_INT);
$sql = "SELECT * FROM dogs WHERE id= $dog_id ORDER BY dogs.name;";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
foreach ($records as $dog){
    $name = htmlspecialchars($dog["name"]);
    $file_name = "uploads/dogs/".$dog["id"] . "." . $dog["file_ext"];
    $citation = $dog["citation"];
}

$del_confirmation = FALSE;
if (isset($_POST["delete_image"])){
  $dog_id = trim($_POST["dog_id"]);
  $dog_id = filter_input(INPUT_POST, "dog_id", FILTER_VALIDATE_INT);
  var_dump("dog id:".$dog_id);
  $file_name = trim($_POST["file_name"]);
  $file_name = filter_input(INPUT_POST, "file_name", FILTER_SANITIZE_STRING);
  $file_name = trim($file_name);
  var_dump("filename:".$file_name);

  $params = array(
    ':dog_id' => $dog_id
  );
  $sql_1 = "DELETE FROM dogs WHERE dogs.id = :dog_id ;";
  $sql_2 = "DELETE FROM dogs_tags WHERE dogs_tags.dog_id = :dog_id;";
  if (exec_sql_query($db, $sql_2, $params)){
    $records= exec_sql_query($db, $sql_1, $params);
    $delink= unlink($file_name);
    $file_name="uploads/dogs/".$file_name;
    if ($records && $delink){
      $del_confirmation = TRUE;
    }
  }
}

$show_new_tag_confirmation = FALSE;
if (isset($_POST["submit_new"])){
  $dog_id = trim($_POST["dog_id"]);
  $dog_id = filter_input(INPUT_POST, "dog_id", FILTER_VALIDATE_INT);
  $tag_name = trim($POST["new_tag_name"]);
  $tag_name = filter_input(INPUT_POST, "new_tag_name", FILTER_SANITIZE_STRING);
  $params_1 = array(
    ':tag_name' => $tag_name
  );
  $sql_1= "INSERT INTO tags (name) VALUES (:tag_name);";
  $add_tag = exec_sql_query($db, $sql_1, $params_1)->fetchAll(PDO::FETCH_ASSOC);
  $new_tag_id = $db->lastInsertID("id");
  $sql_2 = "INSERT INTO dogs_tags (dog_id, tag_id) VALUES (:dog_id, :tag_id);";
  $params_2 = array(
    ':dog_id' => $dog_id,
    ':tag_id' => $new_tag_id
  );
  $rel_tag = exec_sql_query($db, $sql_2, $params_2)->fetchAll(PDO::FETCH_ASSOC);
  if ($rel_tag){
    $show_new_tag_confirmation = TRUE;
  }
}

$show_existing_tag_confirmation = FALSE;
if (isset($_POST["submit_existing"])){
  $dog_id = trim($_POST["dog_id"]);
  $dog_id = filter_input(INPUT_POST, "dog_id", FILTER_VALIDATE_INT);
  $tag = $_POST["image_tag"];

  //validate tags
  $tags_arr = [];
  $tag_sql = "SELECT * FROM tags";
  $tag_records = exec_sql_query($db, $tag_sql)->fetchAll(PDO::FETCH_ASSOC);
  if ($tag_records){
    if (count($tag_records)>0){
      foreach($tag_records as $tags){
        array_push($tags_arr,$tags["name"]);
        }
      }
  }
  $tag_valid = TRUE;
  if (count($tag)!=0){
    foreach($tag as $uploaded_tag){
      if (!in_array($uploaded_tag, $tags_arr)){
        $tag_valid= FALSE;
      }
    }
  } else{
    $tag_valid = FALSE;
  }
  if($tag_valid){
    $params= array(
      ':dog_id' => $dog_id
    );

    $del_sql = "DELETE FROM dogs_tags WHERE dogs_tags.dog_id = :dog_id;";
    if (exec_sql_query($db, $del_sql, $params)){
      foreach($tag as $uploaded_tag){
        $params = array(
          ':tag' => $uploaded_tag
          );
        $tag_records = exec_sql_query($db, "SELECT id FROM tags WHERE name = :tag;", $params)->fetchAll(PDO::FETCH_ASSOC);
        $tag_id = $tag_records[0]["id"];
        $params= array(
          'tag_id'=>$tag_id,
          'dog_id'=>$dog_id
        );
        $rel_records = exec_sql_query($db, "INSERT INTO dogs_tags (dog_id, tag_id) VALUES (:dog_id, :tag_id);", $params);
      }
    }

  }
}

function is_in_arr($db, $dog_id, $tag_name){
  //return true if tag is associated with image
  $in_arr = FALSE;
  $sql = "SELECT DISTINCT tags.name FROM dogs_tags INNER JOIN tags ON dogs_tags.tag_id = tags.id WHERE dogs_tags.dog_id = $dog_id ORDER BY tags.name;";
  $records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
  //var_dump($records);
  foreach($records as $tag){
    if($tag["name"]==$tag_name){
      $in_arr=TRUE;
    }
  }
  return $in_arr;

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>

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
  <a class="edit_tags" href="#edit_tags"><button>Edit Tags
    </button></a>
    <div>
    <form id="delete_image" method="POST" action="index.php">
      <input type="hidden" name="dog_id" value="<?php echo $dog_id;?>">
      <input type="hidden" name="file_name" value="<?php echo $file_name;?>">
      <button onclick = "alert('Are you sure you want to delete this image?')" id="delete" name="delete_image" type="submit" value="Delete">Delete Image </button>
</form>
    </div>

<!--
    <span id="yes_confirm" class="hidden">Image Deleted Successfully</span>
    <div id="delete_popup" class="hidden">
      <span>Are you sure you want to delete this image?</span>
      <div>
        <button class="yes_del">Delete</button>
        <button class="no_del">Cancel</button>
      </div>
    </div> -->
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
    <label>Name: </label><button type="button" name="dog_name"> <?php echo  $name ?> </button>
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
      echo "<button type=\"button\" name=\"ass_tags\">$name </button>";
  }
  ?>
  </div>
</figure>

</div>

<div class="center">
<div id="edit_tags"  class="hidden">

  <button class="new_tag" name="new_tag" type="button" value="new_tag">Add a New Tag</button>
  <div id="new_form" class="hidden">
    <form id="new_tag" method="POST" action="dog.php?dog_id=<?php echo $dog_id?>">
      <input type="hidden" name="dog_id" value="<?php echo $dog_id; ?>"/>
      <div class="form_label">
      <label for="new_tag_name">Tag Name: </label>
      <input type="text" id="new_tag_name" name="new_tag_name" value="<?php echo $new_tag_name;?>"/>
        <button id="submit_new" name="submit_new" type="submit">
          <img src="images/check.png" alt="check mark"/></button>
          <cite>Icons made by <a href="https://www.flaticon.com/authors/pixel-perfect" title="Pixel perfect">Pixel perfect</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></cite>
      </div>
    </form>
  </div>

  <button class="existing_tag" name="existing_tag" type="submit" value="existing_tag">Add/Delete Existing Tags</button>
  <div id="existing_form" class="hidden">
    <form id="existing_tag" method="POST" action="dog.php?dog_id=<?php echo $dog_id?>">
    <input type="hidden" name="dog_id" value="<?php echo $dog_id; ?>"/>
      <div class="form_label">
      <label for="new_tag_name">Check/Uncheck tags: </label>
      <div class="check">
      <?php
          $records = exec_sql_query($db, "SELECT name FROM tags ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
            if (count($records)>0){
              foreach ($records as $tag){ ?>
              <div class="check">
                <input type="checkbox" name="image_tag[]"
              value="<?php echo htmlspecialchars($tag["name"])?>" id=" <?php echo htmlspecialchars($tag["name"])?>" <?php if (is_in_arr($db, $dog_id, $tag["name"])){ echo("checked"); }?> />
              <label><?php echo htmlspecialchars($tag["name"]) ?></label>
            </div>
              <?php
              }
            }
            ?>
        </div>
        <button id="submit_new" name="submit_existing" type="submit">
          <img src="images/check.png" alt="check mark"/></button>
          <cite>Icons made by <a href="https://www.flaticon.com/authors/pixel-perfect" title="Pixel perfect">Pixel perfect</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></cite>
      </div>
    </form>
  </div>

  </div>
</div>

<!-- placer
<div>
        <form id="new_tag" method="POST" action="index.php">
          <input type="hidden" name="dog_id" value="<?php echo $image["id"]; ?>">
          <button class="new_tag" name="new_tag" type="submit" value="new_tag">Add a New Tag</button>
    </form>
        </div>
        <div>
        <form id="existing_tag" method="POST" action="index.php">
          <input type="hidden" name="dog_id" value="<?php echo $image["id"]; ?>">
          <button class="existing_tag" name="existing_tag" type="submit" value="existing_tag">Add an Existing Tag</button>
    </form>
        </div>
        <div>
        <form id="del_tag" method="POST" action="index.php">
          <input type="hidden" name="dog_id" value="<?php echo $image["id"]; ?>">
          <button class="del_tag" name="del_tag" type="submit" value="del_tag">Delete a Tag</button>
    </form>
        </div>
-->

</main>

<?php include("includes/footer.php"); ?>
</body>

</html>
