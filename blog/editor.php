
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
    
template_header("editor");
?>

    <body>
    <div class="container mt-4 mb-4">
        <!--Bootstrap classes arrange web page components into columns and rows in a grid -->
        <div class="row justify-content-md-center">
            <div class="col-md-12 col-lg-8">
                <h4 class="h2 mb-4">Welcome <?= $_SESSION["name"]?>,Post a blog entry</h4>
                    <div class="form-group">
                        <form id="blogEditor" action="../blog/post_entry.php" method="post">
                        <fieldset>
                            <label>Title</label>
                                <input id="title" name="title" class="form-control" type="text" placeholder="write a tittle">
                            <label class="form-label">Body</label>
                            <div class="form-floating">
                                <textarea class="form-control" id="editor" name="editor"></textarea>
                                </div>
                            <label>Description</label>
                                <input id="description" name="description" class="form-control" type="text" placeholder="write a short description">
                            <input type="submit" name="Submit" value="Submit" class="btn btn-primary"></input>
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