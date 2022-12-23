<?php
include "../page.php";
$set_bc = breadcrumbs();
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    // Prepare statement and execute, prevents SQL injection
    $product_id = $_GET['id'];
    $sql = engine->run("SELECT * FROM products WHERE id = ?",[$product_id]);
    // Fetch the product from the database and return the result as an Array
    $product = $sql->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if (!$product) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}
$id = $product['id'];
$name = $product['name'];
$img = $product['img'];
$desc = $product['desc'];
$quantity = $product['quantity'];
$price = $product['price'];
$priveVES = $price * dolarPrice;

template_header($product['name'],null);
echo <<<product
<div class="p-5 rounded">
<div class="product mx-auto row content-wrapper" >
    <div class="col mx-auto"> 
        <figure class="figure">
            <img src="imgs/$img" width="500" height="500" class="img-fluid rounded" alt="$name">   
            <figcaption class="figure-caption">$name.</figcaption>
        </figure>
    </div>
<div class="col">
    <h1 class="name">$name</h1>
        <div class="description">$desc</div>
    <span class="price">Precio &dollar;$price<p>Precio <span class="rrp">Bs $priveVES
    </span>
        <?php endif; ?>
    </span>
    <form action="index.php?page=cart" method="post">
    <div class="row">
         <div class="col">
        <input type="number" class="form-control" name="quantity" value="1" min="1" max="$quantity" placeholder="Quantity" required>
        </div>
    
        <input class="form-control" type="hidden" name="product_id" value="$id">
  
        <div class="col">
        <button type="submit" class="btn btn-primary" value="Add To Cart">Add to Cart</button>
        </div>
    </form>
</div>
</div>
</div>
</div>



product;
?>