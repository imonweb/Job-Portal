<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php
  if(isset($_POST['submit'])){
    if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['user_password']) || empty($_POST['re_password'])){
      echo "<div class='alert alert-danger bg-danger text-white'>some inputs are empty</div>";
    } else {
      $username = $_POST['username'];
      $email = $_POST['email'];
      $user_password = $_POST['user_password'];
      $re_password = $_POST['re_password'];
      $img = 'avatar1.png';

      // checking for password match
      if($user_password == $re_password){
   
        $insert = $connection->prepare("INSERT INTO users (username, email, user_password, re_password, img) VALUES (:username, :email, :user_password, :re_password, :img)");

        $insert->execute([
          ':username'       =>  $username,  
          ':email'          =>  $email,  
          ':user_password'  =>  password_hash($user_password, PASSWORD_DEFAULT),  
          ':re_password'    =>  $re_password,  
          ':img'            =>  $img
        
        ]);

        echo "done";

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
              <a href="#">Home</a> <span class="mx-2 slash">/</span>
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
                  <input type="text" id="fname" class="form-control" placeholder="Email address" name="email">
                </div>
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
    
    