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
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      <!-- End : Side bar -->
      <div id="content">
        <!-- Start : Inner Page Content -->
        <div class="container">
          <!-- Start : Inner Page container -->
          <div class="crumbs">
            <ul id="breadcrumbs" class="breadcrumb">
              <li class="current">
                <i class="fa fa-home"></i>Ithink Excelsheet Delivered
              </li>
            </ul>
          </div>
          <div class="page-header">
            <div class="page-title">
              <h3>Ithink Excelsheet Delivered</h3>
            </div>
          </div>
          <div class="row">
         
            <div class="col-md-12">
           
            <form mehtod="post" id="export_excel">  
            <label>Select Excel</label>  
                 <input type="file" accept="application/vnd.ms-excel" id="my_file_input"  class="form-control" />
            </form>  
            <br />  
            <br />  
 
            <div id="result">  
            </div>  
            </div>  
      
          </div>
    </div>
      </div>
      <a href="javascript:void(0);" class="scrollup">Scroll</a>
    </div>
  </div>
  <?php include('footer.php');?>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.6/xls.js"></script>
 <script type="text/javascript">
  var oFileIn;

$(function() {
    oFileIn = document.getElementById('my_file_input');
    if(oFileIn.addEventListener) {
        oFileIn.addEventListener('change', filePicked, false);
    }
});


function filePicked(oEvent) {
    // Get The File From The Input
    var oFile = oEvent.target.files[0];
    var sFilename = oFile.name;
    // Create A File Reader HTML5
    var reader = new FileReader();
    
    // Ready The Event For When A File Gets Selected
    reader.onload = function(e) {
        var data = e.target.result;
        var cfb = XLS.CFB.read(data, {type: 'binary'});
        var wb = XLS.parse_xlscfb(cfb);
        // Loop Over Each Sheet

            // Obtain The Current Row As CSV
            var sheetName = wb.SheetNames[0];
            var sCSV = XLS.utils.make_csv(wb.Sheets[sheetName]);   
            var data = XLS.utils.sheet_to_json(wb.Sheets[sheetName], {header:1});  
             // console.log(data);
             // count(data);
            var arr = [];
            for (var i = 1; i < data.length; i++) {
              // console.log(data[i][0])
              // console.log(data[i][1])
              arr.push({
                  order_id : data[i][0]
              });
            }
            var jsonString= JSON.stringify(arr);
            // console.log(b);
              $.ajax({  
                url  : "exportdelivered.php" ,
                type : "POST", 
                data : {
                  id : jsonString
                },  
                cache: false,  
                success:function(res){  
                  console.log(res); 
                     $('#result').html(res);  
                     $('#excel_file').val('');  
                }  
              });  
          
      
    };
    
    // Tell JS To Start Reading The File.. You could delay this if desired
    reader.readAsBinaryString(oFile);
}

function export_in_excel(){
       //getting data from our table
    var data_type = 'data:application/vnd.ms-excel';
    var table_div = document.getElementById('table_wrapper');
    var table_html = table_div.outerHTML.replace(/ /g, '%20');

    var a = document.createElement('a');
    a.href = data_type + ', ' + table_html;
    a.download = 'exported_table_' + Math.floor((Math.random() * 9999999) + 1000000) + '.xls';
    a.click();
}

 </script>
</body>
</html>

