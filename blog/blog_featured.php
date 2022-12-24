<?php

include "../modules/functions.php";

$sql = engine->run("SELECT * FROM blog ORDER BY id DESC LIMIT 1 ");
if ($sql->rowCount() > 0) {
  // output data of each row
  while($item = $sql->fetch(PDO::FETCH_ASSOC)) {
Echo '
<div class="p-4 p-md-5 mb-4 rounded bg-dark text-light text-center" style="background-image: url('.$item["image"].';">
    <div class=" px-0">
      <h1 class="display-4 fst-italic">'. $item["title"]. '</h1>
      <p class="lead my-3">'. $item["description"]. '.</p>
      <p class="lead mb-0"><a href="entry.php?page_id='.$item["id"].'" class="text-white fw-bold">Continue reading...</a></p>
    </div>
</div>
';

}
} else {
  echo "0 results";
}
$conn->close();
?>