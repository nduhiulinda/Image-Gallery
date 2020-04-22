<?php include("includes/init.php");

const MAX_SIZE = 1000000;
$db = open_or_init_sqlite_db('secure/site.sqlite', 'secure/init.sql');
$sql = "SELECT name FROM tags ORDER BY name;";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);

?>
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

<h1>Upload an image</h1>

<p>To upload an image of a dog, fill the form and indicate which tag(s) are associated with the dog. Only .jpg and .png files are accepted.</p>

<form id="upload_file" enctype="multipart/form-data" method="POST" action="upload.php">
    <input type="hidden" name="MAX_SIZE" value="<?php echo MAX_SIZE; ?>" />
    <div class="form_label">
        <label for="image_name">Dog Name:</label>
        <input id="image_name" type="text" name="image_name">
    </div>

    <div class="form_label">
        <label for="image_file">Upload file:</label>
        <input id="image_file" type="file" name="image_file">
    </div>

    <div class="form_label">
        <label for="image_tag">Choose a tag(s):</label>
        <select name="image_tag" id="image_tag">
            <option value="">--Please choose an option--</option>
            <?php
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
        <button id="submit_upload" name="submit_upload" type="submit">Upload Image</button>
    </div>



</form>
</main>
</body>
</html>
