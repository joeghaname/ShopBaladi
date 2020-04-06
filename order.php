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

  <body class="bg-light">

  <?php
    session_start();
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

  ?>

    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="images/logo1.png" alt="" width="72" height="72">
        <h2>ShopBaladi Checkout</h2>
        <p class="lead">Please fill out the information below so we can place your order.<br>Be sure to contact our customer service for any issues.</p>
      </div>

      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill"> 
            <?php
            echo $itemcount;
            ?>
            </span>
          </h4>

        <?php
        $sql3 = "SELECT pname, price FROM CART WHERE email='$email' AND oid='$oid' GROUP BY pname";
        $result3 = $conn->query($sql3);

        if ($result3->num_rows > 0) {
        $counter = 1;
        $total;
        
        while($row = $result3->fetch_assoc()) {
        echo"
          <ul class='list-group mb-3'>
            <li class='list-group-item d-flex justify-content-between lh-condensed'>
              <div>
                <h6 class='my-0'>" . $row['pname'] . "</h6>
              </div>
              <span class='text-muted'>" . $row['price'] . "</span>
            </li>
        ";
        $total = $total + $row['price'];
        }
        }

        $promo = $_POST['promocode'];

        if($promo == 'B2020'){
            echo"
                <li class='list-group-item d-flex justify-content-between bg-light'>
                    <div class='text-success'>
                      <h6 class='my-0'>Opening Promo</h6>
                      <small>B2020</small>
                    </div>
                    <span class='text-success'>+ FREE GIFT</span>
                </li>
            ";
        }
            


        echo"
            <li class='list-group-item d-flex justify-content-between'>
              <span>Sub-total (CAD)</span>
              <strong>$$total</strong>
            </li>
            </ul>
        ";

        echo"
        <li class='list-group-item d-flex justify-content-between'>
          <span>HST (tax)</span>
          <strong>$" . number_format(round(($total*0.13), 2), 2, '.', '')  . "</strong>
        </li>
        </ul>
    ";

        echo"
        <li class='list-group-item d-flex justify-content-between'>
          <span>Total (CAD)</span>
          <strong>$" . number_format(round(($total*1.13), 2), 2, '.', '') . "</strong>
        </li>
        </ul>
    ";

            echo"
        <li class='list-group-item d-flex justify-content-between'>
        <a class='btn btn-danger btn-lg btn-block' href='cart.php' role='button'>Back to Cart</a>
        </li>
        </ul>
    ";

    $grandtotal = $total * 1.13;
    $sql5= "UPDATE ORDERS SET amount='$grandtotal' WHERE oid='$oid'";
    if ($conn->query($sql5) == TRUE) {
        // echo "<h1>SUCCESS! Your item $product has been added to your shopping cart :)</h1>";
    }

        $conn->close();
        ?>

        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Billing address</h4>
          <form class="needs-validation" action="orders.php" method="post" novalidate>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">First name</label>
                <input type="text" class="form-control" id="firstName" name="fname" placeholder="John" value="" required>
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Last name</label>
                <input type="text" class="form-control" id="lastName" name="lname" placeholder="Appleseed" value="" required>
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="row">
              <div class="col-md-3 mb-3">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="" required>
                <div class="invalid-feedback">
                  Valid city required.
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="province">Province</label>
                <select class="custom-select d-block w-100" id="province" name="province" required>
                    <option selected disabled value="">Choose...</option>
                    <option>Alberta</option>
                    <option>British Columbia</option>
                    <option>Manitoba</option>
                    <option>New Brunswick</option>
                    <option>Newfoundland and Labrador</option>
                    <option>Nova Scotia</option>
                    <option>Ontario</option>
                    <option>Prince Edward Island</option>
                    <option>Quebec</option>
                    <option>Saskatchewan</option>
                </select>
                <div class="invalid-feedback">
                  Please choose a valid province.
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="postalcode">Postal Code</label>
                <input type="text" class="form-control" id="postalcode" name="pcode" placeholder="A1A 1A1" required>
                <div class="invalid-feedback">
                  Valid Postal Code required.
                </div>
              </div>
            </div>

            <hr class="mb-4">

            <h4 class="mb-3">Payment</h4>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="name_card">Name on card</label>
                <input type="text" class="form-control" id="name_card" placeholder="" name="name_card" required>
                <small class="text-muted">Full name as displayed on card</small>
                <div class="invalid-feedback">
                  Name on card is required
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="credit_num">Credit card number</label>
                <input type="text" class="form-control" id="credit_num" placeholder="" name="credit_num" required>
                <div class="invalid-feedback">
                  Credit card number is required
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 mb-3">
                <label for="credit_exp">Expiration</label>
                <input type="text" class="form-control" id="credit_exp" placeholder="MM/YY" name="credit_exp" required>
                <div class="invalid-feedback">
                  Expiration date required
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="credit_cvv">CVV</label>
                <input type="text" class="form-control" id="credit_cvv" placeholder="" name="credit_cvv" required>
                <div class="invalid-feedback">
                  Security code required
                </div>
              </div>
            </div>
            <hr class="mb-4">
            <button class="btn btn-success btn-lg btn-block" type="submit">Continue to checkout</button>
          </form>
        </div>
      </div>
    </div>

    <br>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>


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

<!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  </body>  
</html>

