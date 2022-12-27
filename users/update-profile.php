<?php 
  require "../includes/header.php"; 
  require "../config/config.php";

  if(isset($_GET['upd_id']))
  {
    $id = $_GET['upd_id'];

     // check if user already loggedin.
    /*
    if($_SESSION['id'] !== $id){
      header('location: ".APPURL."');
    }
    */

    $select = $connection->query("SELECT * FROM users WHERE id='$id'");
    $select->execute();

    $profile = $select->fetch(PDO::FETCH_OBJ);

    echo "<pre>";
    print_r($profile );
    echo "</pre>";

    // send form for updates
    if(isset($_POST['submit']))
    {
      if(empty($_POST['username']) || empty($_POST['email']))
      {
        echo "<script>alert('username or email is empty')</script>";
      } else {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $title = $_POST['title'];
        $bio = $_POST['bio'];
        $facebook = $_POST['facebook'];
        $twitter = $_POST['twitter'];
        $linkedin = $_POST['linkedin'];
        $img = $_FILES['img']['name'];
        $cv = $_FILES['cv']['name'];

        $profile->type == "Worker" ? $cv = $_FILES['cv']['name'] : $cv = 'NULL';

        $dir_img = 'user-images/' . basename($img);
        $dir_cv = 'user-cvs/' . basename($cv);

        $update = $connection->prepare("UPDATE users SET username = :username, email = :email, title = :title, bio = :bio, facebook = :facebook, twitter = :twitter, linkedin = :linkedin, img = :img, cv = :cv WHERE id = '$id'");

        if($img !== '' && $cv !== ''){ 

          unlink("user-images/" . $profile->img . "");
          unlink("user-cvs/" . $profile->cv . "");

          $update->execute([
            ':username' =>  $username,
            ':email'    =>  $email,
            ':title'    =>  $title,
            ':bio'      =>  $bio,
            ':facebook' =>  $facebook,
            ':twitter'  =>  $twitter,
            ':linkedin' =>  $linkedin,
            ':img'      =>  $img,
            ':cv'       =>  $cv
          ]);
        } else {
              $update->execute([
            ':username' =>  $username,
            ':email'    =>  $email,
            ':title'    =>  $title,
            ':bio'      =>  $bio,
            ':facebook' =>  $facebook,
            ':twitter'  =>  $twitter,
            ':linkedin' =>  $linkedin,
            ':img'      =>  $profile->img,
            ':cv'       =>  $profile->cv
          ]);

          //  header("location: " .APPURL. "");
        } // img & cv

        if(move_uploaded_file($_FILES['img']['tmp_name'], $dir_img) && move_uploaded_file($_FILES['cv']['tmp_name'], $dir_cv)){
          echo 'done';
          // header("location: " .APPURL. "");
        } // dir_img & dir_cv
      }
      
    } // submit

  } else {

    echo '404';

  } // upd_id

?>

 <section class="section-hero overlay inner-page bg-image" style="background-image: url('../images/hero_1.jpg');" id="home-section">
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <h1 class="text-white font-weight-bold"><?php echo $profile->username; ?></h1>
        <div class="custom-breadcrumbs">
          <a href="<?php echo APPURL; ?>/index.php">Home</a> <span class="mx-2 slash">/</span>
          <span class="text-white"><strong><?php echo $profile->username; ?></strong></span>
        </div>
      </div>
    </div>
  </div>
</section>

 <section class="site-section" id="next-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 mb-5 mb-lg-0">

            <!--========= FORM ==========-->
            <form action="update-profile.php?upd_id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">

              <div class="row form-group">
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black" for="fname">Username</label>
                  <input type="text" id="fname" value="<?php echo $profile->username; ?>" name="username" class="form-control">
                </div>

                <div class="col-md-6">
                  <label class="text-black" for="email">Email</label>
                  <input type="text" id="email" value="<?php echo $profile->email; ?>" name="email" class="form-control">
                </div>
              </div>


              <!--========= Check if the logged in user is employee or client  ==========-->
              <?php if(isset($_SESSION['type']) && $_SESSION['type'] == "Worker") : ?>
              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="title">Job Title</label> 
                  <input type="text" id="title" name="title" value="<?php echo $profile->title; ?>" class="form-control">
                </div>
              </div>
              
              <?php else: ?>

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="title">Job Title</label> 
                  <input type="text" id="title" name="title" value="NULL" class="form-control">
                </div>
              </div>
            
              <?php endif; ?>

              <!-- <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black" for="subject">Subject</label> 
                  <input type="subject" id="subject" class="form-control">
                </div>
              </div> -->

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="bio">Bio</label> 
                  <textarea name="bio" id="bio" cols="30" rows="7" class="form-control" placeholder="Write your notes or questions here..."><?php echo $profile->bio; ?></textarea>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="facebook">Facebook</label> 
                  <input type="text" id="facebook" name="facebook" value="<?php echo $profile->facebook; ?>" class="form-control">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="twitter">Twitter</label> 
                  <input type="twitter" id="twitter" name="twitter" value="<?php echo $profile->twitter; ?>" class="form-control">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="linkedin">LinkedIn</label> 
                  <input type="text" id="linkedin" name="linkedin" value="<?php echo $profile->linkedin; ?>" class="form-control">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="image">Profile Picture</label> 
                  <input type="file" id="image" name="img" class="form-control">
                </div>
              </div>


              <!--========= Check if the logged in user if Worker user or Company user  ==========-->
              <?php if(isset($_SESSION['type']) && $_SESSION['type'] == "Worker") : ?>
              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="cv">CV</label> 
                  <input type="file" name="cv" id="cv" class="form-control">
                </div>
              </div>

              <?php else: ?>

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="cv">CV</label> 
                  <input type="hidden" value="NULL" name="cv" id="cv" class="form-control">
                </div>
              </div>

              <?php endif; ?>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="Update Data" class="btn btn-primary btn-md text-white">
                </div>
              </div>

  
            </form>
            <!--========= Form End ==========-->
          </div>
          <!-- <div class="col-lg-5 ml-auto">
            <div class="p-4 mb-3 bg-white">
              <p class="mb-0 font-weight-bold">Address</p>
              <p class="mb-4">203 Fake St. Mountain View, San Francisco, California, USA</p>

              <p class="mb-0 font-weight-bold">Phone</p>
              <p class="mb-4"><a href="#">+1 232 3235 324</a></p>

              <p class="mb-0 font-weight-bold">Email Address</p>
              <p class="mb-0"><a href="#">youremail@domain.com</a></p>

            </div> -->
          </div>
        </div>
      </div>
    </section>

<?php require "../includes/footer.php"; ?>