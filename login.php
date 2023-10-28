<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
<?php
include 'about_app.php';
include 'base/koneksi.php';
?>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo "Login | ".$app_name ?></title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
</head>
<?php
if (isset($_POST['signin'])) {
    $stat=mysqli_query($l, "SELECT * FROM admin WHERE id_admin=1");
    $data=mysqli_fetch_array($stat);
    $pass = md5($_POST['password']);
    if ($data['pass_admin'] == $pass && $data['username_admin'] == $_POST['username']) {
        $_SESSION['admin'] = $data['nama_admin'];
?>
        <script type="text/javascript">
            document.location = "index.php";
        </script>
<?php
    }else{
?>
        <script type="text/javascript">
            document.location = "?alert=salah";
        </script>
<?php
}
}
?>
<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);"><?php echo $app_name ?></a>
            <small><?php echo $app_desc ?></small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" method="POST" action="">
                    <div class="msg">Masukan Username dan Password Administrator</div>
                    <font color="red"><?php if(isset($_GET['alert'])){ echo "Username atau Password Salah!";} ?></font>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                        
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit" name="signin">SIGN IN</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="lupa_pass.php">Lupa Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/examples/sign-in.js"></script>
</body>

</html>