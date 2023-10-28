<!-- <script src="plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
swal("Berhasil Menambahkan Kegiatan !", {
  icon: "success", button:false, timer: 1100,})
.then((value) => {
  document.location="./";
});</script> -->

<?php
if (isset($_POST['updateprofile'])) {
	if (isset($_POST['namabaru'])) {
    	$upnama=mysqli_query($l, "UPDATE admin SET nama_admin='".$_POST['namabaru']."', username_admin='".$_POST['usernamebaru']."' WHERE id_admin=1");
	}
	if (empty($_POST['passlama']) && empty($_POST['passbaru']) && empty($_POST['repassbaru'])) {

	}else{
		$statcon = mysqli_query($l, "SELECT * FROM admin WHERE id_admin=1");
		$datacon = mysqli_fetch_array($statcon);
		$passlama = md5($_POST['passlama']);
		if ($datacon['pass_admin'] = $passlama) {
			if ($_POST['passbaru'] = $_POST['repassbaru']) {
				$passbaru = md5($_POST['passbaru']);
    			$uppass=mysqli_query($l, "UPDATE admin SET pass_admin='".$passbaru."' WHERE id_admin=1");
			}else{echo '<script type="text/javascript">alert("Password Baru dan Password Ulang Tidak sama!");location.reload();</script>';}
		}else{echo '<script type="text/javascript">alert("Password Lama Salah!");location.reload();</script>';}
	}
    if ($upnama || $uppass) {
?>
        <script src="plugins/sweetalert/sweetalert.min.js"></script>
		<script type="text/javascript">
		swal("Berhasil!", {
		  icon: "success", button:false, timer: 1100,})
		.then((value) => {
		  document.location="?page=profile";
		});</script>
<?php
    }else{
?>
        <script type="text/javascript">
            alert("Reset Gagal, Ulangi Lagi!");
            location.reload();
        </script>
<?php
}
}
?>

<div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a href="?"><button class="btn btn-warning waves-effect"><i class="material-icons" style="font-size: 17px" title="Kembali ke Halaman Home">arrow_back</i> Kembali</button></a>
                
                    <div class="card">
                        <div class="header">
                            <h2>
                                Profile
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <!-- <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Catat Kerusakan</a></li>
                                    </ul>
                                </li> -->
                            </ul>
                        </div>
                        <div class="body"> 
                        <form method="post" class="form-edit" action="">
                        <div class="body">
                            <!--Profile-->
                            <?php
                            $stat=mysqli_query($l, "SELECT * FROM admin WHERE id_admin=1");
                            $data=mysqli_fetch_array($stat);
                            ?>
                            <div class="row clearfix js-sweetalert">
                                <div class="col-sm-8">
                                <h2 class="card-inside-title">Nama Oprator</h2>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="namabaru" value="<?php echo $data['nama_admin'] ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                <h2 class="card-inside-title">Username Oprator</h2>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="usernamebaru" value="<?php echo $data['username_admin'] ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                <h2 class="card-inside-title">Ganti Password Oprator</h2>
                                    <div class="form-group">
                                        <div class="form-line">
                                        <p>Password Lama</p>
                                            <input type="password" class="form-control" name="passlama" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                        <p>Password Baru</p>
                                            <input type="password" class="form-control" name="passbaru" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                        <p>Ulangi Password Baru</p>
                                            <input type="password" class="form-control" name="repassbaru" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                <h2 class="card-inside-title">Password / PIN Cadangan (Untuk Ganti Password Admin)</h2>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" value="12345678" readonly />
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <!--#END Profile-->
                            <div class="row clearfix js-sweetalert">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <button class="btn btn-primary waves-effect" type="submit" name="updateprofile">Update Profile</button>
                                </div>
                            </div>
                        </div>
                        </form>
                        
                        
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic -->
        </div>