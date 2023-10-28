<?php
include '../base/koneksi.php';
$stat = mysqli_query($l, "SELECT akumulasi_kegiatan FROM kegiatan WHERE id_kegiatan=".$_GET['idx']);
$data = mysqli_fetch_array($stat);
if ($data['akumulasi_kegiatan'] > 0) {
	
}else{
mysqli_query($l, "DELETE FROM kegiatan WHERE id_kegiatan=".$_GET['idx']) OR die(mysql_error($l));
}
?>
