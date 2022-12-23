
<?php

include("../page.php");

template_header('blog',"Vehement Works Studios blog post");
echo'

<main id="blog-bg" class="blog-bg container-fluid p-5">
    <div class="row">
';

include "../blog/blog_structure.php";

    echo '

</main>';
offcanvaslogin();
template_footer();



