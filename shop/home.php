<?php
include("../page.php");
$sql = engine->run('SELECT * FROM products ORDER BY date_added DESC LIMIT 4');
template_header("shop",null);
$set_bc = breadcrumbs();
echo <<<body
<div  class="p-4 blog-bg text-white d-block">
        <div class="recentlyadded">
                <div class="products shop-row">
body;
     while($product = $sql->fetch(PDO::FETCH_ASSOC)){ 
        $id=$product['id'];
        $name=$product['name'];
        $desc=$product['short_desc'];
        $img=$product['img'];
        $price=$product['price'];
        $priveVES = $price * dolarPrice;
        echo <<<products
                    <div class="product-card mx-2 my-2 col-lg" data-toggle="tooltip" data-placement="top" title="$name"> 
                    <div class="product-header text-center">$name
                    <span class="badge rounded-pill bg-c3">NEW</span></div>
                    <a href="index.php?page=product&id=$id" style="text-decoration: none;" class="product text-center placeholder-glow">
                            <img src="imgs/$img" data-toggle="tooltip" data-placement="top" height="200px" width="200px" class="card-img-top placeholder" title="$name">
                            <div class="product-body">$desc</div>
                            <div class="product-footer placeholder-glow">           
                                <div class="row gap-1 d-flex">
                                    <div class="col">                                     
                                        <p style="display: contents;">&dollar;$price<br>Bs.$priveVES</p>                                     
                                    </div>
                                    <div class="col shop-card-flex">
                                          <button id="buystn" type="button" class="btn btn-veh fs-6 shop">
                                          Buy<i class="fas fa-shopping-cart"></i>
                                          </button>
                                    </div> 
                                </div>
                            </div>
                        </a>
                    </div>
                    
products; } 


echo <<<table
  </div> 
</div> 

<div class="alert">ALL ITEMS</div>

<div class="case-shop d-flex align-self-center justify-content-center align-items-center ">
    <div class="row" style="padding-right:0px;">

table;
        $sql = engine->run("SELECT * FROM products");
        while($result = $sql->fetch(PDO::FETCH_ASSOC)){
          $id = $result['id'];
          $name = $result['name'];
          $img = $result['img'];
          $desc = $result['desc'];
          $short_desc = $result['short_desc'];
          $price = $result['price'];
          $priceVES = $price * dolarPrice;
          $buy = "<a class='btn btn-login' href='index.php?page=product&id=$id'>
          <button class='btn btn-login'>Buy<i class='fas fa-shopping-cart'></i></button></a>";
          echo<<<acc
          <div class="row bg-entry my-2" style="padding-left: 0px; padding-right: 0px;  margin: auto;">
            <div class="col-md-6 col-lg-6 col-xl-8 d-flex placeholder-glow shadow" style="padding-left: 0px; padding-right: 0px; margin-left: auto;">
              <a href="index.php?page=product&id=$id" class="img w-100 mb-3 mb-md-0 placeholder" style="background-image: url(imgs/$img);background-size:cover"></a>

            </div>
          <div class="col-md-6 col-lg-6 col-xl-4 d-flex">
            <div class="text w-100 pl-md-3 mt-3 placeholder-glow">
              <h2><a class="blog-title hover-1 text-decoration-none placeholder" href="index.php?page=product&id=$id">$name</a></h2>
              <h3 class="placeholder">$short_desc</h3>
             $buy
        <div class="meta">
        <p class="mb-0 mx-auto placeholder">Wrote by</p>
      </div>
    </div>
  </div>
  
  </div>

acc;
        }
        offcanvaslogin();
      
?>
</div>
</div>
</div>
            



