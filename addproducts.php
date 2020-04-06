<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>ShopBaladi - Registration</title>
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

$pname = $_POST["pname"];
$price = $_POST["price"];
$category = $_POST["category"];
$description = $_POST["description"];
$imagefilename = $_FILES['fileToUpload']['name'];

$imagepath = "http://elghanaj.myweb.cs.uwindsor.ca/comp2707/assignments/finalproject/images/products/" . $imagefilename;

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

$sql = "INSERT INTO PRODUCT (`pname`, `description`, `price`, `image`, `category`) VALUES ('$pname', '$description', '$price', '$imagepath', '$category')";

if ($conn->query($sql) === TRUE) {
    // echo "New record created successfully";
    echo "
  <div class='jumbotron'>
    <div class='alert alert-success' role='alert'>";
       echo" <h4 class='alert-heading'>Successfully Added New Product!</h4>
        <p>The new product is now added under the Product tab.</p>
        <hr>
        <p class='mb-0'>Make sure to label products exactly the same if they exist already.</p>
      </div>
  </div>";
} else {
    // echo "Error: " . $sql . "<br>" . $conn->error;
    echo "
    <div class='jumbotron'>
      <div class='alert alert-warning' role='alert'>";
         echo" <h4 class='alert-heading'>Product Addition Failed.</h4>
          <p>For some reason your product addition could not go through. Please try registering again.</p>
          <hr>
          <p class='mb-0'>One of the main reasons can be that you are uploading an image with a filename that's already used.</p>
        </div>
    </div>";
}
$conn->close();

// Image file upload to images folder

$target_dir = "images/products/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
} else {
    echo "
    <div class='alert alert-danger' role='alert'>
    Sorry, there was an error uploading your file.
    </div>
    ";
}

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
