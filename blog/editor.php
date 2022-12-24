
<?php
include "../page.php";

if(!isset(($_SESSION["loggedin"]))) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'index.php';
    header("Location: http://$host$uri/$extra");
    exit;
}
    
template_header("editor",null);
?>

    <body>
    <div class="container mt-4 mb-4">
        <!--Bootstrap classes arrange web page components into columns and rows in a grid -->
        <div class="row justify-content-md-center">
            <div class="col-md-12 col-lg-8">
                <h4 class="h2 mb-4">Welcome <?= $_SESSION["name"]?>,Post a blog entry</h4>
                    <div class="form-group">
                        <form id="blogEditor" action="../blog/post_entry.php" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <label>Title</label>
                                <input id="title" name="title" class="form-control" type="text" placeholder="write a tittle" required>
                            <label class="form-label">Body</label>
                            <div class="form-floating">
                                <textarea class="form-control input-group-text" id="editor" name="editor" required></textarea>
                                </div>
                                <label for="image">Choose Image</label>
                                <input type="file" class="form-control" name="uploadfile" accept="image/*" required >
                                <label>Description</label>
                                <input id="description" name="description" class="form-control" type="text" placeholder="write a short description" required>
                            <input type="submit" name="Submit" value="Submit" class="btn btn-veh"></input>
                        

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