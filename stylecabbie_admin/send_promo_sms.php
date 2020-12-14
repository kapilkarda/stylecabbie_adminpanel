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
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
      <title></title>
      <style>
.data-info
{
    margin: 0 auto;
    text-align: center;
    width: 350px;
}
select 
{
    margin: 25px;
    border: none;
    background: #f7f7f7;
    padding: 15px 10px;
    font-size: 16px;
    width:100%;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
 
}
</style>
</head>
    <body>
      <!-- Start : Side bar -->
      <?php 
         include('header.php');
         include('sidebar.php'); 
         ?>
      <!-- End : Side bar -->
      <div id="content">
        <!-- Start : Inner Page Content -->
        <div class="container">
          <!-- Start : Inner Page container -->
          <div class="crumbs">
            <ul id="breadcrumbs" class="breadcrumb">
              <li class="current">
                <i class="fa fa-home"></i>Send SMS 
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Send SMS</h3>
            </div>
          </div>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success col-md-8">
                         
            <div class="form-group has-success col-md-6">
              <button class="btn btn-danger" onclick="send_sms()" name="btn_add" type="button">Send SMS</button><br/><br/>
            </div>
            <div class="col-sm-6">
              <label>Count<span class="required">*</span></label>
              <input type="text" class="form-control" name="count" value="0"   id="count">
           </div>
        </div>
      </div>
    </div>
      </div>
      <a href="javascript:void(0);" class="scrollup">Scroll</a>
    </div>
  </div>


  <?php include('footer.php');?>
</body>
</html>

  <script type="text/javascript">
    function send_sms(){
            $.ajax({
              type:'POST',
              url: "send_msg_promo_ajax.php",
              success: function(response){
                 console.log(response);

                 if(response==1){
                  var count = document.getElementById("count").value;
                   var count = parseInt(count)
                  var count=count+1;
                  document.getElementById("count").value=count;
                    setTimeout(function()
                    {
                      send_sms(); 
                    }, 2000);
                 }else{
                 	console.log('no');
                 }
                }
            });
    }

    
</script>


