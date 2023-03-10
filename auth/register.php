<?php require "../config/config.php"; ?>
<?php require "../includes/header.php"; ?>
<?php

   // check if user already loggedin.
  if(isset($_SESSION['username'])){
    header("location: ".APPURL."");
  }

  if(isset($_POST['submit'])){
    if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['user_password']) || empty($_POST['re_password'])){
      echo "<div class='alert alert-danger bg-danger text-white'>some inputs are empty</div>";
      // echo "<script>alert('some inputs are empty!)</script>";
    } else {
      $username = $_POST['username'];
      $email = $_POST['email'];
      $user_password = $_POST['user_password'];
      $re_password = $_POST['re_password'];
      $img = 'avatar1.png';
      $type = $_POST['type'];

      // checking for password match
      if($user_password == $re_password){

        // email validation
        if(strlen($email) > 15 || strlen($username) > 10){
          echo "<script>alert('email chars too long!)</script>";
        } else {

          // checking for username availability
          $validate = $connection->query("SELECT * FROM users WHERE email = '$email' || username = $username");
          $validate->execute();

          if($validate->rowCount() > 0){
            echo "<script>alert('email is already taken')</script>";
          } else {

            $insert = $connection->prepare("INSERT INTO users (username, email, user_password, re_password, img, type) VALUES (:username, :email, :user_password, :re_password, :img, :type)");
          
          $insert->execute([
            ':username'       =>  $username,  
            ':email'          =>  $email,  
            ':user_password'  =>  password_hash($user_password, PASSWORD_DEFAULT),  
            ':re_password'    =>  $re_password,  
            ':img'            =>  $img,
            ':type'            =>  $type
            
          ]);
          
          header('location: login.php');

          } // user availability end

        } // email validation end

        // echo "done";

      } else {

        echo "<div class='alert alert-danger bg-danger text-white'>passwords doesn't match!</div>";
      }
    }
  }
?>
    <!-- HOME -->
    <section class="section-hero overlay inner-page bg-image" style="background-image: url('../images/hero_1.jpg');" id="home-section">
      <div class="container">
        <div class="row">
          <div class="col-md-7">
            <h1 class="text-white font-weight-bold">Register</h1>
            <div class="custom-breadcrumbs">
              <a href="<?php echo APPURL; ?>">Home</a> <span class="mx-2 slash">/</span>
              <span class="text-white"><strong>Register</strong></span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-5">

            <!--========= FORM START HERE ==========-->
            <form action="register.php" class="p-4 border rounded" method="post">

              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black" for="fname">Username</label>
                  <input type="text" id="fname" class="form-control" placeholder="Username" name="username">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black" for="fname">Email</label>
                  <input type="email" id="fname" class="form-control" placeholder="Email address" name="email">
                </div>
              </div>
               <div class="form-group">
                  <label for="job-type">User Type</label>
                  <select name="type" class="selectpicker border rounded" id="user-type" data-style="btn-white btn-lg" data-width="100%" data-live-search="true" title="Select User Type">
                    <option>Worker</option>
                    <option>Company</option>
                  </select>
                </div>
              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black" for="fname">Password</label>
                  <input type="password" id="fname" class="form-control" placeholder="Password" name="user_password">
                </div>
              </div>
              <div class="row form-group mb-4">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black" for="fname">Re-Type Password</label>
                  <input type="password" id="fname" class="form-control" placeholder="Re-type Password" name="re_password">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Sign Up" class="btn px-4 btn-primary text-white">
                </div>
              </div>

            </form>
            <!--========= FORM END HERE ==========-->
          </div>
      
        </div>
      </div>
    </section>

<?php require "../includes/footer.php"; ?>
    
    