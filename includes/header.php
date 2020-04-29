
<?php

$sql = "SELECT * FROM tags ORDER BY tags.name;";
$records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC);
foreach ($records as $tags){
  $name = $tags["name"];
  $id = $tags["id"];
}

?>
<nav>
    <ul>
      <li class="<?php echo ($tag == 0) ? 'curr_tag' : '' ?>"><a href="index.php">All Dogs</a></li>
      <?php
      foreach ($records as $tags){
        echo "<li class=\"curr_tag\"><a href=\"tag.php?". http_build_query(array('tag_id' => $tags["id"])). "\">" .$tags["name"]."</a></li>";
      }
      ?>
    </ul>
  </nav>
