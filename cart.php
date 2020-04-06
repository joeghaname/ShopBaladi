<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>ShopBaladi - Cart</title>
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body onload="setTimeout()">

<!-- NAVIGATION STARTS -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php"><img id="logo" src="images/logo1.png" width=80px height=80px></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li>
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Products
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="product.php?category=food">Food</a>
          <a class="dropdown-item" href="product.php?category=house">Household Items  <img src="images/soon.png" width="40" height="25"></a>
          <a class="dropdown-item" href="product.php?category=souvenirs">Souvenirs  <img src="images/soon.png" width="40" height="25"></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="product.php?category=exclusive">Exclusive Products</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About ShopBaladi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact Us</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">

    <?php
    session_start();
    if($_SESSION['username'] == ''){
      echo "<a class='btn btn-success disabled' href='#' role='button'>Not Signed In</a>
      &nbsp;
      <a class='btn btn-success' href='login.html' role='button'>Login</a>
      &nbsp;
      <a class='btn btn-success' href='register.html' role='button'>Register</a>
      &nbsp;";
    }
    else {
        $itemscount = 0;
        $email = $_SESSION['username'];
  
        $servername = "localhost";
        $username = "elghanaj_shop";
        $password = "douma123";
        $dbname = "elghanaj_shop";
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        } 
  
        $result = $conn->query("SELECT MAX(oid) FROM ORDERS WHERE email='$email'");
        $row = $result->fetch_row();
        $oid = $row[0];
  
        $result2 = $conn->query("SELECT COUNT(pname) FROM CART WHERE oid='$oid'");
        $row2 = $result2->fetch_row();
  
        $itemcount = $row2[0];

        if($_GET['remove'] != '') $itemcount--;
        if($_GET['product'] != '') $itemcount++;
        
        echo "
      <div class='spinner-border text-success loader' role='status'>
        <span class='sr-only'>Loading...</span>
      </div>
      &nbsp;
      <a class='btn btn-success' href='signout.php' role='button'>Sign Out</a>
      &nbsp;
      <a class='btn btn-success' href='cart.php' role='button'>  Cart <span class='badge badge-light'>" . $itemcount . "</span></a>";
      }
    ?>    
    </form>
    <!--
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    -->
  </div>
  </nav>
  <!-- END OF NAVIGATION -->

  <h1 class="display-4">Shopping Cart</h1>

<!-- PRODUCT SHOPPING AREA -->  
<?php 

$email = $_SESSION['username'];

$servername = "localhost";
$username = "elghanaj_shop";
$password = "douma123";
$dbname = "elghanaj_shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$category = $_GET["category"];

// To Retrieve most recent oid for current user
$result1 = $conn->query("SELECT MAX(oid) FROM ORDERS WHERE email='$email'");
$row1 = $result1->fetch_row();
$oid = $row1[0];

// To check if there is any product to add to the shopping cart

if($_GET['product'] != ''){
    $product = $_GET['product'];

    // To retrieve product price
    $result3 = $conn->query("SELECT price FROM PRODUCT WHERE pname='$product'");
    $row3 = $result3->fetch_row();
    $price = $row3[0];

    // To retrieve product pid
    $result4 = $conn->query("SELECT pid FROM PRODUCT WHERE pname='$product' LIMIT 1");
    $row4 = $result4->fetch_row();
    $pid = $row4[0];
    
    $sql3= "INSERT INTO CART (`pid`, `pname`, `email`, `oid`, `price`) VALUES ('$pid', '$product', '$email', '$oid', '$price')";
    if ($conn->query($sql3) == TRUE) {
        echo"
        <div class='alert alert-success' role='alert'>
        Successfully added <strong>$product</strong> to shopping cart. <a href='product.php?category=food' class='alert-link'>Keep Shopping</a>
        </div>
        ";
        // echo "<h1>SUCCESS! Your item $product has been added to your shopping cart :)</h1>";
    }

}

if($_GET['remove'] != ''){
    $product2 = $_GET['remove'];

    $sql6 = "DELETE FROM CART WHERE oid='$oid' AND pname='$product2'";

    if ($conn->query($sql6) == TRUE) {
        echo"
        <div class='alert alert-success' role='alert'>
        Successfully removed <strong>$product2</strong> from your shopping cart.
        </div>
        ";
    } else {
         echo "<h1>Error deleting record: " . $conn->error . "</h1>";

    }


}


$sql = "SELECT pname, price FROM CART WHERE email='$email' AND oid='$oid' GROUP BY pname";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $counter = 1;
    $total;
    // output data of each row
    echo "
    <table class='table'>
    <thead class='thead-light'>
      <tr>
        <th scope='col'>Product No.</th>
        <th scope='col'></th>
        <th scope='col'>Product Name</th>
        <th scope='col'>Price</th>
      </tr>
    </thead>
    <tbody>";

    while($row = $result->fetch_assoc()) {

    $current_product = $row["pname"];

    // To retrieve product image
    $result5 = $conn->query("SELECT image FROM PRODUCT WHERE pname='$current_product' LIMIT 1");
    $row5 = $result5->fetch_row();
    $image = $row5[0];

    echo "
    <tr>
      <th scope='row'>$counter</th>
      <td><img src='" . $image . "' width='150' height'125'></td>
      <td>" . $row["pname"] . "</td>
      <td>" . $row["price"] . " &nbsp; <a class='btn btn-danger' href='cart.php?remove=" . $current_product . "' role='button'>X</a></td>
    </tr>";

    $counter++;
    $total = $total + $row["price"];

    } 
    echo "
    <tr>
      <th scope='row'></th>
      <td></td>
      <td></td>
      <td><strong>Total</strong><br>" . $total . "</td>
    </tr>
    ";

    echo "
    </tbody>
    </table>";

    echo"
    <form action='order.php' method='post' id='orderform'>
    ";

    echo"<div class='container w-50 p-3'><h6>Promo Code:</h6><input class='form-control' type='text' name='promocode' placeholder=''></form><br>";

    echo"<button type='submit' form='orderform' class='btn btn-success btn-lg btn-block'>Place Order</button></div>";
}

else {
    if($email != '') {
    echo "
    <div class='jumbotron'>
        <div class='alert alert-warning' role='alert'>
            <h4 class='alert-heading'>Your shopping cart is empty.</h4>
            <p>Start shopping by clicking into the Products tab!</p>
            <hr>
            <p class='mb-0'>Be sure to check our site for new products.</p>
        </div>
    </div>";
    }
    else{
        echo "
    <div class='jumbotron'>
        <div class='alert alert-danger' role='alert'>
            <h4 class='alert-heading'>You must be signed in to add to a shopping cart.</h4>
            <p><a href='login.html'>Log in</a> or <a href='register.html'>register</a> today at ShopBaladi.</p>
            <hr>
            <p class='mb-0'>Need help? Be sure to contact us.</p>
        </div>
    </div>";
    }
}

$conn->close();

?>


<!-- FOOTER STARTS -->
<footer class="footer mt-auto py-3">
  <div class="container">
    <p>&nbsp;</p>
    <span class="text-muted">Copyright © 2020 ShopBaladi Corp.</span>
    <p>Made with <span style="color: #e25555;">&hearts;</span> in Windsor, Canada</p>
    <p>&nbsp;</p>
  </div>
</footer>
<!-- FOOTER ENDS -->

<script>
setTimeout(function(){
  $('.loader').remove();
  },2000);
</script>

<!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>
