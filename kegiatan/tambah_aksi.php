<?php
include '../base/koneksi.php';

mysqli_query($l, "INSERT INTO kegiatan SET nama_kegiatan='".$_POST['nama']."'") OR die(mysql_error($l));

?>
<script src="../plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
swal("Berhasil Menambahkan Kegiatan !", {
  icon: "success", button:false, timer: 1100,})
.then((value) => {
  document.location="./";
});</script>
