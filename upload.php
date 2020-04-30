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

<h1>Upload an image</h1>

<p>To upload an image of a dog, fill the form and indicate which tag(s) are associated with the dog. Only .jpg, .jpeg and .png files are accepted. Required fields are marked with an asterisk *.</p>

<form id="upload_file" enctype="multipart/form-data" method="POST" action="upload.php" >

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
        <label for="image_tag">Choose a tag(s):</label>

            <?php
            $records = exec_sql_query($db, "SELECT name FROM tags ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
              if (count($records)>0){
                foreach ($records as $tag){
                echo "<div class=\"check\"><input type=\"checkbox\" name=\"image_tag[]\"
               value=\"".htmlspecialchars($tag["name"])."\" id=\"".htmlspecialchars($tag["name"])."\"><label>
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
        <button id="submit_upload" name="submit_upload" type="submit">Upload Image</button>
    </div>

</form>
</main>

<?php include("includes/footer.php"); ?>

</body>
</html>
