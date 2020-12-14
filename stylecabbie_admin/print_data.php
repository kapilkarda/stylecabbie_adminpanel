<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php 
      error_reporting(E_ALL); ini_set('display_errors', 1);
      if(!isset($_SESSION)) { 
              session_start(); 
      }
        include('db.php');
       if(!(isset($_SESSION['id']))){
          header("location:index.php");
       }
       if (isset($_POST['btn_add'])){
        $print=explode(",", $_POST['print']);
        foreach ($print as $value) {
          $sql=mysqli_query($con,"SELECT * FROM `order` o,`states` s,`cities` c  where order_id='$value' and o.state_id=s.state_id and o.city_id=c.city_id");
        $printData=mysqli_fetch_array($sql); ?>
    <div class="container" style="width: 70%; border: 1px solid;">
        <div class="row">
        <div class="col-md-9 col-sm-9" >
          <div>
            <strong>To,</strong>
            <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name:</strong><?php echo $printData['name'];?></p>
                <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address:</strong><?php echo $printData['address'];?></p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;City:<?php echo $printData['city_name'];?>,<?php echo $printData['state_name'];?>: <?php echo $printData['pin_code'];?></p>
                <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mobile No.:</strong> <?php echo $printData['mobile'];?></p>
          </div>
        </div>
        <div class="col-md-3 col-sm-3">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="img/mahakaal logo.png" style="height: 50%; width: 50%;">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-md-offset-6" style="float: right;">
          <div>
            <strong>From,</strong>
            <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name:</strong> Engineer Master Solutions Pvt. Ltd.</p>
            <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Address: </strong> 210, 1st Floor, 19A Electronic</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Complex, Pardeshipura Indore M.P. Pin: 452010</p>
            <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mobile No.:</strong> 8085305205</p>
          </div>
        </div>
      </div>
    </div>
              
    <?php 
       }
     }
    ?>
    
      
  </body>
</html>