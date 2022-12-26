<?php 
  require "../includes/header.php"; 
  require "../config/config.php";

  if(isset($_GET['id'])){

    $id = $_GET['id'];
    
    $select = $connection->query("SELECT * FROM users WHERE id = '$id'");
    $select->execute();
    $profile = $select->fetch(PDO::FETCH_OBJ);
 
     
  } else {
    echo "404";
  }
?>
 
<section class="section-hero overlay inner-page bg-image" style="background-image: url('<?php echo APPURL; ?>/images/hero_1.jpg');" id="home-section">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-md-7">
            <div class="card p-3 py-4">
                    
                    <div class="text-center">
                        <img src="../user-images/<?php echo $profile->img; ?>" width="100" class="rounded-circle">
                    </div>
                    
                    <div class="text-center mt-3">
                        <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'Worker') : ?>
                          <a href="#" class="btn btn-primary" download>Download CV</a> 
                        <?php endif; ?>
                        <!-- <span class="bg-secondary p-1 px-4 rounded text-white">Pro</span> -->
                        <h5 class="mt-2 mb-0"><?php echo $profile->username; ?></h5>

                        <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'Worker') : ?>
                          <span><?php echo $profile->title; ?></span>
                        <?php endif; ?>
                        
                        
                        <div class="px-4 mt-1">
                            <p class="fonts"><?php echo $profile->bio; ?> </p>
                        
                        </div>
                        
                        <div class="px-3">
                    <a href="<?php echo $profile->facebook; ?>" class="pt-3 pb-3 pr-3 pl-0 underline-none"><span class="icon-facebook"></span></a>
                    <a href="<?php echo $profile->twitter; ?>" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-twitter"></span></a>
                    <a href="<?php echo $profile->linkedin; ?>" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-linkedin"></span></a>
                </div>
                    
                    </div>
             
                </div>
            </div>
        </div>

        
      </div>
</section>

<?php require "../includes/footer.php"; ?>