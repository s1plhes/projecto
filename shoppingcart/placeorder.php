<?php
// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the products
    $stmt->execute(array_keys($products_in_cart));
    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Calculate the subtotal
    foreach ($products as $product) {
        $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']];
    }
}

$costumer_name = $_POST['name'];
$costumer_address = $_POST['address'];
$costumer_email = $_POST['email'];
$item_qty = $_POST['quantity'];
$item_name = $product['name'];
$price_to_pay = $subtotal;
$purchase_date;
if(isset($_POST['submit'])) 
{ 
    
    echo "User Has submitted the form and entered this name : <b> $name </b>";
    echo "<br>You can use the following form again to enter a new name."; 
}

$sql = "INSERT INTO orders (name, qty, totalprice, costumer_name,costumer_email	,costumer_address,date)
VALUES ($item_name,$item_qty,$price_to_pay,$costumer_name,$costumer_email,$costumer_address,$purchase_date)";

function li2Array($html,$elemento="li"){
 
    $a = array("/<".$elemento.">(.*?)</".$elemento.">/is");
    $b = array("$1 <explode>");
   
    $html  = preg_replace($a, $b, $html);
    $array = explode("<explode>",$html);
   
    return $array;
   
  }

?>

<?=template_header('Place Order')?>

<div class="placeorder content-wrapper">
    <h1>Your Order Has Been Placed</h1>
    <p>Thank you for ordering with us, we'll contact you by email with your order details.</p>
</div>
           

<?=template_footer()?>