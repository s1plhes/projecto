<?php
include "../page.php";
$set_bc = breadcrumbs();
// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    // Prepare the SQL statement, we basically are checking if the product exists in our databaser
    $sql = mysqli_query(conn,"SELECT * FROM Products WHERE id = $product_id");
    // Fetch the product from the database and return the result as an Array
    $product = mysqli_fetch_assoc($sql);
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There are no products in cart, this will add the first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

// Send the user to the place order page if they click the Place Order button, also the cart should not be empty
/*if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: index.php?page=placeorder');
    exit;
}*/

// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// If there are products in cart
// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// If there are products in cart
if ($products_in_cart) {
    $pdo = pdo_connect_mysql();
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



if(isset($_POST['send-order'])){
$firstName = $_POST['firstName'];
$lastName= $_POST['lastName'];
$orderData = trim($_POST['data_order']);
$xmlData = $orderData;
$xml = simplexml_load_string($xmlData) or die("Error");
$json = json_encode($xml);
$obj = json_decode($json);
$t_item = $obj->item; 
$t_quantity = $obj->quantity;
$t_price = $obj->price;
$t_total = $obj->total;
$t_totalVES = $t_total * dolarPrice;
$t_subtotal = $t_price * $t_quantity;
$apiToken = "5951786342:AAHzrnP5uLOX0wCe561OQ_oll2iG0CXnEHw";
$data = [
    'chat_id' => '-1001874923508',
    'text' => 'COMPRA! '.$t_quantity.' Unidad de '.$t_item.' a  '.$t_price.' dolares cada una, haciendo un total de '.$t_subtotal
];
$userName= $_POST['username'];
$email= $_POST['email'];
$details= $_POST['details'];
$phone= $_POST['phone'];
$address= $_POST['address'];
$address2 = $_POST['address2'];
$payment_method= $_POST['payment_method'];
$payment_recipe= $_POST['paymentRecipe'];
$emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
$name = "/^[a-zA-Z ]+$/";
$number = "/^[0-9]+$/";
echo'<script>console.log("order sent")</script>';
  if(!preg_match($name,$firstName)){
    echo "
    <div class='alert alert-warning'>
      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      <b>this $firstName is not valid..!</b>
    </div>
  ";
  exit();
  }
  if(!preg_match($name,$lastName)){
    echo "
    <div class='alert alert-warning'>
      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      <b>this $lastName is not valid..!</b>
    </div>
  ";
  exit();
  }
  if(!preg_match($emailValidation,$email)){
    echo "
    <div class='alert alert-warning'>
      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      <b>this $email is not valid..!</b>
    </div>
  ";
  exit();
  }

  $sql = "INSERT INTO `orders` (`order`, `username`, `costumer_name`, `costumer_lastname`, `costumer_email`, `costumer_phone`, `costumer_address`, `recipe`, `payment_method`, `details`, `date`)
  VALUES (\"$orderData\", \"$userName\", \"$firstName\", \"$lastName\", \"$email\", \"$phone\", \"$address\", \"$payment_recipe\", \"$payment_method\", \"$details\", NOW());";
  $query = mysqli_query(conn,$sql);
  $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" .
  http_build_query($data) );


  $_SESSION['cart'] = array(); //Reset the cart
  unset($_SESSION['cart']); //destroy the session
  
}

template_header('Cart',null);

?>
<div class="cart content-wrapper blog-bg py-3">

    <h1 class="px-3 d-flex align-self-center">Shopping Cart</h1>

    <form action="index.php?page=cart" method="post" class="mx-3 cart-table">
      <div class="table-responsive" ">
        <table id="shop-table" class="table align-middle table-sm text-light placeholder-glow table-shop">
            <thead>
                <tr>
                    <th class="shop-table-head">Product</th>
                    <th class="shop-table-head">Name</th>
                    <th class="shop-table-head">Price</th>
                    <th class="shop-table-head">Quantity</th>
                    <th class="shop-table-head">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart yet
                    <a href="../shop" class="btn btn-warning">BUY AT SHOP</a></td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                <td>
                        <a href="index.php?page=product&id=<?=$product['id']?>"><?=$product['name']?></a>
                        <br>
                        <button class="btn btn-danger">
                            <a href="index.php?page=cart&remove=<?=$product['id']?>" class="remove text-light">Remove</a>
                        </button>
                    </td>
                    <td class="img">
                        <a href="index.php?page=product&id=<?=$product['id']?>">
                            <img src="imgs/<?=$product['img']?>" width="100" height="100" alt="<?=$product['name']?>">
                        </a>
                    </td>
                    <td class="price">&dollar;<?=$product['price']?></td>
                     <td class="quantity">
                        <input type="number" name="quantity-<?=$product['id']?>" value="<?=$products_in_cart[$product['id']]?>" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
                    </td>

                    <td class="price">&dollar;<?=$product['price'] * $products_in_cart[$product['id']]?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?=$subtotal?></span>
        </div><?php 

      if (!empty($products)){
echo<<<buttons
        <div class="buttons my-3">
            <input class="btn btn-success" type="submit" value="Update" name="update">
            <button type="button" class="btn btn-primary text-light" data-bs-toggle="modal" data-bs-target="#exampleModalLive">Order</button>
        </div>
buttons;
        } else {
          echo null;
    }
?>
      </div>
    </form>

    <?php 
    $thisUser = $_SESSION['name'];
    echo <<<admin
    <style>
    body{
      background-color: #271b37; 
      color: white;
    }</style>
    <div class="container-fluid d-flex align-items-center justify-content-center">
    <div class="myOrders"> 
    
    admin;
    checkUserOrders($thisUser);
    echo <<<admin
    </div>
    </div>
    admin;
    ?>
</div>
<?php 
echo <<<modal
    <div class="modal fade" id="exampleModalLive" tabindex="-1" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
    <div class="modal-dialog d-flex" style="display:table;">
        <div class="modal-content" style="width: 950px;">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLiveLabel">Order modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p><code>
modal;
$num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;            
echo <<<modal
    </code></p>
    <main>
    <div class="row g-1">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
          <span class="badge bg-primary rounded-pill">$num_items_in_cart</span>
        </h4>
        <ul class="list-group mb-3">
modal;
          foreach ($products as $product):
            $quantity = $products_in_cart[$product['id']];
            $name = $product['name'];
            $desc = $product['short_desc'];
            $price_each = $product['price'];
            $priceve = $price_each * dolarPrice;
            $total = $subtotal * dolarPrice;
        
            echo <<<items
            <li class="list-group-item d-flex justify-content-between lh-sm">
              <div>
                <h6 class="my-0">($quantity)$name</h6>
                <small class="text-muted">$desc</small>
              </div>
              <span class="text-muted">&dollar;$price_each</span>
            </li>
items;
        endforeach;
echo <<<modal
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (USD)</span>
            <strong>$subtotal</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between">
          <span>Total (Bs)</span>
          <strong>$total</strong>
        </li>
        </ul><form class="needs-validation" novalidation method="POST">
<input id="data_order" name="data_order" class="invisible"  value="<document>
modal;
          foreach ($products as $product):
            $quantity = $products_in_cart[$product['id']];
            $name = $product['name'];
            $price_each = $product['price'];
            $priceve = $price_each * dolarPrice;
            $total = $subtotal * dolarPrice;
            echo "<purchase><item>$name</item><quantity>$quantity</quantity><price>$price_each</price><total>$subtotal</total></purchase>";
          endforeach;
echo <<<modal
</document></input>
      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Billing address</h4>

          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">First name</label>
              <input type="text" class="form-control" name="firstName" id="firstName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Last name</label>
              <input type="text" class="form-control" name="lastName" id="lastName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid last name is required.
              </div>
            </div>

            <div class="col-12">
              <label for="username" class="form-label">Username</label>
              <div class="input-group has-validation">
                <span class="input-group-text">@</span>
                <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
              <div class="invalid-feedback">
                  Your username is required.
                </div>
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email </label>
              <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com" required>
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>
            <div class="col-12">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="phone" class="form-control" name="phone" id="phone" placeholder="+58412555555" required>
            <div class="invalid-feedback">
              Please enter a valid phone number for shipping updates.
            </div>
          </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="col-12">
              <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" name="address2" placeholder="Apartment or suite">
            </div>
          </div>

          <hr class="my-4">
          <h4 class="mb-3">Order Details</h4>
          <div class="col-12">
              <label for="details" class="form-label">Details<span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="details" name="details" placeholder="Details your custom gifts(also you can details via Whatsapp">
            </div>
          <hr class="my-4">
          <h4 class="mb-3">Payment</h4>

          <div class="my-3">
            <div class="form-check form-switch">
              <input id="binance" name="payment_method" name="Binance" value="Binance" type="radio" class="form-check-input" checked required>
              <label class="form-check-label" for="credit">Binance</label>
            </div>
            <div class="form-check form-switch">
              <input id="pago-movil" name="payment_method" name="pago-movil" value="PagoMovil" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="debit">Pago Movil</label>
            </div>
            <div class="form-check form-switch">
              <input id="paypal" name="payment_method" name="paypal" value="paypal" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="paypal">PayPal</label>
            </div>
            <div class="col-12">
              <label for="paymentRecipe" class="form-label">Recipe<span class="text-muted">(Most important)</span></label>
              <input type="text" class="form-control" name="paymentRecipe" id="paymentRecipe" placeholder="Reference number" required>
            </div>

          <hr class="my-4">

          <button class="w-100 btn vhmbtn btn-lg" type="submit" name="send-order">Sent order</button>


        </form>
      </div>
    </div>
  </main>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>
modal;
template_footer();

