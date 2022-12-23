<?php
libxml_use_internal_errors(true);
include("../page.php");
if(!isset($_SESSION['loggedin'])){
    $host  = $_SERVER['HTTP_HOST'];
    header ("location: http://$host");
    exit;
} else {
    $session = $_SESSION['id'];
    if($session > 1){
        $host  = $_SERVER['HTTP_HOST'];
        header ("location: http://$host");
        exit;
    }
}
$sql = engine->run("SELECT * FROM orders");
template_header("Orders Management",NULL);
admin_nav();

echo <<<page
<style>
body{
  background-color: #271b37;  
}</style>
<div class="container-fluid bg-dark text-light">

<div class="table-responsive">
<table class="table table-responsive table-sm table-dark table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Costumer data</th>
      <th scope="col">Compra</th>
      <th scope="col">Payment</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
page;

function status_checker($i){
  if ($i  = "Pending"){
    return "<p class='btn btn-info'>$i</p>";
  }
}

while($result = $sql->fetch(PDO::FETCH_ASSOC)) {
    $xmlData = $result['order'];
    $xml = simplexml_load_string($xmlData) or die("Error");
    $id = $result['id'];
    $costumer_username = $result['username'];
    $costumer_name = $result['costumer_name'];
    $costumer_lastname = $result['costumer_lastname'];
    $fullName = $costumer_name.' '.$costumer_lastname;
    $email = $result['costumer_email'];
    $phone = $result['costumer_phone'];
    $address = $result['costumer_address'];
    $date = $result['date'];
    $date_elapsed = time_elapsed_string($date);
    $recipe = $result['recipe'];
    $payment_method = $result['payment_method'];
    $status = $result['status'];
    $status_string = status_checker($status);
    $details = $result['details'];
        echo <<<eot
    <tr>
    <th scope="row"><p>Order Numer: $id
      <p>Status: $status_string
      <p>ordered: $date
      <p> $date_elapsed
    </th>
    <td>
      <p>$costumer_username
      <p>$fullName</p>
      <p>$email</p>
      <p>$phone</p>
      <p>$address</p>
    </td>
    <td>
eot;
                //Order
                foreach ($xml->children() as $orders) {
                    $item = $orders->purchase->item; 
                    $quantity = $orders->quantity;
                    $price = $orders->price;
                    $total = $orders->total;
                    $totalVES = $total * dolarPrice;
                    $subtotal = $price * $quantity;

                    echo <<<item
                      <p>$quantity units of $item at USD $price each for a total of USD $subtotal</p>              
item;
                }
                //Order               
echo <<<eot
   <p>Details: $details</p>
   </td>
      <td>
        <p>Total: USD $total</p>
        <p>Total: VES $totalVES</p>
        <p>Paid via: $payment_method</p>
        <p>Ref #: $recipe</p>
      </td>
    <td>
      <p><button class="btn btn-warning">Mark as ready</button>
      <p><button class="btn btn-success">Mark as delivered</button>
    </td>  
  </tr>
  </tbody>
eot;
}
?>
</div>