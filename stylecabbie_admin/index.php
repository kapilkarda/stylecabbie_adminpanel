<?php
error_reporting(E_ALL); ini_set('display_errors', 0);
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    include('db.php');
    if(isset($_SESSION['id']))
   {
      header("location:dashboard.php");
   }

    $msg = "";
    if(isset($_POST['btn_login'])){
        $email      = mysqli_real_escape_string($con,$_POST['txtEmail']);
        $password   = mysqli_real_escape_string($con,$_POST['txtPassword']);
        if($email==""){
            $msg = "Email is required.";
        }else if($password==""){
            $msg = "Password is required.";
        }else{
            $sql="SELECT * from admin where `email`='$email' and `password`='$password'";
            $query=mysqli_query($con,$sql);
            // print_r($query);exit;
            if($row = mysqli_fetch_array($query)){
                // echo "string";
                // echo$row['admin_id'];exit;
                    $_SESSION['id']        = $row['admin_id'];
                    $_SESSION['email']       = $row['email'];
                    $_SESSION['name']       = $row['name'];
                    header('location:dashboard.php');
            }else{
                $msg = "Invalid Credential.";
            }
             
        }
    }
?>

<!DOCTYPE html>
<html lang="en"> 
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>Admin</title>

    <!--[if lt IE 9]> <script src="assets/plugins/common/html5shiv.js" type="text/javascript"></script> <![endif]-->
    <script src="assets/plugins/common/modernizr.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.css" />
    <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/><![endif]-->
    <link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome/css/font-awesome.css"/>
    <link rel="stylesheet" type="text/css" href="assets/fonts/fsquere/style.css"/>
    <link rel='stylesheet' type='text/css' href="assets/fonts/open-sans/open-sans.css">
    
    <link rel='stylesheet' type='text/css' href="assets/plugins/uniform/css/uniform.default.html">

    <link href="assets/css/main.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/style_default.css" rel="stylesheet" type="text/css"/>
    
    <!-- <link rel="icon" type="image/png" href="assets/images/favicon.ico"> -->
    <link rel="apple-touch-icon-precomposed" href="assets/images/apple-touch-icon-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/apple-touch-icon-72x72-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/apple-touch-icon-114x114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/apple-touch-icon-144x144-precomposed.html">

</head>
<body class="login" style="background: #fff;">
     <div class="logo" style="
    color: #fff;">
    <font size="6"><center>AfterFeed</center></font>
           <!-- <img src="img/sayso_logo.png" alt="logo" style="
            width: 216px;
        height: auto;
        margin-left: 33px;"/> -->
    <div class="content">
        <form class="form-vertical login-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h3 class="form-title">Login to your account</h3>
            <div class="alert alert-danger <?php if($msg==''){ echo 'hide'; } ?>">
                <button class="close" data-dismiss="alert"></button>
                <span><?php echo $msg; ?>.</span>
            </div>
            <div class="control-group">
                <label class="control-label">Username</label>
                <div class="controls">
                    <div class="input-icon left">
                        <i class="fs-user-2"></i>
                        <input class="form-control" type="text" placeholder="Username" name="txtEmail"/>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Password</label>
                <div class="controls">
                    <div class="input-icon left">
                        <i class="fs-locked"></i>
                        <input class="form-control" type="password" placeholder="Password" name="txtPassword"/>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <input type="submit" class="btn green pull-left" name="btn_login" value=" Login" style="
                    margin-right: 20px;
                ">
            </div>
        </form>
    </div>
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="assets/plugins/common/jquery.blockUI.js"></script>
    <script type="text/javascript" src="assets/plugins/common/jquery.event.move.js"></script>
    <script type="text/javascript" src="assets/plugins/common/respond.min.js"></script>
    
    <script type="text/javascript" src="assets/plugins/uniform/jquery.uniform.min.html"></script>

    <script type="text/javascript" src="assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            App.initLogin();
        });
    </script>
</body>
</html>