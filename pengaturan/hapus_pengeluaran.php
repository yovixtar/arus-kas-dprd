<?php
include '../base/koneksi.php';

mysqli_query($l, "DELETE FROM ket_pengeluaran WHERE ket_pengeluaran='".$_GET['ket_pengeluaran']."'") OR die(mysql_error($l));

?>
