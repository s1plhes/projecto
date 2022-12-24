
<?php
if(isset(($_SESSION['loggedin']))){
 // $editor = htmlspecialchars("../blog/editor.php", ENT_QUOTES, null, TRUE);
  $editor = htmlspecialchars("../blog/editor.php");
 echo
  <<<EOT
              <nav class="blog-admin-bar navbar sticky-top">
              <a href="$editor" class="btn btn-danger mx-auto">Create a entry</a>
            </nav>
EOT;

            }
?>

    <div class="col-md-12">
      <div class="case">
          <div class="row" style="padding-right:0px;">
          
<?php

//Post data
$sql = engine->run("SELECT * FROM blog ORDER BY id DESC");
if ($sql->rowCount() > 0) {
  // output data of each row
  while($item = $sql->fetch(PDO::FETCH_ASSOC)) {
    $title = $item["title"];
    $date = $item["date"];
    $author = profileLink($item["author"]);
    $text = $item["text"];
    $entryid = $item["id"];
    $desc = $item["description"];
    $category = $item["category"];
    $entryimg = $item["image"];
    $time = time_elapsed_string($date);
//Post data

echo 
<<<EOT
<div class="row bg-entry mb-2" style="padding-left: 0px; padding-right: 0px;  margin: auto;">
  <div class="col-md-6 col-lg-6 col-xl-8 d-flex placeholder-glow shadow" style="padding-left: 0px; padding-right: 0px; margin-left: auto;">
    <a href="entry.php?page_id=$entryid" class="img w-100 mb-3 mb-md-0 placeholder" style="background-image: url(images/$entryimg);background-size: cover"></a>
  </div>
  <div class="col-md-6 col-lg-6 col-xl-4 d-flex">
    <div class="text w-100 pl-md-3 mt-3 placeholder-glow">
      <span class="subheading placeholder">$category</span>
      <h2><a class="blog-title hover-1 text-decoration-none placeholder" href="entry.php?page_id=$entryid">$title</a></h2>
      <h3 class="placeholder">$desc</h3>
        <ul class="media-social list-unstyled">
          <li class="ftco-animate fadeInUp ftco-animated" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
              <a href="#"><span><i class="fa-brands fa-twitter"></span></i></a></li>
          <li class="ftco-animate fadeInUp ftco-animated" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
              <a href="#"><span><i class="fa-brands fa-facebook"></span></i></a></li>
          <li class="ftco-animate fadeInUp ftco-animated" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
              <a href="#"><span><i class="fa-brands fa-instagram" ></span></i></a></li>
        </ul>
      <div class="meta">
        <p class="mb-0 mx-auto placeholder">Wrote by $author $time</p>
      </div>
    </div>
  </div>
</div>
EOT;
  }
} else {
  echo "0 results";
}

//Cerrando conexion de la base de datos

?>

</div>
</div>
</div>