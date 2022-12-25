<?php 

$host = 'localhost';
$dbname = 'php_job_portal';
$user = 'imon';
$pass = 'p@ssw0rd';
 
try {
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e)
{
  echo $e->getMessage();                         
}
 
// define("APPURL","http://localhost/php/Udemy/Job-Portal");
 