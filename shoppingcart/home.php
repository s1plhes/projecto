<?php
// Get the 4 most recently added products
$stmt = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT 4');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?=template_header('Home')?>
<div  class="p-4 shopbg text-white" style="background: #EBF1F4;">
    <div class="featured d-flex flex-column justify-content-center" style="color:#122062;"><h2>Tienda</h2></div>
        <div class="recentlyadded content-wrapper justify-content-center">
<div class="alert alert-light">Productos mas recientes</div>
    <div class="products row d-flex justify-content-center">
         <?php foreach ($recently_added_products as $product): ?>
        <div class="card mx-2 col-md-auto" data-toggle="tooltip" data-placement="top" title="<?=$product['name']?>"> 
            <a href="index.php?page=product&id=<?=$product['id']?>" style="text-decoration: none;" class="product text-center">
                <img src="imgs/<?=$product['img']?>" width="200px" data-toggle="tooltip" data-placement="top" height="200px" class="card-img-top" title="<?=$product['name']?>">
                    <div class="card-body card-body-shop p-3">
                        <h4 class="card-text"><?=$product['name']?></h4>
                        <div class="row gap-1">
                        <div class="col"><span class="fs-4 d-flex justify-content-center">&dollar;<?=$product['price']?> </span></div>
                        <div class="col">
                            <button  id="buystn" type="button" class="btn fs-6 shop">Buy
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                        
    
                          </div>

                    </div>
            </a>
    </div>

        <?php endforeach; ?>
</div>
</div>
</div>
<?=template_footer()?>
         </body>
         </html>