<?php

include "profile/gravatar.php";
include "modules/functions.php";
include "modules/dbconnect.php";
include "modules/lang/english.php";

date_default_timezone_set("America/Caracas");
$pdo = pdo_connect_mysql();

//Dolar Price direct from Dolar Today
define('dolarPrice', dolar());

function showlogoff(){
  if(!isset(($_SESSION['loggedin']))){
    return '
    <a class="text-decoration-none" data-bs-toggle="offcanvas" href="#offlogin" role="button" aria-controls="offlogin"><i class="fas fa-lg fa-sign-in-alt"></i></a>
    ';
  } else {
  // Show users the page!
    return '<a class="text-black text-decoration-none" href="../modules/logoff.php"><i class="fas fa-lg fa-sign-out-alt"></i></a>';
  }
}

function adminBtn(){
  if(isset(($_SESSION['loggedin']))){
    if($_SESSION['id'] == 1){
      return <<<EOT
      <a class="text-decoration-none" href="../admin"><i class="fas fa-lg fa-key"></i></a>
    EOT;
      }
  }
}


function user_navbar2(){
  if(isset(($_SESSION["loggedin"]))){
    $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    $usernameNav = $_SESSION["name"];
    $sessionidNav = $_SESSION["id"];
    $linktoprofileNav = urlFetch($usernameNav);
    $gravatarNav = user_avatar($sessionidNav);
    $admin_button = adminBtn();

    return <<<users

          <div class="col" style="display: contents;">
            <span class="user-welcome-text">Welcome, $linktoprofileNav</span>
          </div>

          <div class="col">
            <a class="navbar-brand" href="#">
              <img src="$gravatarNav" alt="" style="width:40px;" class="rounded-pill">
            </a>
          </div>

          <div class="col">
            <a id="cart" class="nav-link" href="../shop/index.php?page=cart">
            <i class="fas fa-lg fa-shopping-cart"></i> $num_items_in_cart</a>
          </div>

          <div class="col">
            $admin_button
          </div>


users;
  }
}


function user_navbar(){
        // Get the amount of items in the shopping cart, this will be displayed in the header.
        $showlogin = showlogoff();
        $welcome = user_navbar2();
        echo <<<EOT
        <nav class="px-2 navbar usernavbar navbar-expand-lg">
          <div class="container-fluid nav-col-fluid">
            <div class="">
              <div class="row user-nav-row">

                <div class="navcol">
                  <div class="navbar-nav collapse navbar-collapse" id="navbarNavAltMarkup">
                      <a class="nav-link active" aria-current="page" href="../index.php"  style="color: white;">Home</a>
                      <a class="nav-link" href="../blog" style="color: white;">Blog</a>
                      <a class="nav-link" href="../shop" style="color: white;">Shop</a>
                  </div>                
                </div>

                <div class="col">
                $showlogin
                </div>

                $welcome
                
              </div>
            </div>
          </div>
        </nav>
EOT;

}

function template_header($title,$description) {
          // Get the amount of items in the shopping cart, this will be displayed in the header.
          $sitename = txt['site_name'];
          $theme = themeChecker();
echo
<<<EOT
  <!doctype html>
  <html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="$description">
    <meta name="author" content="Joseph Hurtado">
    <meta name=”robots” content=”index, follow”>
    <title>$title</title>
    $theme
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="../vscripts.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tiny.cloud/1/pe0peo4u3dby0b5v7wfbd9qic4noui5v3ieejlla4ts9dd11/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  </head>

<body onload="rph()">
  <nav class="vehementnavbar navbar navbar-expand-lg justify-content-center">
    <div class="row">
      <div class="col">
        <span id="vlogo" class="brand vehement" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom">$sitename</span>
      </div>
    </div>
    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
  </nav>

EOT;
user_navbar();
}


function template_gallery() {
echo <<<EOT

EOT;
}

// Template footer
function template_footer() {
  $year = date('Y');
echo <<<EOT
  </main>
    <footer class="vfooter text-center text-muted text-white">
      <div class="container mt-auto">
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
           >Vehement Works</a
          >
      </div>
  </footer>

          <script>
        $("#stt").click(function(event) {
          event.preventDefault();
            $("html").animate({ scrollTop: 0 }, "slow");
        });
        </script>
        
        <script>
        Swal.bindClickHandler()

        Swal.mixin({
          toast: true,
        }).bindClickHandler('data-swal-toast-template')
        </script>

        <script>
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

        <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        </script>

        <script>
        const phrase = "Vehement";
        const targetEl = document.getElementById("vlogo");
        
        phrase.split("").map((char, idx) => {
            const el = document.createElement("span");
            el.innerText = char;
            el.setAttribute("data-index", idx.toString());
            el.classList.add("hover-char");
            targetEl.appendChild(el);
        });
        
        const hoverChars = [...document.getElementByClassName("hover-char")];
        
        const removeClasses = {
            hoverChars.map((char) => {
                char.classList.remove("hovered");
                char.classList.remove("hovered-adjacent");
            });
        };
        
          hoverChars.map((char) => {
              char.addEventListener("mouseover", (e) => {
                removeClasses();
                const currentElement = e.target;
                const index = parseInt(currentElement.getAttribute("data-index"),10);
        
                const prevIdnex = index === 0 ? null : index - 1;
                const nextIndex = index === phrase.length - 1 ? null : index + 1;
        
                const prevEl =
                prevIdnex !== null &&
                document.querySelector(`[data-index="$(prevIndex)"]`);
        
                const nextEl =
                nextIdnex !== null &&
                document.querySelector(`[data-index="$(nextIndex)"]`);
        
                e.target.classList.add("hovered");
                prevEl && prevEl.classList.add("hovered-adjacent");
                nextEl && nextEl.classList.add("hovered-adjacent");
            });
        });
            document.getElementById("vlogo").addEventListener("mouseleave",() =>{
                removeClasses();
              });
        
              });

        </script>

    </body>
  </html>
  EOT;

  }

function offcanvaslogin(){
  echo <<<HTML
      <div class="offcanvas offcanvas-start bg-login text-light" tabindex="-1" id="offlogin" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-heade bg-login">
    
          <button type="button" class="btn-close bg-light" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body bg-login justify-content-center">
        <h5 class="offcanvas-title" id="offcanvasLabel">Login</h5>
          <form method="post" action="../modules/login.php">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Username</label>
              <input type="text" class="form-control" name="username" placeholder="Username" id="username" required>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" name="password" placeholder="Password" class="form-control" id="password" required>
            </div>
            <button type="submit" class="btn btn-login">Log in</button>
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


            $(function () {
              $('[data-toggle="tooltip"]').tooltip()
           });
            
            </script>
  EOT;
}

function admin_nav(){
echo <<<admin_nav
  <nav class="px-2 navbar bg-black navbar-expand-lg">
<div class="container-fluid ">
      <div class="row d-flex justify-content-start">
      <div class="col align-self-center">
      <a class="nav-link active" style="color: white;" href="index.php">Dashboard</a>
      </div>
        <div class="col align-self-center">
        <a class="nav-link" style="color: white;" href="users.php">Users</a>
        </div>
        <div class="col align-self-center">
        <a class="nav-link" style="color: white;" href="orders.php">Orders</a>
        </div>
      </div>
</div>
</nav>
admin_nav;
}
?>
