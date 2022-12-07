
<?php
use PhpParser\Node\Expr\Isset_;
use Psy\Readline\Hoa\Console;

include "../page.php";

if(!isset(($_SESSION["loggedin"]))) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'index.php';
    header("Location: http://$host$uri/$extra");
    exit;
}

$getid = $_GET['page_id'];
$sql = mysqli_query(conn, "SELECT * FROM blog WHERE id=$getid");
$result = mysqli_fetch_assoc($sql);

$lastTitle = $result['title'];
$lastBody = $result['text'];
$lastDesc = $result['description'];
$lastId = $_GET['page_id'];
    
template_header("editor");
?>

    <body>
    <div class="container mt-4 mb-4">
        <!--Bootstrap classes arrange web page components into columns and rows in a grid -->
        <div class="row justify-content-md-center">
            <div class="col-md-12 col-lg-8">
                <h4 class="h2 mb-4">Welcome <?= $_SESSION["name"]?>,Post a blog entry</h4>
                    <div class="form-group">
                        <form id="blogEditor" action="../blog/update_entry.php?page_id=<?=$_GET['page_id']?>" method="post">
                        <fieldset>
                            <label>Title</label>
                                <input id="title" name="title" value="<?=$lastTitle?>" class="form-control" type="text" placeholder="<?=$lastTitle?>">
                            <label class="form-label">Body</label>
                            <div class="form-floating">
                                <textarea class="form-control" id="editor" name="editor"><?=$lastBody?></textarea>
                                </div>
                            <label>Description</label>
                                <input id="description" value="<?=$lastTitle?>" name="description" class="form-control" type="text" placeholder="<?=$lastDesc?>">
                            <input type="submit" name="Submit" value="Submit" class="btn btn-primary"></input>
                            <input id="entryid" name="entryid" placeholder="<?=$_GET['page_id']?>" class="invisible"></input>
                        </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?=blogeditorJs()?>
    </body>
</html>