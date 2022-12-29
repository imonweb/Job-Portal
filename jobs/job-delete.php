<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php 
if(isset($_GET['id'])) {
  $id = $_GET['id'];
  $delete = $connection->prepare("DELETE FROM jobs WHERE id = '$id'");
  $delete->execute();

  header("location: ".APPURL. "");
} else {
  echo "404";
}

?>
  
    
<?php require "../includes/footer.php"; ?>