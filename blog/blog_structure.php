
<?php
if(isset(($_SESSION['loggedin']))){
              echo
  <<<EOT
              
              <nav class="blog-admin-bar navbar sticky-top">
              <a href="../blog/editor.php" class="btn btn-danger mx-auto">Create a entry</a>
            </nav>
  EOT;

            }?>

    <div class="col-md-12">
      <div class="case">
          <div class="row" style="padding-right:0px;">
          
<?php

//Post data
$sql = "SELECT * FROM blog ORDER BY id DESC";
$result = conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($item = $result->fetch_assoc()) {
    $title = $item["title"];
    $date = $item["date"];
    $author = urlFetch($item["author"]);
    $text = $item["text"];
    $entryid = $item["id"];
    $desc = $item["description"];
    $entryimg = $item["image"];
    $time = time_elapsed_string($date);
//Post data

echo 
<<<EOT
<div class="row bg-entry text-light mb-2" style="padding-left: 0px; padding-right: 0px;  margin: auto;">
  <div class="col-md-6 col-lg-6 col-xl-8 d-flex" style="padding-left: 0px; padding-right: 0px; margin-left: auto;">
    <a href="entry.php?page_id=$entryid" class="img w-100 mb-3 mb-md-0" style="background-image: url(../images/$entryimg);"></a>
  </div>
  <div class="col-md-6 col-lg-6 col-xl-4 d-flex">
    <div class="text w-100 pl-md-3 mt-3">
      <span class="subheading">Application</span>
      <h2><a class="blog-title text-decoration-none" href="entry.php?page_id=$entryid">$title</a></h2>
      <h3>$desc</h3>
        <ul class="media-social list-unstyled">
          <li class="ftco-animate fadeInUp ftco-animated"><a href="#"><span><i class="fa-brands fa-twitter"></span></i></a></li>
          <li class="ftco-animate fadeInUp ftco-animated"><a href="#"><span><i class="fa-brands fa-facebook"></span></i></a></li>
          <li class="ftco-animate fadeInUp ftco-animated"><a href="#"><span><i class="fa-brands fa-instagram"></span></i></a></li>
        </ul>
      <div class="meta">
        <p class="mb-0 mx-auto text-light">$time</p>
      </div>
    </div>
  </div>
</div>
EOT;
  }
} else {
  echo "0 results";
}
conn->close();
//Cerrando conexion de la base de datos

?>

</div>
</div>
</div>

    <?=offcanvaslogin()?>