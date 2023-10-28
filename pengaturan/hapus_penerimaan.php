<?php
include '../base/koneksi.php';

mysqli_query($l, "DELETE FROM ket_penerimaan WHERE ket_penerimaan='".$_GET['ket_penerimaan']."'") OR die(mysql_error($l));

?>
