<?php 
  require_once('db.php');
  if (isset($_POST['upload'])) {
    $id=$_POST['id'];
       $image=$_FILES['picture']['name'];
       $date=date('Ymdhis');
            $path1 = "../customeImg/".$date.$_FILES["picture"]["name"];
            $path2 = "customeImg/".$date.$_FILES["picture"]["name"];
            if(move_uploaded_file($_FILES["picture"]["tmp_name"], $path1)){
             $query="UPDATE customorder SET customPic='$path2' WHERE customorder_id='$id'";
             $sql = mysqli_query($con, $query);
              if ($sql) {
               echo "<script>window.location.href='customMobilePrint.php';</script>";
              } else {
              echo"try latter";
              }
           
            }else{
               echo'not';exit;
            }
  }
?>
<!DOCTYPE html> 
<html lang ="en">
    <head>
        <meta charset="UTF-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Image</title>

        <meta name="description" content="Croppie is an easy to use javascript image cropper.">

        <meta property="og:title" content="Croppie - a javascript image cropper">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://foliotek.github.io/Croppie">
        <meta property="og:description" content="Croppie is an easy to use javascript image cropper.">
        <meta property="og:image" content="https://foliotek.github.io/Croppie/demo/hero.png">

        <link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,400italic,600,700' rel='stylesheet' type='text/css'>
        <link rel="Stylesheet" type="text/css" href="demo/prism.css" />
       <!--  <link rel="Stylesheet" type="text/css" href="bower_components/sweetalert/dist/sweetalert.css" /> -->
        <link rel="Stylesheet" type="text/css" href="demo/croppie.css" />
        <link rel="Stylesheet" type="text/css" href="demo/demo.css" />
       <!--  <link rel="icon" href="//foliotek.github.io/favico-64.png" /> -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    </head>
    <body>
    

        <section>
          
            <div class="demo-wrap">
                <div class="container">
                    <div class="grid">
                      
                        <div class="col-1-2" style="display: none;">
                            <div id="demo-basic"></div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="demo-wrap">
                    <div class="container">
                        <div class="grid">
                            <div class="col-1-2" style="width:950px; margin:0 auto;">
                                <div id="vanilla-demo" style="text-align: center;"></div>
                                  <?php 
                                    $cate1=mysqli_query($con,"SELECT * FROM `customorder` WHERE `customorder_id`='".$_GET['order']."'");
                                    $catres1=mysqli_fetch_array($cate1);
                                    $product_image1=$catres1['customPic'];
                                    $model=$catres1['brand'];
                                    $brand_Model=$catres1['brand_Model'];
                                    $mobileResult=mysqli_query($con,"select * from `mobileprint` WHERE `brand`='".$model."' and `model`='".$brand_Model."'");
                                    $mobileData = mysqli_fetch_array($mobileResult); 
                                  ?>
                                   <img id="imageURL" src="../<?php echo $product_image1;?>" alt="Picture" height="100px" width="100px" style="display: none;">
                                   <input type="hidden" name="innerwidth" value="<?php echo $mobileData['innerwidth'];?>" id="innerwidth">
                                   <input type="hidden" name="innerheight" value="<?php echo $mobileData['innerheight'];?>" id="innerheight">
                                   <input type="hidden" name="outerwidth" value="<?php echo $mobileData['outerwidth'];?>" id="outerwidth">
                                   <input type="hidden" name="outerheight" value="<?php echo $mobileData['outerheight'];?>" id="outerheight">
                                <div class="actions" >
                                    <center><button class="vanilla-result">Result</button>
                                    <button class="vanilla-rotate" data-deg="-90">Rotate Left</button>
                                    <button class="vanilla-rotate" data-deg="90">Rotate Right</button>
                                    </center>
                                </div>
                                <div class="col-md-6 actions" >
                                  <form action="" method="POST" enctype="multipart/form-data">
                                  <center><input type="file" name="picture" class="form-control" style="    margin-left: 54%;" required="">
                                    <input type="hidden" name="id" class="form-control" value="<?php echo $_GET['order'];?>">
                                    <button type="submit"  class="vanilla-rotate" name="upload" style="
                                       margin-right: -86%;margin-top: -10%;float: right;">Upload Image</button> </center>
                                  </form>   
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>
           
         
            
        </section>


       
        <footer style="display: none;">
            Copyright &copy; <span id="year">2017</span> | Foliotek
        </footer>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <!-- <script>window.jQuery || document.write('<script src="bower_components/jquery/dist/jquery.min.js"><\/script>')</script> -->
        <script src="demo/prism.js"></script>
       <!--  <script src="bower_components/sweetalert/dist/sweetalert.min.js"></script> -->

        <script src="demo/croppie.js"></script>
        <script  src="demo/demo.js?version=1.22"></script>
        <!-- <script src="bower_components/exif-js/exif.js"></script> -->
        <script>
            document.getElementById('year').innerHTML = (new Date).getFullYear();
            Demo.init();
        </script>
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-2398527-4');ga('send','pageview');
        </script>
   <!--      <a href="https://github.com/foliotek/croppie" class="github-corner"><svg width="80" height="80" viewBox="0 0 250 250" style="fill:#151513; color:#fff; position: absolute; top: 0; border: 0; left: 0; transform: scale(-1, 1); -webkit-transform: sale(-1, 1);"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"></path></svg><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style></a> -->
    </body>
</html>
