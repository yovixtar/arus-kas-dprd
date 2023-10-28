<?php
include '../base/koneksi.php';

mysqli_query($l, "INSERT INTO ket_pengeluaran SET ket_pengeluaran='".$_POST['ket_pengeluaran']."'") OR die(mysql_error($l));

?>
<script src="../plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
swal("Berhasil Menambahkan Keterangan Pengeluaran !", {
  icon: "success", button:false, timer: 1100,})
.then((value) => {
  document.location="./";
});</script>
