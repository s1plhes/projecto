<?php

include "../page.php";

//Getting the data frorm the supeglobals GET by the ID of the blog entry
    $entrygetid = $_GET['page_id'];
    $sql = "SELECT * FROM blog WHERE id=$entrygetid";
    $result = mysqli_query(conn,$sql);
    $row = mysqli_fetch_assoc($result);
        if (!$row) {
            // Simple error to display if the id for the product doesn't exists (array is empty)
            $result_error = "No data";
        }
    $entrytitle = $row['title'];
    $entrytxt = htmlspecialchars_decode($row['text']);
    $entryauthor = urlFetch($row['author']);
    $entrydate = $row['date'];

//the header
template_header($entrytitle);

echo <<<EOT
        <div class="container-fluid">
            <div class="container-fluid p-4 bg-light">
                <article class="entrybody">
                    <h1 class="fw-semibold display-1">$entrytitle</h1>
                    <p class="text-dark">written by $entryauthor on $entrydate</p><hr>
                    <span class="fw-light fs-3">$entrytxt</span>
                </article>
            <div class="container text-center">
            <hr>
     EOT;
        function nav_blog_btn(){
            $entryget = $_GET['page_id'];
            $btn1 = $entryget + 1;
            $btn2 = $entryget - 1; 
            if ($entryget < 2){
                echo <<<EOT
                    <button class="btn btn-dark"><a class="text-decoration-none text-light" href="entry.php?page_id=$btn1">Siguiente<a></button>
                EOT;
            } else {
                echo <<<EOT
                    <button class="btn btn-dark"><a class="text-decoration-none text-light" href="entry.php?page_id=$btn2">Anterior<a></button>          
                    <button class="btn btn-dark"><a class="text-decoration-none text-light" href="entry.php?page_id=$btn1">Siguiente<a></button>
                EOT;
            }
        }
        $nav_blog_btn_var = nav_blog_btn();
        if(isset(($_SESSION["isadmin"]))) {
          $id = $_GET['page_id'];
          echo <<<EOT
          <a href="../blog/edit_entry.php?page_id=$id" class="btn btn-danger">Edit this entry</a>
        EOT;
        }
echo <<< EOT
  </div>
  <hr>
  
  <h3>Comements</h3>
  <div class="comments"></div>
  <hr>
  </div>
  </div>       
EOT;
                      
offcanvaslogin();
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
      </body>
      </html>
