<?php

include "profile/gravatar.php";
include "modules/functions.php";
include "modules/dbconnect.php";


admin_control();
function user_navbar(){

    if(isset(($_SESSION["loggedin"]))){
        $usernameNav = $_SESSION["name"];
        $sessionidNav = $_SESSION["id"];
        $linktoprofileNav = urlFetch($usernameNav);
        $gravatarNav = user_avatar($sessionidNav);
        echo <<<EOT
        <nav id="usernav" class="px-2 navbar usernavbar navbar-expand-sm">
          <div class="container-fluid">
            <div class="collapse navbar-collapse">
              <div class="col-*-*"> 
                <a class="navbar-brand" href="#">
                  <img src="$gravatarNav" alt="" style="width:40px;" class="rounded-pill"> 
                </a>
              </div>
            <div class="col-*-*"> 
              <span class="user-welcome-text">Welcome, $linktoprofileNav
            </div>
          </div>
        </div>
      </nav>
EOT;
    }
}

function template_header($title) {
  // Get the amount of items in the shopping cart, this will be displayed in the header.
$num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

echo 
<<<EOT
  <!doctype html>
  <html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>$title</title>
    <link href="../vstyles.css" rel="stylesheet">
    <link rel="stylesheet" href="../vstyles.css" type="text/css" charset="utf-8" />
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900&amp;display=swap" rel="stylesheet">
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/product.css" rel="stylesheet">
    <link href="../comments.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js" integrity="sha512-BmM0/BQlqh02wuK5Gz9yrbe7VyIVwOzD1o40yi1IsTjriX/NGF37NyXHfmFzIlMmoSIBXgqDiG1VNU6kB5dBbA==" crossorigin="anonymous"></script>
      <script src="https://cdn.tiny.cloud/1/pe0peo4u3dby0b5v7wfbd9qic4noui5v3ieejlla4ts9dd11/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  </head>

  <body>
    <nav class="vehementnavbar navbar navbar-expand-lg">
      <div class="container-fluid">
        <a class="navbar-brand" href="#" style="color: white">Vehement</a>
          <button class="navbar-toggler  bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon "></span>
          </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup"  style="color: white;">
          <div class="navbar-nav">
            <a class="nav-link active" aria-current="page" href="../index.php"  style="color: white;">Home</a>
            <a class="nav-link" href="../blog" style="color: white;">Blog</a>
EOT;
function showlogoff(){
    if(!isset(($_SESSION['loggedin']))){
        echo'<a class="btn btn-warning" data-bs-toggle="offcanvas" href="#offlogin" role="button" aria-controls="offlogin">Login</a>';
        echo'<fb:login-button scope="public_profile,email"onlogin="checkLoginState();"> </fb:login-button>';
    } else {
    // Show users the page!
        echo'<a class="btn btn-danger" href="../logoff.php" role="button">Log off</a>';
     }
 }
  $showlogin = showlogoff();

echo <<<EOT
$showlogin
            <a class="nav-link" style="color: white;" href="index.php?page=cart">
          <i class="fas fa-shopping-cart"></i><span>$num_items_in_cart</span>
        </a>
      </div>
    </div>
  </div>
</nav>
EOT;
user_navbar();
}


function template_gallery() {
echo <<<EOT
<div id="vCarousel" class="carousel slide carousel-fade" data-ride="carousel">
  <div class="carousel-inner mx-4">
    <div class="carousel-item active">
      <div class="mask flex-center">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-7 col-12 order-md-1 order-2">
              <h4>Design and development!</h4>
              <p>Vehementworks and zStudios helps you in all your problems with your site, fronted and backend.</p>
              <a href="#" class="btn btn-lg bg-light text-dark">More information</a></div>
             
            <div class="col-md-5 col-12 order-md-2 order-1"><img src="https://cdn.dribbble.com/users/2207203/screenshots/7050480/runjs_4x.png" class="mx-auto" alt="slide"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!--slide end--> 
EOT;
}

// Template footer
function template_footer() {
  $year = date('Y');
  $login =   offcanvaslogin();
echo <<<EOT
  </main>
    <footer class="vfooter text-center text-muted text-white">
      <div class="container">
      <!-- 
       <section class="">  
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

        <section class="mb-5">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt</p>
            </div>
          </div>
        </section> -->
        <section class="text-center text-muted mb-5 pt-4">
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
        <h4 id="stt"><i class="fa-solid fa-up-long text-white"></i></i></h4>
      </div>
      <div class="text-center Vcopyright p-3" >
        © 2020 Copyright
        <a class="text-white text-decoration-none" href=""
           >zStudios</a
          >
      </div>
      


  </footer>
          <script>
        $("#stt").click(function(event) {
          event.preventDefault();
            $("html").animate({ scrollTop: 0 }, "slow");
        });
        (function() {
          if (!localStorage.getItem('cookieconsent')) {
            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(request.responseText);
                var eu_country_codes = ['AL','AD','AM','AT','BY','BE','BA','BG','CH','CY','CZ','DE','DK','EE','ES','FO','FI','FR','GB','GE','GI','GR','HU','HR','IE','IS','IT','LT','LU','LV','MC','MK','MT','NO','NL','PO','PT','RO','RU','SE','SI','SK','SM','TR','UA','VA'];
                if (eu_country_codes.indexOf(data.countryCode) != -1) {
                  document.body.innerHTML += '\
                  <div class="cookieconsent" style="position:fixed;padding:20px;left:0;bottom:0;background-color:#000;color:#FFF;text-align:center;width:100%;z-index:99999;">\
                    This site uses cookies. By continuing to use this website, you agree to their use. \
                    <a href="#" style="color:#CCCCCC;">I Understand</a>\
                  </div>\
                  ';
                  document.querySelector('.cookieconsent a').onclick = function(e) {
                    e.preventDefault();
                    document.querySelector('.cookieconsent').style.display = 'none';
                    localStorage.setItem('cookieconsent', true);
                  };
                }
              }
            };
            request.open('GET', 'http://ip-api.com/json', true);
            request.send();
          }
        })();

        (function() {
          if (!localStorage.getItem('cookieconsent')) {
            document.body.innerHTML += '\
            <div class="cookieconsent" style="position:fixed;padding:20px;left:0;bottom:0;background-color:#000;color:#FFF;text-align:center;width:100%;z-index:99999;">\
              This site uses cookies. By continuing to use this website, you agree to their use. \
              <a href="#" style="color:#CCCCCC;">I Understand</a>\
            </div>\
            ';
            document.querySelector('.cookieconsent a').onclick = function(e) {
              e.preventDefault();
              document.querySelector('.cookieconsent').style.display = 'none';
              localStorage.setItem('cookieconsent', true);
            };
          }
        })();
        </script>
        $login
  </body> 
  </html>
  EOT;

  }

function offcanvaslogin(){
  echo <<<HTML
      <div class="offcanvas offcanvas-start bg-login text-light" tabindex="-1" id="offlogin" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-heade bg-login">
          <h5 class="offcanvas-title" id="offcanvasLabel">Login</h5>
          <button type="button" class="btn-close bg-light" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body bg-login">
          <form method="post" action="../login.php">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Username</label>
              <input type="text" class="form-control" name="username" placeholder="Username" id="username" required>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" name="password" placeholder="Password" class="form-control" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Log in</button>
          </form>
        </div>
        <fb:login-button perms="email,user_birthday"></fb:login-button>
      </div>
                            </div>
                            </div>

                       
HTML;

}
function blogeditorJs(){
  echo <<<EOT
            <script>
            tinymce.init({
            selector: 'textarea#editor',
            skin: 'bootstrap', //The TinyMCE Bootstrap skin
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            autosave_prefix: '{path}{query}-{id}-',
            autosave_restore_when_empty: false,
            autosave_retention: '2m',
            menubar: false,
            setup: (editor) => {
                // Apply the focus effect
                editor.on("init", () => {
                editor.getContainer().style.transition = "border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out";
                  });
                editor.on("focus", () => { (editor.getContainer().style.boxShadow = "0 0 0 .2rem rgba(0, 123, 255, .25)"),
                (editor.getContainer().style.borderColor = "#80bdff");
                  });
                editor.on("blur", () => {
                (editor.getContainer().style.boxShadow = ""),
                (editor.getContainer().style.borderColor = "");
                });
              },
            });
            </script>
            
          <script>
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '1867824083562287',
              cookie     : true,
              xfbml      : true,
              version    : '{api-version}'
            });
              
            FB.AppEvents.logPageView();   
              
          };

          (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));

          $(function() {
            $.ajax({
              url: '//connect.facebook.net/es_ES/all.js',
              dataType: 'script',
              cache: true,
              success: function() {
                FB.init({
                  appId: '1867824083562287',
                  xfbml: true
                });
                FB.Event.subscribe('auth.authResponseChange', function(response) {
                  if (response && response.status == 'connected') {
                    FB.api('/me', function(response) {
                      alert('Nombre: ' + data.name);
                    });
                  }
                });
              }
            });
          });
          </script>
        
  EOT;
}
?>
