<?php require "../config/config.php"; ?>
<?php require "../includes/header.php"; ?>
<?php

  // check if user already loggedin.
  if(isset($_SESSION['username'])){
    header("location: ".APPURL." ");
  }

 if(isset($_POST['submit'])){
    if(empty($_POST['email']) || empty($_POST['user_password'])){
      echo "<div class='alert alert-danger bg-danger text-white'>some inputs are empty</div>";
      // echo "<script>alert('some inputs are empty!)</script>";
    } else {
      /*  Check for form submission  */
      /*  Get the data  */
      /*  Do query with email only */
      /*  Execute and fetch the data */
      /*  check the rowcount */
      /*  check for password */
      $email = $_POST['email'];
      $user_password = $_POST['user_password'];

      $login = $connection->query("SELECT * FROM users WHERE email = '$email'");
      $login->execute();

      $select = $login->fetch(PDO::FETCH_ASSOC);

      if($login->rowCount() > 0){
        if(password_verify($user_password, $select['user_password'])){
          // echo "logged in successfully!";
          $_SESSION['username'] = $select['username'];
          $_SESSION['id'] = $select['id'];
          $_SESSION['type'] = $select['type'];

          header("location: ".APPURL."");
        } else {
          echo "<script>alert('Invalid User Input!')</script>";
        }

      } else {
        echo "<script>alert('Invalid User Input!')</script>";
      }
    }
 }
?> 

  <section class="section-hero overlay inner-page bg-image" style="background-image: url('../images/hero_1.jpg');" id="home-section">
      <div class="container">
        <div class="row">
          <div class="col-md-7">
            <h1 class="text-white font-weight-bold">Log In</h1>
            <div class="custom-breadcrumbs">
              <a href="<?php echo APPURL; ?>/index.php">Home</a> <span class="mx-2 slash">/</span>
              <span class="text-white"><strong>Log In</strong></span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="site-section">
      <div class="container">
        <div class="row">
      
          <div class="col-md-12">
          
          <!--========= FORM Start ==========-->
            <form action="#" class="p-4 border rounded" method="post">

              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black" for="fname">Email</label>
                  <input type="text" id="fname" class="form-control" placeholder="Email address" name="email">
                </div>
              </div>
              <div class="row form-group mb-4">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black" for="fname">Password</label>
                  <input type="password" id="fname" class="form-control" placeholder="Password" name="user_password">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Log In" class="btn px-4 btn-primary text-white">
                </div>
              </div>

            </form>

          <!--========= Form End ==========-->
          </div>
        </div>
      </div>
    </section>

<?php require "../includes/footer.php"; ?>