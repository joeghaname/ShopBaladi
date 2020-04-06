<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>ShopBaladi - About</title>
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
      <li class="nav-item">
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
      <li class="nav-item active">
        <a class="nav-link" href="about.php">About ShopBaladi <span class="sr-only">(current)</span></a>
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
      &nbsp;
      <a class='btn btn-success' href='signout.php' role='button'>Sign Out</a>
      &nbsp;
      <a class='btn btn-success' href='cart.php' role='button'>  Cart <span class='badge badge-light'>" . $itemcount . "</span></a>";
    }
    ?>    
    </form>
  </div>
  </nav>
<!-- END OF NAVIGATION -->

<!-- Spacer -->
<p>
  &nbsp;
</p>

<div class="alert alert-success alert-dismissible fade show" role="alert">
    &#128154; <strong>Our warm welcome!</strong> Enter code "B2020" in checkout to receive a complementary gift!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

<!-- Main Greeting of ShopBaladi -->
<main role="main" class="container">
  <div class="jumbotron" id="abackground">
    <h1 class="display-4">Welcome to ShopBaladi.<br>We are the new kid on the block!</h1>
    <p class="lead">ShopBaladi is your village ambassador, shipping to all ends of the world.</p>
    <hr class="my-4">
    <div class="card">
        <div class="card-body centertext">Register for ShopBaladi below! &#128071;
        </div>

           <a class="btn btn-success btn-lg" href="register.html" role="button">Register</a>

      </div>
    <!-- <p>Register for ShopBaladi below!</p> -->

  </div>
</main>


<!-- About Card #1 -->
<div class="card text-center">
    <div class="card-header">
      ShopBaladi's 1<sup>st</sup> Promotion Starts &#127873;
    </div>
    <div class="card-body">
      <h5 class="card-title">ShopBaladi is sending warm hugs with a complementary gift for each order!</h5>
      <p class="card-text">Use checkout code <strong>"B2020"</strong> to receive a complementary gift upon checkout.</p>
    </div>
    <div class="card-footer text-muted">
      March 20<sup>th</sup>, 2020
    </div>
</div>

<!-- Spacer -->
<p>
    &nbsp;
</p>

<!-- About Card #2 -->
<div class="card text-center">
    <div class="card-header">
      ShopBaladi ships its 500th Order &#128230;
    </div>
    <div class="card-body">
      <h5 class="card-title">ShopBaladi celebrated its 500<sup>th</sup> order!</h5>
      <p class="card-text">Wow! ShopBaladi is on fire!</p>
    </div>
    <div class="card-footer text-muted">
      March 10<sup>th</sup>, 2020
    </div>
</div>

<!-- Spacer -->
<p>
    &nbsp;
</p>

<!-- About Card #3 -->
<div class="card text-center">
    <div class="card-header">
      ShopBaladi's 1000th Customer &#127881;
    </div>
    <div class="card-body">
      <h5 class="card-title">ShopBaladi celebrated its 1000<sup>th</sup> customer!</h5>
      <p class="card-text">We are so happy many are enjoying ShopBaladi... remember to spread the word!</p>
    </div>
    <div class="card-footer text-muted">
      February 30<sup>th</sup>, 2020
    </div>
</div>

<!-- Spacer -->
<p>
    &nbsp;
</p>

<!-- About Card #4 -->
<div class="card text-center">
    <div class="card-header">
      ShopBaladi Opening Day &#127793;
    </div>
    <div class="card-body">
      <h5 class="card-title">ShopBaladi celebrated its first day open!</h5>
      <p class="card-text">With so many supporters and fans, we had a fantastic opening!</p>
    </div>
    <div class="card-footer text-muted">
      January 1<sup>st</sup>, 2020
    </div>
</div>

<!-- FOOTER STARTS -->
<footer class="footer">
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
