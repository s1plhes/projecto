<?php
function pdo_connect_mysql() {
    // Update the details below with your MySQL details
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'web';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
// Template header, feel free to customize this
function template_header($title) {

    // Get the amount of items in the shopping cart, this will be displayed in the header.
$num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
echo <<<EOT
<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name=”viewport” content=”width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>$title</title>
    <link href="../vstyles.css" rel="stylesheet">
    <link rel="stylesheet" href="../vstyles.css" type="text/css" charset="utf-8" />
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/product.css" rel="stylesheet">
    <link href="../comments.css" rel="stylesheet">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>

    <body>
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color:#5c148c;">
     <div class="container-fluid">
    <a class="navbar-brand" href="#" style="color: white">Vehement</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup"  style="color: white;">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="../index.php"  style="color: white;">Home</a>
        <a class="nav-link" href="../shoppingcart" style="color: white;">Tienda</a>
        <a class="nav-link" href="#" style="color: white;">Pricing</a>
        <a class="nav-link disabled" style="color: white;">Disabled</a>
        <a class="nav-link" style="color: white;" href="index.php?page=cart">
            <i class="fas fa-shopping-cart"></i><span>$num_items_in_cart</span>
          </a>

      </div>
    </div>
  </div>
</nav>
EOT;
}
// Template footer
function template_footer() {
$year = date('Y');
echo <<<EOT
        </main>

  <footer class="text-center text-muted text-white" style="background-color: #000">
    <div class="container">
      <section class="mt-5">
        <div class="row text-center d-flex justify-content-center pt-5">
          <div class="col-md-2">
            <h6 class="text-uppercase font-weight-bold">
              <a href="#!" class="text-white text-decoration-none">About us</a>
            </h6>
          </div>
          <div class="col-md-2">
            <h6 class="text-uppercase font-weight-bold">
              <a href="#!" class="text-white text-decoration-none">Store</a>
            </h6>
          </div>
          <div class="col-md-2">
            <h6 class="text-uppercase font-weight-bold">
              <a href="#!" class="text-white text-decoration-none">Awards</a>
            </h6>
          </div>
          <div class="col-md-2">
            <h6 class="text-uppercase font-weight-bold">
              <a href="#!" class="text-white text-decoration-none">Help</a>
            </h6>
          </div>
          <div class="col-md-2">
            <h6 class="text-uppercase font-weight-bold">
              <a href="#!" class="text-white text-decoration-none">Contact</a>
            </h6>
          </div>
        </div>
      </section>
      <hr class="my-5" />
      <section class="mb-5">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-8">
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt
              distinctio earum repellat quaerat voluptatibus placeat nam,
              commodi optio pariatur est quia magnam eum harum corrupti
              dicta, aliquam sequi voluptate quas.
            </p>
          </div>
        </div>
      </section>

      <section class="text-center text-muted mb-5">
        <a href="" class="text-white me-4 text-decoration-none">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="" class="text-white me-4 text-decoration-none">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="" class="text-white me-4 text-decoration-none">
          <i class="fab fa-google"></i>
        </a>
        <a href="" class="text-white me-4 text-decoration-none">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="" class="text-white me-4 text-decoration-none">
          <i class="fab fa-linkedin"></i>
        </a>
        <a href="" class="text-white me-4 text-decoration-none">
          <i class="fab fa-github"></i>
        </a>
      </section>
    </div>
  <div class="text-center bg-dark p-3" >
      © 2020 Copyright:
      <a class="text-white text-decoration-none" href=""
         >zStudios</a
        >
    </div>

  </footer>


      <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
      </script>
    </body>

</html>
EOT;
}
?>
