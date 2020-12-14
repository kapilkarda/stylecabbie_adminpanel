<div id="myModalabc" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
            <h3 class="modal-title">Verification Mobile</h3>
         </div>
         <br>
         <div class="modal-body">
            <div class="form-group">
               <input type="text" class="form-control" placeholder=" Mobile No." name="otp_mobile" id="txt_mobile">
               <p id="login_error_mobile" style="color:red;"></p>
            </div>
            <button type="submit" class="btn btn-primary" onclick="mobileverification();">submit</button>
            <!--  </form> -->
         </div>
      </div>
   </div>
</div>
<div id="myModalotp" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
            <h3 class="modal-title">Verifying it's you</h3>
         </div>
         <br>
         <div class="modal-body">
            <p>For your security, we need to verify your identity. We've sent a code to the mobile <span id="mobile_no_otp"></span> Please enter it below to complete verification.</p>
            <p id="login_error_otpverify" style="color:red;"></p>
            <div class="form-group">
               <input type="text" class="form-control" placeholder="otp" name="txt_otp" id="txt_otp">
               <p id="login_error_otp" style="color:red;"></p>
            </div>
            <button type="submit" class="btn btn-primary" onclick="absde();">submit</button>
         </div>
      </div>
   </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h2 class="modal-title">Login Customers</h2>
         </div>
         <div class="modal-body">
            <div class="dropdown-container right">
               <br>
               <div class="top-text">If you have an account with us, please log in.</div>
               <!-- form -->
              <form >
                 <div>
                    <p id="login_error"></p>
                    <div id="restPassword" style="display:none;">
                       <div class="alert alert-success sm">First time please reset your password.<a href="forgot-password.php" style="margin-left: 11px; background:none;border:none;">Click Here</a>
                       </div>
                    </div>
                    <input type="text" class="form-control" placeholder="Mobile No.*" id="txt_username" onfocusout="myFunction()" >
                    <input type="password" class="form-control" placeholder="Password*" id="txt_password">
                 </div>
                <!-- /form -->
                <a href="forgot-password.php">Forgot Password</a>
                <b>OR</b> Create a <a href="register.php">New Account</a><br>
                <div class="form-group options">
                  <input type="checkbox" class="checkIt" id="txt_check" name="check[]" required="" checked=""> <a href="refund.php"> I accept the Terms and Conditions</a>
                </div>
              </form>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" onclick="headerLogin();" class="btn" style="
               margin-top: 23px;
               ">Sign in</button>
            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
         </div>
      </div>
   </div>
</div>
<!-- jQuery Scripts  -->
<script src="js/vendor/jquery/jquery.js"></script>
<script src="js/vendor/bootstrap/bootstrap.min.js"></script>
<script src="js/vendor/swiper/swiper.min.js"></script>
<script src="js/vendor/slick/slick.min.js"></script>
<script src="js/vendor/parallax/parallax.js"></script>
<script src="js/vendor/isotope/isotope.pkgd.min.js"></script>
<script src="js/vendor/magnificpopup/dist/jquery.magnific-popup.js"></script>
<script src="js/vendor/countdown/jquery.countdown.min.js"></script>
<script src="js/vendor/nouislider/nouislider.min.js"></script>
<script src="js/vendor/ez-plus/jquery.ez-plus.js"></script>

<script src="js/vendor/bootstrap-tabcollapse/bootstrap-tabcollapse.js"></script>
<script src="js/vendor/scrollLock/jquery-scrollLock.min.js"></script>
<script src="js/vendor/darktooltip/dist/jquery.darktooltip.js"></script>
<script src="js/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="js/vendor/instafeed/instafeed.min.js"></script>
<script src="js/megamenu.min.js"></script>
<script src="js/tools.min.js"></script>
<script src="js/app.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
       $(".closebtn").click(function(){
          $(".topbar_mobile").addClass("displaynone");
      });
  });
</script>
<script type="text/javascript">
  function close(){
    // document.getElementById("myDIV").style.display = "none";
    // var x = document.getElementById("myDIV");
    // if (x.style.display === "block") {
    //     x.style.display = "none";
    // }
    $(".closebtn").click(function(){
        $("#myDIV").hide();
    });

  }
</script>
<script type="text/javascript">

   function mobileverification() { 
   
     var otp_mobile = document.getElementById('txt_mobile').value;
    
    if(otp_mobile.trim()==""){
      document.getElementById('login_error_mobile').innerHTML = "Please Enter the Mobile Number.";
      return false;
    }
   
    if(isNaN(otp_mobile)){
      document.getElementById('login_error_mobile').innerHTML = "Enter the valid Mobile Number!";
   return false;
     }
   if((otp_mobile.length < 10) || (otp_mobile.length > 10)){
     document.getElementById('login_error_mobile').innerHTML = " Your Mobile Number must be 1 to 10 Integers";
   return false;
   }
   
   if (!(otp_mobile.charAt(0)=="9" ||otp_mobile.charAt(0)=="8"||otp_mobile.charAt(0)=="7"))
          {
           document.getElementById('login_error_mobile').innerHTML = "Mobile No. should start with 9 or 8 or 7";
               return false;
    
             } 
    
   
       $.ajax({
       url: "logic.php",
       type: 'POST',
       data: {
       action:'addtocart',
       otp_mobile:otp_mobile,
             },
    success: function(data) {
         //console.log(data);
     
        $('#myModalabc').modal('hide'); 
        $('#myModalotp').modal({backdrop: 'static', keyboard: false}); 
       var mobile_data=JSON.parse(data);
       //console.log(mobile_data.mobile_no);
       document.getElementById('mobile_no_otp').innerHTML = mobile_data.mobile_no;   
        //alert("product added to cart");
       }
       });
         }
     
</script>
<script>
   function myFunction(){
   //alert('hi');
   var mobile = document.getElementById('txt_username').value;
   $.ajax({
       url: "logic.php",
       type: 'POST',
       data: {
       mobile:mobile,
     
       },
       success: function (data) {
         console.log(data);
         // $('#coupon').html();
         if (data==1) {
           $('#restPassword').css("display","block");
         }
       }
       });
   }
</script>
<script type="text/javascript">
function ValidateAlpha(evt)
  {
      var keyCode = (evt.which) ? evt.which : evt.keyCode
      if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)
       
      return false;
          return true;
  }
  function getEventTarget(e) {
    e = e || window.event;
    return e.target || e.srcElement; 
}


 function addtocartproduct(id){
   
   var product_price = $("#product_price"+id).val();  
   var product_qunt = $("#product_qunt"+id).val();   
   var users_id=<?php if(isset($_SESSION['user_id'])){ echo $_SESSION['user_id']; }else{ echo'0';} ?>;
   var total_priceproduct=product_price*product_qunt;
   $.ajax({
   url: "logic.php",
   type: 'POST',
   data: {
  
   users_id:users_id,
   productid:id,
   product_proprice:total_priceproduct,
   product_qunt:product_qunt,
   },
   success: function(data) {
   console.log(data);
   $("#addto").hide();
   $("#removeto").show();
   $("#productStack").html(data); 
    parent.window.location.reload(true);      
   //alert("product added to cart");
   }
   });


 }





   function addtocart(id) { 
   var product_price = $("#product_price"+id).val();    
   var user_id=<?php if(isset($_SESSION['user_id'])){ echo $_SESSION['user_id']; }else{ echo'0';} ?>;
    
   $.ajax({
   url: "logic.php",
   type: 'POST',
   data: {
   action:'addtocart',
   user_id:user_id,
   productid:id,
   product_price:product_price,
   },
   success: function(data) {
   console.log(data);
   $("#addto").hide();
   $("#removeto").show();
   $("#productStack").html(data); 
    parent.window.location.reload(true);      
   //alert("product added to cart");
   }
   });
   }
   
   
   
   
   //buy now
   function buynow(id) { 

    var product_price = $("#product_price"+id).val();  
   var product_qunt = $("#product_qunt"+id).val();   
   var users_id=<?php if(isset($_SESSION['user_id'])){ echo $_SESSION['user_id']; }else{ echo'0';} ?>;
   var total_priceproduct=product_price*product_qunt;
   $.ajax({
   url: "logic.php",
   type: 'POST',
   data: {
  
   users_id:users_id,
   productid:id,
   product_proprice:total_priceproduct,
   product_qunt:product_qunt,
   },

   
   success: function (data) {
    // console.log(data);
   window.location.href ='buynow.php?id='+id;
   }
   });
   }
   
   
     // alert for delete
     function ConfirmDelete()
     {
     var x = confirm("Are you sure you want to delete?");
     if (x)
     return true;
     else
     return false;
     }
   
     function removetocart(id) {  
  
     // var productid = $("#productid").val();    
     var userId=<?php if(isset($_SESSION['user_id'])){ echo $_SESSION['user_id']; }else{ echo'0';} ?>;
        $.ajax({
     url: "logic.php",
     type: 'POST',
     data: {
     action:'addtocart',
     removeid:id, 
     userId:userId
     },
     success: function(data) {
     console.log(data);
     $("#table_row"+id).hide();
     $("#removeto").hide();
     $("#addto").show();
     $("#productStack").html(data); 
     parent.window.location.reload(true);       
     //alert("product added to cart");
     }
     });
     }
   
   /*function deleteproduct(id) {
   
   // var productid = $("#productid").val();
   
   var user_id=<?php echo $_SESSION['user_id'];?>;
   $.ajax({
            url: "logic.php",
            type: 'POST',
            data: {action:'deletetocart',
                    user_id:user_id,
                    delproductid:id,                       
            },
            success: function(data) {
              $("#delproduct").hide();
            //  $("#productStack").html(data);       
    // alert("product removed from cart");        
            }
        });
   }*/
   //show cart
         setInterval(showcart, 5000); 
         function showcart() {
         // var productid = $("#productid").val();
         var user_id=<?php if(isset($_SESSION['user_id'])){ echo $_SESSION['user_id']; }else{ echo'0';} ?>;
         $.ajax({
         url: "logic.php",
         type: 'POST',
         data: {action:'addtocart',
         showuser_id:user_id,
         // removeid:id,
         },
         success: function(data) {
         //$("#addto").hide();
         $("#show_cart").html(data);       
         // alert("product added to cart");
         }
         });
         }
   
   //insert quntity of product
   
       function insert_qunt(id) {
       var product_qunt = $("#product_qunt").val();
       var product_price = $("#product_price"+id).val();
       var user_id=<?php if(isset($_SESSION['user_id'])){ echo $_SESSION['user_id']; }else{ echo'0';} ?>;
       $.ajax({
       url: "logic.php",
       type: 'POST',
       data: {action:'product_qunt',
       user_id:user_id,
       cart_id:id,
       product_qunt:product_qunt,
       product_price:product_price,
       },
       success: function(data) {
       //$("#addto").hide();
       $("#total_price"+id).html(data);       
       alert("product qunt added");
       }
       });
       }
   
  

//Insert quantity for product

  
   
     

  
   
       //state
       function state_list() {
   
       var state_id = $("#state").val();
       $.ajax({
       url: "logic.php",
       type: 'POST',
       data: {action:'state',
       state_id:state_id,
   
       },
       success: function(data) {
       //$("#addto").hide();
       $("#city").html(data);       
   
       }
       });
       }


       //state
       function model_list() {
   
           var brand = $("#brand").val();
           $.ajax({
             url: "logic.php",
             type: 'POST',
             data: {action:'brand',
             brand:brand,
         
             },
             success: function(data) {
             //$("#addto").hide();
             $("#model").html(data);       
         
             }
           });
       }



       //


        //insert quntity of product
   
       function insert_qunt_product(id) {
       var productqunt = $("#product_qunt").val();
       var productprice = $("#product_price"+id).val();
       var userid=<?php if(isset($_SESSION['user_id'])){ echo $_SESSION['user_id']; }else{ echo'0';} ?>;
       $.ajax({
       url: "logic.php",
       type: 'POST',
       data: {
       userid:userid,
       product_id:id,
       productqunt:productqunt,
       productpriceproduct:productprice,
       },
       success: function(data) {
       //$("#addto").hide();
       $("#total_priceproduct"+id).html(data);       
       alert("product qunt added");
       }
       });
       }
   
       function insert_qunt_increase_product(id) {
       
           var productqunt = $("#product_qunt"+id).val();

           var a=1;
           if(productqunt>=10){
            $("#plus").attr('disabled', 'disabled');
           }else{
            productqunt1=Number(productqunt)+Number(a);
            //alert(product_qunt1);
           }

           var productprice = $("#product_price"+id).val();
         
           var userids=<?php if(isset($_SESSION['user_id'])){ echo $_SESSION['user_id']; }else{ echo'0';} ?>;
         
            $.ajax({
               url: "logic.php",
               type: 'POST',
               data: {
               userids:userids,
               product_id:id,
               productquntincrease:productqunt1,
               product_price:productprice,
               },
               success: function(data) {
                console.log(data);
               //$("#addto").hide();
               $("#total_priceproduct"+id).html(data);       
               //alert("product qunt added");
               }
            });
       }
   
       function insert_qunt_decrease_prduct(id) {

       var productprice = $("#product_price"+id).val();
      
       var userid=<?php if(isset($_SESSION['user_id'])){ echo $_SESSION['user_id']; }else{ echo'0';} ?>;
       var productqunt = $("#product_qunt"+id).val();
      
       var a=1;
       if(productqunt<=1){
        $("#minus").attr('disabled', 'disabled');
       }else{
        productqunt1=Number(productqunt)-Number(a);
       // alert(product_qunt1);
       }
       $.ajax({
       url: "logic.php",
       type: 'POST',
       data: {
       userid:userid,
       product_id:id,
       productquntdecrease:productqunt1,
       product_price:productprice,
       },
       success: function(data) {
       // console.log(data);
       //$("#addto").hide();
       $("#total_priceproduct"+id).html(data);       
       //alert("product qunt added");
       }
       });
       }







       
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-38541853-15"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-38541853-15');
</script>