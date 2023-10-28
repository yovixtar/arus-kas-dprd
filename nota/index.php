<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
<?php
if (!isset($_SESSION['admin'])) {
    ?>
    <script type="text/javascript">document.location="../login.php"</script>
    <?php
}
include '../base/koneksi.php';
include '../about_app.php';
?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo "Nota | ".$app_name ?></title>
    <!-- Favicon-->
    <link rel="icon" href="../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap Core Css -->
    <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="../plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="../plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../css/themes/all-themes.css" rel="stylesheet" />
    
    
    <script type="text/javascript">
        function angka(e) {
          if (!/^[0-9]+$/.test(e.value)) {
            e.value = e.value.substring(0,e.value.length-1);
          }
        }
    </script>
    
</head>

<body class="theme-red">
    <!-- Page Loader -->
<!--     <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div> -->
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo $url_app; ?>"><?php echo $app_star; ?> - <?php echo $app_name; ?></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="../favicon.ico" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['admin'] ?></div>
                    <!-- <div class="email"></div> -->
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="../?page=profile"><i class="material-icons">person</i>Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="../logout.php"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li>
                        <a href="<?php echo $url_app ?>">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo $url_app."/kegiatan" ?>">
                            <i class="fas fa-tasks" style="margin-top:4px;font-style: normal; font-size: 24px; line-height: 1; letter-spacing: normal; text-transform: none; display: inline-block; white-space: nowrap; word-wrap: normal;"></i>
                            <span>Kegiatan</span>
                        </a>
                    </li>
                     <li class="active">
                        <a href="<?php echo $url_app."/nota" ?>">
                            <i class="material-icons">assignment</i>
                            <span>Nota</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $url_app."/laporan" ?>">
                            <i class="material-icons">library_books</i>
                            <span>Laporan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $url_app."/pengaturan" ?>">
                            <i class="material-icons">settings</i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; <?php echo date('Y'); ?> <a href="javascript:void(0);"><?php echo $app_star." - ".$app_name; ?></a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active" style="width: 100%"><a href="#skins" data-toggle="tab">SKINS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <?php
        $sw=isset($_GET['page']) ? $_GET['page'] : null;
        switch ($sw) {
            case 'tambahnota':
                include 'tambah_view.php';
                break;
            case 'tambahaksi':
                include 'tambah_aksi.php';
                break;
            case 'editnota':
                include 'edit_view.php';
                break; 
            case 'editaksi':
                include 'edit_aksi.php';
                break;   
            
            default:
                include 'view_all.php';
                break;
        }
        ?>
    </section>

    <script src="../plugins/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript">
        function hapusNota(idx) {
            swal({
              title: "Hapus Nota",
              text: "Apakah anda yakin akan menghapusnya ?",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                var xhttp;    
                  xhttp = new XMLHttpRequest();
                  xhttp.open("GET", "hapus_aksi.php?idx="+idx, true);
                  xhttp.send();
                swal("Nota terhapus !", {
                  icon: "success", button:false, timer: 1100,})
                .then((value) => {
                  location.reload();
                });
                
              } else {
                
              }
            });
        }
    </script>
    <?php
    if (isset($_GET['page'])) {
    if ($_GET['page']=="tambahnota") {
    ?>
    <!-- Jquery Core Js --><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  <script src="../plugins/jquery/jquery.min.js"></script> <!-- Bootstrap Core Js --> <script src="../plugins/bootstrap/js/bootstrap.js"></script> <!-- Select Plugin Js --> <script src="../plugins/bootstrap-select/js/bootstrap-select.js"></script> <!-- Slimscroll Plugin Js --> <script src="../plugins/jquery-slimscroll/jquery.slimscroll.js"></script> <!-- Waves Effect Plugin Js --> <script src="../plugins/node-waves/waves.js"></script> <!-- Autosize Plugin Js --> <script src="../plugins/autosize/autosize.js"></script> <!-- Moment Plugin Js --> <script src="../plugins/momentjs/moment.js"></script> <!-- Bootstrap Material Datetime Picker Plugin Js --> <script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script> <!-- Bootstrap Datepicker Plugin Js --> <script src="../plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> <!-- Custom Js --> <script src="../js/admin.js"></script> <script src="../js/pages/forms/basic-form-elements.js"></script> <!-- Demo Js --> <script src="../js/demo.js"></script> <script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1ef022ab/dist/jquery.mask.min.js"></script> <!-- SweetAlert Plugin Js --> <script src="../../plugins/sweetalert/sweetalert.min.js"></script> 
    <?php
    }
    
    if ($_GET['page']=="editnota") {
    ?>
    <!-- Jquery Core Js --><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  <script src="../plugins/jquery/jquery.min.js"></script> <!-- Bootstrap Core Js --> <script src="../plugins/bootstrap/js/bootstrap.js"></script> <!-- Select Plugin Js --> <script src="../plugins/bootstrap-select/js/bootstrap-select.js"></script> <!-- Slimscroll Plugin Js --> <script src="../plugins/jquery-slimscroll/jquery.slimscroll.js"></script> <!-- Waves Effect Plugin Js --> <script src="../plugins/node-waves/waves.js"></script> <!-- Autosize Plugin Js --> <script src="../plugins/autosize/autosize.js"></script> <!-- Moment Plugin Js --> <script src="../plugins/momentjs/moment.js"></script> <!-- Bootstrap Material Datetime Picker Plugin Js --> <script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script> <!-- Bootstrap Datepicker Plugin Js --> <script src="../plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> <!-- Custom Js --> <script src="../js/admin.js"></script> <script src="../js/pages/forms/basic-form-elements.js"></script> <!-- Demo Js --> <script src="../js/demo.js"></script> <script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1ef022ab/dist/jquery.mask.min.js"></script> <!-- SweetAlert Plugin Js --> <script src="../../plugins/sweetalert/sweetalert.min.js"></script> 
        <?php
    }
    
    }else {?> <!-- Jquery Core Js --> <script src="../plugins/jquery/jquery.min.js"></script> <!-- Bootstrap Core Js --> <script src="../plugins/bootstrap/js/bootstrap.js"></script> <!-- Select Plugin Js --> <script src="../plugins/bootstrap-select/js/bootstrap-select.js"></script> <!-- Slimscroll Plugin Js --> <script src="../plugins/jquery-slimscroll/jquery.slimscroll.js"></script> <!-- Waves Effect Plugin Js --> <script src="../plugins/node-waves/waves.js"></script><!-- Jquery DataTable Plugin Js --> <script src="../plugins/jquery-datatable/jquery.dataTables.js"></script> <script src="../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script> <script src="../plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script> <script src="../plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script> <script src="../plugins/jquery-datatable/extensions/export/jszip.min.js"></script> <script src="../plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script> <script src="../plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script> <script src="../plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script> <script src="../plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script><!-- Custom Js --> <script src="../js/admin.js"></script> <script src="../js/pages/tables/jquery-datatable.js"></script> <!-- Demo Js --> <script src="../js/demo.js"></script> 
    <?php } ?> 
    
</body>

</html>
