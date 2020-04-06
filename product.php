<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>ShopBaladi - Products</title>
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
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
      
      echo "
      <div class='spinner-border text-success loader' role='status'>
      <span class='sr-only'>Loading...</span>
      </div>
      &nbsp;";

      if($email == "admin@shopbaladi.com"){
        echo "
        <a class='btn btn-success' href='addproduct.php' role='button'>Add Product</a>
        &nbsp;";
      }
      
      echo "<a class='btn btn-success' href='signout.php' role='button'>Sign Out</a>
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

<!-- PRODUCT SHOPPING AREA -->  
<?php 

$email = $_POST["email"];
$pword = $_POST["password"];

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

$sql = "SELECT pname, price, description, image FROM PRODUCT WHERE category='$category' GROUP BY pname";
$result = $conn->query($sql);

// echo "<div class='card-deck'>";

$counter = 0;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

          $current_product = $row["pname"];

          $result2 = $conn->query("SELECT COUNT(pname) FROM PRODUCT WHERE pname='$current_product'");
          $row2 = $result2->fetch_row();
          if($counter == 0) echo "<div class='card-deck jumbotron'>";

          echo "
          <div class='card border-success mb-3 mx-6' style='width: 18rem;'>
            <img src='" . $row["image"] . "' class='card-img-top zoom' width='150' height='300' alt='" . $row["pname"] . "'>
            <hr class='my-4'>
            <div class='card-body'>
              <h5 class='card-title'>" . $row["pname"] . " $" .  $row["price"] . "</h5>
              <p class='card-text'>" . $row["description"] . "</p>
              <div class='container'>
                <div class='row'>
                  <div class='col'></div>
                  <div class='col-20'>
                    <a href='cart.php?product=" . $row["pname"] . "' class='btn btn-success'>Add to Cart</a>
                    <p class='card-text centertext'>" . $row2[0] . " in stock</p>
                  </div>
                  <div class='col'></div>
                </div>
              </div>
            </div>
          </div>
        ";
      
        if($counter == 3) {
          $counter = 0;
          echo "</div>";
        }
        else {
          $counter++;
        }
    } 
    echo "</div>";
}

else {
  echo "
  <div class='jumbotron'>
    <div class='alert alert-warning' role='alert'>";
       echo" <h4 class='alert-heading'>We currently are out of stock for products in this category!</h4>
        <p>We will be stocking up soon!</p>
        <hr>
        <p class='mb-0'>Be sure to check again in the future for more products.</p>
      </div>
  </div>";
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
