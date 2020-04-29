<?php include("includes/init.php");

const MAX_SIZE = 1000000;
$tags_arr = [];
$sql = "SELECT * FROM tags";
$records = exec_sql_query($db, $sql);
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
    $tag = filter_input(INPUT_POST, 'image_tag', FILTER_SANITIZE_STRING);
    $citation= filter_input(INPUT_POST, 'image_citation', FILTER_SANITIZE_URL);
    $show_name_feedback = FALSE;
    $show_citation_feedback = FALSE;
    $show_size_feedback = FALSE;
    $show_file_feedback = FALSE;

    var_dump("Dog name:".$dog_name);
    var_dump("Tag:".$tag);
    var_dump("Citation:".$citation);

    //first make sure name, citation and file is not empty
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
    var_dump("file size:".$uploaded_file);
    var_dump("name feedb:".$show_name_feedback);

    //validate choosen tag
    $tag_choosen = FALSE;
    $new_tag = FALSE;
    $show_tag_feedback = FALSE;
    if (!empty($tag)){
      if ($tag=="Other"){
        $new_tag = TRUE;
        $tag_choosen = TRUE;
      } else{
        if (in_array($tag, $tags_arr)){
          $tag_choosen= TRUE;
        } else{
          $valid_submit = FALSE;
          $show_tag_feedback = TRUE;
        }
      }
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
          $new_dog_id;
          if (exec_sql_query($db, $sql, $params)){
              $new_path = "uploads/dogs/".$db->lastInsertID("id").".".$file_ext;
              move_uploaded_file($uploaded_file["tmp_name"], $new_path);
              $new_dog_id = $db->lastInsertID("id");
          }
          var_dump("upload:".$new_path);

          if ($new_tag){
            $params = array(
              ':tag' => $tag
              );
            if (exec_sql_query($db, "INSERT INTO tags (name) VALUES (:tag);", $params)){
              $records = exec_sql_query($db, "INSERT INTO dogs_tags (dog_id, tag_id) VALUES ($new_dog_id,".$db->lastInsertID("id")." );");
            }
          } else if ($tag_choosen){
            $records = exec_sql_query($db, "INSERT INTO dogs_tags (dog_id, tag_id) VALUES ($new_dog_id,".$db->lastInsertID("id")." );");
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/site.css" media="all" />

  <title>DOGGOS</title>
</head>

<body>
  <header>
    <?php include("includes/header.php"); ?>
  </header>
<main>

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
        <label for="image_tag">Choose a tag(s):</label>
        <select name="image_tag" id="image_tag">
            <option value="">--Please choose an option--</option>
            <?php
            $records = exec_sql_query($db, "SELECT name FROM tags ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
              if (count($records)>0){
                foreach ($records as $tag){
                echo "<option value=\"".htmlspecialchars($tag["name"])."\">". htmlspecialchars($tag["name"]) ."</option>";
                }
              }
            ?>
            <option value="Other">Other</option>
        </select>
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
