<?php

// Update the details below with your MySQL details
date_default_timezone_set("America/Caracas");
include("../modules/functions.php");
// Below function will convert datetime to time elapsed string
function comment_avatar($user_avatar_name){
	if(isset($user_avatar_name))
	{   
    $sql = engine->run("SELECT email FROM accounts WHERE username = ?", [$user_avatar_name]);
    $result = $sql->fetch(PDO::FETCH_ASSOC);
		$email = $result['email'];
		$default = "https://www.somewhere.com/homestar.jpg";
		$size = 400;
		$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
		return $grav_url;
	}
}

// This function will populate the comments and comments replies using a loop
function show_comments($comments, $parent_id = -1) {
  $html = '';
  if ($parent_id != -1) {
      // If the comments are replies sort them by the "submit_date" column
      array_multisort(array_column($comments, 'submit_date'), SORT_ASC, $comments);
  }
  // Iterate the comments using the foreach loop
  foreach ($comments as $comment) {
      if ($comment['parent_id'] == $parent_id) {
          // Add the comment to the $html variable
          $commentname = $comment["name"];
          $gravatar = comment_avatar($commentname);
          $html .= '
        <div class="comment ">
            <div>
                <img src="'. $gravatar .'" alt="" style="width:40px;" class="rounded-pill"> 
                <h3 class="name ">' . htmlspecialchars($comment['name'], ENT_QUOTES) . '</h3>
                <span class="date ">' . time_elapsed_string($comment['submit_date']) . '</span>
                </div>
                <p class="content ">' . nl2br(htmlspecialchars($comment['content'], ENT_QUOTES)) . '</p>
                <a class="reply_comment_btn " href="#" data-comment-id="' . $comment['id'] . '">Reply</a>
                ' . show_write_comment_form($comment['id']) . '
                <div class="replies ">
                ' . show_comments($comments, $comment['id']) . '
                </div>
          </div>
          ';
      }
  }
  return $html;
}
// This function is the template for the write comment form
function show_write_comment_form($parent_id = -1) {
  $html = '
  <div class="write_comment" data-comment-id="' . $parent_id . '">
      <form>
          <input name="parent_id" type="hidden" value="' . $parent_id . '">
          <textarea name="content" ="Write your comment here..." required></textarea>
          <button type="submit">Submit Comment</button>
      </form>
  </div>
  ';
  return $html;
}
// Page ID needs to exist, this is used to determine which comments are for which page
if (isset($_GET['page_id'])) {
  // Check if the submitted form variables exist
  if (isset($_POST['content'])) {
    $username = $_SESSION['name'];
      // POST variables exist, insert a new comment into the MySQL comments table (user submitted form)
      $data = [
        'page_id' => $_GET['page_id'],
        'parent_id' => $_POST['parent_id'],
        'name' =>  $username,
        'content' => $_POST['content'],
        'submit_date' => 'NOW()'
        ];
        $insert = engine->insert('commnets', $data);
      exit('Your comment has been submitted!');
  }
  // Get all comments by the Page ID ordered by the submit date
  $stmt = engine->run("SELECT * FROM comments WHERE page_id = ? ORDER BY submit_date DESC", [$_GET['page_id']]);
  $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // Get the total number of comments
  $stmt = engine->run("SELECT COUNT(*) AS total_comments FROM comments WHERE page_id = ?",[ $_GET['page_id']]);
  $comments_info = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
  exit('No page ID specified!');
}

function show_comments_btn(){

    if(!isset(($_SESSION['loggedin']))){
        echo'<a href="#offlogin" data-bs-toggle="offcanvas" aria-controls="offlogin><button type="button" class="btn btn-warning">Log in to comment</button></a>';
    } else {
    // Show users the page!
        echo'<a href="#" class="write_comment_btn" data-comment-id="-1">Write Comment</a>';
     }
 }
?>

<div class="comment_header">
    <span class="total"><?=$comments_info['total_comments']?> comments</span>
    <?=show_comments_btn()?>
</div>

<?=show_write_comment_form()?>

<?=show_comments($comments)?>