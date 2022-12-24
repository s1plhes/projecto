<?php
include "../page.php";

$entrygetid = $_GET['page_id'];
$sql = "SELECT * FROM blog WHERE id=$entrygetid";
$sql = engine->run("SELECT * FROM blog where id = ?", [$entrygetid]);
//the header
  if ($sql->rowCount() == 0) {
    // Simple error to display if the id for the product doesn't exists (array is empty)
    template_header("Error 404",null);
    echo '<div class="alert alert-heading justify-content-center d-flex display-1">Error 404 Not found</div>
    <div class="alert justify-content-center d-flex"><h1>You are trying to acces to an invalid link you can <button class="btn btn-danger text-decoration-none text-light"><a href="../blog">Go back</a></button>
    </h1></div>';
  } else {
//Getting the data frorm the supeglobals GET by the ID of the blog entry
$row = $sql->fetch(PDO::FETCH_ASSOC);
$entrytitle = $row['title'];
$entrytxt = htmlspecialchars_decode($row['text']);
$entryauthor = urlFetch($row['author']);
$string_author = $row['author'];
$entry_image = $row['image'];
$d=strtotime($row['date']);
$entrydate = date("M d Y h:i a", $d);
$avatar = user_avatar($string_author);
$entrydesc = $row['description'];
template_header($entrytitle, $entrydesc);
echo <<<EOT

  <div class="container-fluid entry-bg">
  <!--<div class="container-fluid entry-image parallax" style="background-image: url(images/$entry_image);height: 150px; width="100%"></div>-->
    <div class="container-fluid p-4">

      <article class="entrybody placeholder-glow">
        <h1 class="fw-semibold display-1 placeholder d-flex justify-content-center">$entrytitle</h1>
        <div class="entry-data"><p class="text-dark placeholder"><img src="$avatar" alt="" style="width:40px;" class="rounded-pill">
         $entryauthor on $entrydate</p></div>
        <div class="entry-body placeholder"><span class="fw-light fs-3"><hr>$entrytxt</span></div>
      </article>
      <div class="container text-center">

EOT;
if(isset($_SESSION['loggedin'])){
  if($string_author == $_SESSION['name']){
echo <<<EOT
          
          <hr><a href="../blog/edit_entry.php?page_id=$entrygetid" class="btn btn-danger">Edit entry</a>
          <a href="../blog/delete.php?page_id=$entrygetid" class="btn btn-danger">Delete entry</a>
EOT;
  }
}       
echo <<< EOT
      </div>
      <hr>
      <h3>Comments</h3>
      <div class="comments placeholder-glow"></div>
      <hr>
    </div>
  </div>       
      
EOT;
offcanvaslogin();
      }
template_footer();
?>
        <script>
        var parts = window.location.search.substr(1).split("&");
        var $_GET = {};
        for (var i = 0; i < parts.length; i++) {
            var temp = parts[i].split("=");
            $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
        }

              const comments_page_id = $_GET['page_id']; // This number should be unique on every page
              fetch("comments.php?page_id=" + comments_page_id).then(response => response.text()).then(data => {
                document.querySelector(".comments").innerHTML = data;
                document.querySelectorAll(".comments .write_comment_btn, .comments .reply_comment_btn").forEach(element => {
                  element.onclick = event => {
                    event.preventDefault();
                    document.querySelectorAll(".comments .write_comment").forEach(element => element.style.display = 'none');
                    document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "']").style.display = 'block';
                    document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "'] input[name='name']").focus();
                  };
                });
                document.querySelectorAll(".comments .write_comment form").forEach(element => {
                  element.onsubmit = event => {
                    event.preventDefault();
                    fetch("comments.php?page_id=" + comments_page_id, {
                      method: 'POST',
                      body: new FormData(element)
                    }).then(response => response.text()).then(data => {
                      element.parentElement.innerHTML = data;
                    });
                  };
                });
              });
              </script>