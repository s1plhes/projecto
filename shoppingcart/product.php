<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if (!$product) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}
?>

<?=template_header('Product')?>
<div class="p-5 rounded" style="background: #EBF1F4;">
    <div class="product mx-auto row content-wrapper" >
        <div class="col mx-auto"> 
            <figure class="figure">
                <img src="imgs/<?=$product['img']?>" width="500" height="500" class="img-fluid rounded" alt="<?=$product['name']?>">   
                <figcaption class="figure-caption"><?=$product['name']?>.</figcaption>
            </figure>
        </div>
    <div class="col">
        <h1 class="name"><?=$product['name']?></h1>
            <div class="description"><?=$product['desc']?></div>
        <span class="price">Precio &dollar;<?=$product['price']?> <?php if ($product['rrp'] > 0): ?> <p>Precio <span class="rrp">&dollar;<?=$product['rrp']?>
        </span>
            <?php endif; ?>
        </span>
        <form action="index.php?page=cart" method="post">
        <div class="row">
             <div class="col">
            <input type="number" class="form-control" name="quantity" value="1" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
            </div>
        
            <input class="form-control" type="hidden" name="product_id" value="<?=$product['id']?>">
      
            <div class="col">
            <button type="submit" class="btn btn-primary" value="Add To Cart">Add to Cart</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
<?=template_footer()?>