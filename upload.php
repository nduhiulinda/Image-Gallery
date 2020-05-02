<?php include("includes/init.php");

const MAX_SIZE = 1000000;
$tags_arr = [];
$sql = "SELECT * FROM tags";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
if ($records){
  if (count($records)>0){
    foreach($records as $tag){
      array_push($tags_arr,$tag["name"]);
      }
    }
}

$new_dog_id;
$show_upload_conf = FALSE;
if (isset($_POST["submit_upload"])){
    $dog_name = trim($_POST['image_name']);
    $dog_name = filter_input(INPUT_POST, 'image_name', FILTER_SANITIZE_STRING);
    $uploaded_file = $_FILES["image_file"];
    $valid_submit = TRUE;
    $tag = $_POST["image_tag"];
    $citation= filter_input(INPUT_POST, 'image_citation', FILTER_SANITIZE_URL);
    $show_name_feedback = FALSE;
    $show_citation_feedback = FALSE;
    $show_size_feedback = FALSE;
    $show_file_feedback = FALSE;

    //Make sure name, citation and file is not empty
    if (empty($dog_name)){
      $show_name_feedback = TRUE;
      $valid_submit = FALSE;
    }

    if (empty($citation)){
      $show_citation_feedback = TRUE;
      $valid_submit = FALSE;
    }

    if ($uploaded_file['error']==4){
      $show_file_feedback= TRUE;
      $valid_submit = FALSE;
    }

    if ($uploaded_file['size']>MAX_SIZE){
      $show_size_feedback=TRUE;
      $valid_submit = FALSE;
    }

    //validate choosen tag
    $tag_choosen = TRUE;
    $show_tag_feedback = FALSE;
    if (count($tag)!=0){
      foreach($tag as $uploaded_tag){
        if (!in_array($uploaded_tag, $tags_arr)){
          $tag_choosen= FALSE;
          $valid_submit = FALSE;
          $show_tag_feedback = TRUE;
        }
      }
    } else{
      $tag_choosen = FALSE;
    }

    //validate file and add to DB
    if ($valid_submit){
      if ($uploaded_file['error']==UPLOAD_ERR_OK){
          $file_name = basename($uploaded_file["name"]);
          $file_ext = strtolower((pathinfo($file_name, PATHINFO_EXTENSION)));
          $params = array(
              ':name' => $dog_name,
              ':file_name' => $file_name,
              ':file_ext' => $file_ext,
              ':citation' => $citation
          );

          $sql = "INSERT INTO dogs (name, file_name, file_ext, citation) VALUES (:name, :file_name, :file_ext, :citation);";
          $dog_records= exec_sql_query($db, $sql, $params);
          $new_dog_id = $db->lastInsertID("id");

          if ($tag_choosen){
            //get tag id
            foreach($tag as $uploaded_tag){
              $params = array(
                ':tag' => $uploaded_tag
                );
              $records = exec_sql_query($db, "SELECT id FROM tags WHERE name = :tag;", $params)->fetchAll(PDO::FETCH_ASSOC);
              $new_tag_id = $records[0]["id"];

              $params= array(
                'new_tag_id'=>$new_tag_id,
                'new_dog_id'=>$new_dog_id
              );
              $rel_records = exec_sql_query($db, "INSERT INTO dogs_tags (dog_id, tag_id) VALUES (:new_dog_id, :new_tag_id);", $params);
            }

            if ($rel_records && $dog_records){
              $new_path = "uploads/dogs/".$new_dog_id.".".$file_ext;
              move_uploaded_file($uploaded_file["tmp_name"], $new_path);
            }
            $show_upload_conf = TRUE;
          }
        } else{
          $show_size_feedback = TRUE;
        }

      }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <title>DOGGOS</title>
</head>

<body>
  <header>
    <?php include("includes/header.php"); ?>
  </header>
<main>

<?php
  if($show_upload_conf) { ?>

    <h1>Image Successfully Uploaded!</h1>
    <h2>Here's your new records:</h2>

    <?php
      $sql = "SELECT * FROM dogs WHERE id= $new_dog_id ORDER BY dogs.name;";
      $records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
      foreach ($records as $dog){
          $dog_name = htmlspecialchars($dog["name"]);
          $file_name = "uploads/dogs/".$dog["id"] . "." . $dog["file_ext"];
          $citation = $dog["citation"];
       ?>
       <figure>
        <img src="<?php echo $file_name ?>" alt="<?php echo $dog_name ?>"/>

       <div class="content">

         <label>Name:</label><span><?php echo $dog_name; ?></span>
         <label>Citation:</label><span><?php echo $citation; ?></span>
         <label>Tags:</label><span>

       <?php }
      $tag_sql = "SELECT DISTINCT tags.name FROM dogs_tags INNER JOIN tags ON dogs_tags.tag_id = tags.id WHERE dogs_tags.dog_id = $new_dog_id ORDER BY tags.name;";
      $tag_records = exec_sql_query($db, $tag_sql)->fetchAll(PDO::FETCH_ASSOC);
      foreach ($tag_records as $tag){
        $tag_name = htmlspecialchars($tag["name"]);
        ?>
        <?php echo $tag_name; ?>  </span></figure>
        </div>
        <?php
      }
    ?>

  <?php }else{
   ?>

<h1>Upload an image</h1>

<p>To upload an image of a dog, fill the form and indicate which tag(s) are associated with the dog. Only .jpg, .jpeg and .png files are accepted. Required fields are marked with an asterisk *.</p>

<form id="upload_file" enctype="multipart/form-data" method="POST" action="upload.php" novalidate>

    <input type="hidden" name="MAX_SIZE" value="<?php echo MAX_SIZE; ?>" />

    <div class="form_label">
    <span class="feedback">
    <?php if($show_name_feedback) {echo "Kindly provide the dog's name";}?>
    </span>
        <label for="image_name">Dog Name*:</label>
        <input id="image_name" type="text" name="image_name" value="<?php echo $dog_name;?>" required>
    </div>

    <div class="form_label">
    <span class="feedback">
    <?php if($show_file_feedback) {echo "Kindly select a file to upload";}; if($show_size_feedback){echo "Kindly upload a file below 1MB";}?>
    </span>
        <label for="image_file">Upload file*:</label>
        <input id="image_file" type="file" name="image_file" accept="image/png, image/jpeg" required>
    </div>

    <div class="form_label">
    <span class="feedback">
    <?php if($show_tag_feedback) {echo "Kindly choose a tag provided in the menu";}?>
    </span>
    <div class="check_label">
        <label >Choose a tag(s):</label></div>

            <?php
            $records = exec_sql_query($db, "SELECT * FROM tags ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
              if (count($records)>0){
                foreach ($records as $tag){
                echo "<div class=\"check\"><input type=\"checkbox\" name=\"image_tag[]\"
               value=\"".htmlspecialchars($tag["name"])."\" id=\"".htmlspecialchars($tag["id"])."\"><label>
                ".htmlspecialchars($tag["name"])."</label></div>";
                }
              }
            ?>

    </div>

    <div class="form_label">
    <span class="feedback">
    <?php if($show_citation_feedback) {echo "Kindly provide the image citation URL";}?>
    </span>
        <label for="image_citation">Image Source URL*:</label>
        <input id="image_citation" type="url" name="image_citation" value="<?php echo $citation;?>" required>
    </div>

    <div class="form_label">
        <button id="submit_upload" name="submit_upload" type="submit"><img src="images/upload_button.png" alt="Upload Icon"/></button>
    </div>

</form>

            <?php } ?>
</main>

</body>
</html>
