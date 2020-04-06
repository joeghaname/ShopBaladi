<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>ShopBaladi - Order</title>
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
      echo "
      <div class='spinner-border text-success loader' role='status'>
      <span class='sr-only'>Loading...</span>
      </div>
      &nbsp;
      <a class='btn btn-success disabled' href='#' role='button'>Not Signed In</a>
      &nbsp;
      <a class='btn btn-success' href='login.html' role='button'>Login</a>
      &nbsp;
      <a class='btn btn-success' href='register.html' role='button'>Register</a>
      &nbsp;";
    }
    else echo "
    <div class='spinner-border text-success loader' role='status'>
    <span class='sr-only'>Loading...</span>
    </div>
    &nbsp;
    <a class='btn btn-success' href='signout.php' role='button'>Sign Out</a>
    &nbsp;
    <a class='btn btn-success' href='cart.php' role='button'>  Cart <span class='badge badge-light'>0</span></a>";
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

<?php 

// Shipping/Billing Info.
$email = $_SESSION["username"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$address = $_POST["address"];
$city = $_POST["city"];
$province = $_POST["province"];
$postalcode = $_POST["pcode"];

// Payment Info.
$payee = $_POST["name_card"];
$credit_num = $_POST["credit_num"];
$credit_exp = $_POST["credit_exp"];
$credit_cvv = $_POST["credit_cvv"];

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

// Fetch most recent oid for current logged-in user
$result1 = $conn->query("SELECT MAX(oid) FROM ORDERS WHERE email='$email'");
$row = $result1->fetch_row();
$oid = $row[0];

// Fetch the updated totals amount from orders table
$result2 = $conn->query("SELECT amount FROM ORDERS WHERE oid='$oid'");
$row = $result2->fetch_row();
$totalamt = $row[0];

// Insert info into appropriate tables for record-keeping of transaction
$sql = "INSERT INTO PAYMENT (`oid`, `email`, `amount`, `payee`, `credit_num`, `credit_exp`, `credit_cvv`) VALUES ('$oid', '$email', '$totalamt', '$payee', '$credit_num', '$credit_exp', '$credit_cvv')";
$sql1 = "INSERT INTO SHIPMENT (`oid`, `address`, `city`, `province`, `pcode`) VALUES ('$oid', '$address', '$city', '$province', '$postalcode')";
$sql2 = "INSERT INTO ORDERS (`email`, `amount`) VALUES ('$email', 0)";

if (($conn->query($sql) && $conn->query($sql1) && $conn->query($sql2))  === TRUE) {
    // echo "New record created successfully";
    echo "
  <div class='jumbotron'>
    <div class='alert alert-success' role='alert'>";
       echo" <h4 class='alert-heading'>Successful Order!</h4>
        <p>We're happy your enjoying ShopBaladi.</p>
        <hr>
        <p class='mb-0'>Enjoy your childhood memories.</p>
      </div>
  </div>";
} else {
    // echo "Error: " . $sql . "<br>" . $conn->error;
    echo "
    <div class='jumbotron'>
      <div class='alert alert-warning' role='alert'>";
         echo" <h4 class='alert-heading'>Order Failed.</h4>
          <p>For some reason your order could not go through. Please try ordering again.</p>
          <hr>
          <p class='mb-0'>One of the main reasons can be that you are ordering an item that is sold out. Contact customer service for more information.</p>
        </div>
    </div>";
}


$sql3 = "SELECT pid FROM CART WHERE oid='$oid'";
$result3 = $conn->query($sql3);

if ($result3->num_rows > 0) {

  while($row = $result3->fetch_assoc()) {

    $current_product = $row['pid'];

    // Fetch product info from product catalog
    $result4 = $conn->query("SELECT pname, price, image, category FROM PRODUCT WHERE pid='$current_product'");
    $row1 = $result4->fetch_row(); 

    $curr_pname = $row1[0];
    $curr_price = $row1[1];
    $curr_image = $row1[2];
    $curr_category = $row1[3];

    // Insert products into history
    $sql5 = "INSERT INTO HISTORY (`pid`, `pname`, `price`, `category`, `image`, `oid`) VALUES ('$current_product', '$curr_pname', '$curr_price', '$curr_category', '$curr_image', '$oid')";
    if ($conn->query($sql5) == TRUE) {
       // echo "Successfully added product to History";
    }

    // Remove products from product catalog
    $sql6 = "DELETE FROM PRODUCT WHERE pid='$current_product'";
    if ($conn->query($sql6) == TRUE) {
       // echo "Successfully removed product from Product catalog";
    }
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
