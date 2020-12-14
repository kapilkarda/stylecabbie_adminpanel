<?php
   require_once('db.php');
    // if(!(isset($_SESSION['user_id'])))
    //  {
    //     header("location:index.php");
    //  }
   if(isset($_GET['id'])){
   	 $cat_id = $_GET['id'];		
   }else{
   	header('location:index.php');
   }

   $chkcustom = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM customProductImage WHERE `cat_id`='$cat_id'"));
   $id = $chkcustom['cat_id'];
   $image = "./afterfeed_admin/".$chkcustom['customProductImage_image'];
   $title = $chkcustom['customProductImage_title'];
   $desc = $chkcustom['customProductImage_desc'];
   $price = $chkcustom['price'];
   $main_price = $chkcustom['main_price'];
   $category_id = $chkcustom['cat_id'];
 
   //echo "SELECT * from category where cat_id='$category_id'"; exit();  
   $sqlCatName = mysqli_query($con, "SELECT * from category where cat_id='$category_id'");
   if($rowCatName = mysqli_fetch_array($sqlCatName)){
      $cat_name = $rowCatName['cat_name'];
   	$url = $rowCatName['url'];
   }
   
   ?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>
         Mahakaal Store</title> 
      <meta name="author" content="Afterfeed Shop">
      <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
      <meta name="author" content="Mahakaal Shop">
      <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
      <meta property="og:title" content="<?php echo $title; ?> RS <?php echo $price; ?> Only">
      <meta property="og:description" content="<?php echo $desc; ?>" />
      <meta property="og:url" content="http://www.mahakaalstore.com/customMobileCover.php?id=4">
      <meta property="og:image" content="<?php echo $image; ?>">
      <meta property="og:site_name" content="Mahakaalstore">
      <link rel="shortcut icon" href="favicon.ico">
      <?php
         require_once('headlink.php');
      ?>
   </head>
   <body class="boxed">
      <!-- Loader -->
      <div id="loader-wrapper">
         <div class="cube-wrapper">
            <div class="cube-folding">
               <span class="leaf1"></span>
               <span class="leaf2"></span>
               <span class="leaf3"></span>
               <span class="leaf4"></span>
            </div>
         </div>
      </div>
      <div id="wrapper">
         <!-- Page -->
         <div class="page-wrapper">
            <!-- Header -->
            <?php
               $variant = 2;
               require_once('header.php');
               ?>
            <!-- /Sidebar -->
            <!-- Page Content -->
            <main class="page-main">
               <div class="block">
                  <div class="container">
                     <ul class="breadcrumbs">
                        <li><a href="index.php"><i class="icon icon-home"></i></a></li>
                        <li>/<a href="<?php echo $url;?>?id=<?php echo $id;?>"><?php echo $cat_name; ?> </a></li>
                     </ul>
                  </div>
               </div>
               <div class="block product-block">
                  <div class="container">
                     <div class="row">
                       <div class="col-sm-6 col-md-6 col-lg-4">
                           <!-- Product Gallery -->
                           <div class="main-image">
                              <img src="<?php echo $image; ?>" class="zoom" alt="" data-zoom-image="<?php echo $image; ?>" />
                              <div class="dblclick-text">
                                 <span>Double click for enlarge</span>
                              </div>
                              <!-- <a href="images/products/large/product-gallery-1.jpg" class="zoom-link"><i class="icon icon-zoomin"></i></a> -->
                           </div>
                           <div class="product-previews-wrapper">
                              <div class="product-previews-carousel" id="previewsGallery">
                                 <?php $ProductImage = mysqli_query($con, "SELECT * from custom_image_product  where product_id='$id'");
                                    while($rowProductImage = mysqli_fetch_array($ProductImage)){
                                    ?>
                                    <a href="#" data-image="afterfeed_admin/<?php echo $rowProductImage['image']; ?>" data-zoom-image="afterfeed_admin/<?php echo $rowProductImage['image']; ?>"><img src="afterfeed_admin/<?php echo $rowProductImage['image']; ?>" alt="" /></a>
                                 <?php } ?>
                              </div>
                           </div>
                           <!-- /Product Gallery -->
                        </div>
                        <form  method="post" name="feedback" enctype="multipart/form-data" action="custom1Checkout.php">
                           <input type="hidden" name="cat_id" value="<?php echo $_GET['id'];?>" />
                           <div class="col-sm-6 col-md-6 col-lg-8">
                              <div class="product-info-block classic">
                                 <div class="product-name-wrapper">
                                    <h1 class="product-name">
                                       <?php echo $title;?>
                                    </h1>
                                 </div>
                                 <div class="product-description">
                                    <?php echo $desc; ?>
                                 </div>
                                 <span style="color: #f82e56;font-size: 20px;font-weight: 400" id="login_error1"></span>
                                 <div class="product-options" id="table_row">
                                    <div class="col-sm-4 col-md-4 col-lg-4" style="width: 40%;float: left;">
                                             <span class="option-label">Upload Picture:</span> 
                                             <input type="file" name="pic_upload" class="form-control" />
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-4" style="width: 40%;float: left;">
                                             <span class="option-label">Write Text</span> 
                                             <input type="text" name="text" class="form-control"  />
                                    </div>
                                    <?php  if($chkcustom['size_status']=='True'){ ?> 
                                       <div class="product-size swatches">
                                           <span class="option-label">Size:</span>
                                             <div class="form-group radio-pink-gap ">
                                                <?php    
                                                   $product_size = $chkcustom['size'];
                                                   $product_array=explode(',',$product_size);
                                                   for ($i=0; $i < count($product_array); $i++) { 
                                                ?> 
                                                   <label style="float: left;font-size: 20px;font-weight: 700;margin-left: 10px;" for="radio109"><?php echo$product_array[$i]; ?></label>
                                                   <input required name="size" type="radio" class="with-gap form-control" id="radio38" style="width: 7%;float: left;height: 22px;" value="<?php echo$product_array[$i]; ?>">
                                                <?php } ?>
                                             </div>
                                       </div>
                                    <?php } ?>
                                    <br><br>
                                    <?php  if($chkcustom['colour_status']=='True'){ ?>  
                                       <div class="product-size swatches">
                                           <span class="option-label">Color:</span>
                                                <?php    
                                                   $colour = $chkcustom['colour'];
                                                   $colour_array=explode(',',$colour);
                                                   for ($i=0; $i < count($colour_array); $i++) { 
                                                ?> 
                                                   <div class="radio-pink-gap ">
                                                         <label style="float: left;font-size: 20px;font-weight: 700;margin-left: 10px;" for="radio109"><?php echo $colour_array[$i]; ?></label>
                                                         <input required name="color" type="radio" class="with-gap form-control" id="radio38" style="width: 7%;float: left;height: 22px;" value="<?php echo $colour_array[$i]; ?>">
                                                   </div>
                                                <?php } ?>
                                       </div>
                                    <?php } ?>
                                    <br><br>
                                    <?php  if($chkcustom['model_status']=='True'){ ?>  
                                          <div class="col-sm-4 col-md-4 col-lg-4" style="width: 40%;float: left;">
                                                <div class="select-wrapper">
                                                   <select class="form-control" required id="brand" name="brand"  onchange="model_list()">
                                                      <option value="">Select Brand</option>
                                                      <?php
                                                         $cover_query = mysqli_query($con, "SELECT * FROM cover_sub_category GROUP BY cat_id ");
                                                         while($row_cover = mysqli_fetch_array($cover_query)){
                                                         ?>
                                                         <option  value="<?php echo $row_cover['cat_id'];?>"><?php echo $row_cover['cat_id'];?></option>
                                                      <?php }?>
                                                   </select>
                                                </div>
                                          </div>
                                          <div class="col-sm-4 col-md-4 col-lg-4" style="width: 40%;float: left;">
                                                <div class="select-wrapper">
                                                   <select  required class="form-control" id="model" name="model" >
                                                      <option value="">Select Model</option>
                                                   </select>
                                                </div>
                                          </div>
                                    <?php } ?>
                                    <br><br>
                                    <div class="product-qty">
                                          <span class="option-label">Qty:</span>
                                          <div class="qty qty-changer">
                                             <fieldset>
                                                <input type="button" id="minus" value="&#8210;" class="decrease"  onclick="decrease();">
                                                <input type="text" name="qty" id="product_qunt" class="qty-input"  value="1" data-min="1" data-max="50" onchange="insert_qunt_product()">
                                                <input type="button" id="plus" value="+" class="increase"  onclick="increase();">
                                             </fieldset>
                                          </div>
                                    </div>
                                 </div>
                                 <div class="product-actions" id="table_row">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <span class="option-label">Price:</span>
                                          <div class="price" style="display: inline;">
                                              <input type="hidden" id="Mainprice" value="<?php echo $main_price;?>" >
                                             <input type="hidden" id="product_price" value="149" name="price">
                                             <span class="old-price"><span><?php echo $price;?></span></span>
                                             <span class="special-price" id="total_priceproduct"><span >₹<?php echo $main_price;?></span></span>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="actions">
                                             <?php
                                                if (isset($_SESSION['user_id'])) { ?>
                                                   <button type="submit" class="btn btn-cart" class="product-item-link">Proceed to Order</button>
                                             <?php } else{
                                                ?>
                                             <a title="Long sleeve overall" href="#" class="btn btn-cart"  data-toggle="modal" data-target="#myModal" class="product-item-link">Proceed to Order
                                             </a>
                                             <?php } ?>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                        <div class="clearfix hidden-lg"></div>
                     </div>
                  </div>
               </div>
               <div class="block">
               </div>
            </main>
            <!-- /Page Content -->
            <!-- Footer -->
            <?php
               require_once('footer.php');
            ?>
            <!-- /Footer -->
         </div>
         <!-- /Page -->
      </div>
      <!-- ProductStack -->
      <?php
         require_once('extra.php');
         require_once('footerscript.php');
      ?>
   </body>
</html>
<script type="text/javascript">
   function increase(){
     var id= parseInt(document.getElementById('product_qunt').value)+1;
     var price= document.getElementById('Mainprice').value;
     document.getElementById('total_priceproduct').innerHTML='₹'+id*price;
   }

   function decrease(){
      if(document.getElementById('product_qunt').value==1){
         var price= document.getElementById('Mainprice').value;
         document.getElementById('total_priceproduct').innerHTML='₹'+1*price;
      }else{
         var id= parseInt(document.getElementById('product_qunt').value)-1;
         var price= document.getElementById('Mainprice').value;
         document.getElementById('total_priceproduct').innerHTML='₹'+id*price;
      }
   }

   function productsize(){

      var a = document.getElementById('radio38');
      var b = document.getElementById('radio40');
      var c = document.getElementById('radio42');
      var d = document.getElementById('radio44');

      if ( (a.checked == false ) && (b.checked == false ) && (c.checked == false )&& (d.checked == false ))
      {
      document.getElementById('login_error1').innerHTML = "Please select size!";
      return false;
      }
      return true;
   }
</script>