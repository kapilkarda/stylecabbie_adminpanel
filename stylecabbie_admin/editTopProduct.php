<?php 
error_reporting(E_ALL); ini_set('display_errors', 1);
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  include('db.php');
   if(!(isset($_SESSION['id'])))
   {
      header("location:index.php");
   }
   if($_GET['topProduct_id']){
      $sqlProduct ="UPDATE `product` SET topProduct='0' where p_id='".$_GET['topProduct_id']."'";
      $query = mysqli_query($con, $sqlProduct);
      if ($query) {
      header("location:topProduct.php");
      } else {
      echo"try latter";
      }
   }

?>
<!DOCTYPE html>
