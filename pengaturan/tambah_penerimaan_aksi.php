<?php
include '../base/koneksi.php';

mysqli_query($l, "INSERT INTO ket_penerimaan SET ket_penerimaan='".$_POST['ket_penerimaan']."'") OR die(mysql_error($l));

?>
<script src="../plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
swal("Berhasil Menambahkan Keterangan Penerimaan !", {
  icon: "success", button:false, timer: 1100,})
.then((value) => {
  document.location="./";
});</script>
