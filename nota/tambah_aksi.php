<?php
include '../base/koneksi.php';
$cekIdNota = mysqli_num_rows(mysqli_query($l,"SELECT * FROM nota WHERE id_nota =".$_POST['idnota']));
if ($cekIdNota > 0) {
?>
<script src="../plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
swal("ID / Nomor Nota sudah digunakan !", {
  icon: "warning", button:false, timer: 2400,})
.then((value) => {
  document.location="?page=tambahnota";
});</script>
<?php
}else{
	if (empty($_POST['tanggalnota']) || empty($_POST['jenis']) || empty($_POST['kegiatan']) || empty($_POST['inakumulasi']) ) {
	?>
	<script src="../plugins/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript">
	swal("Isi Form dengan Lengka (Tanggal Nota, Jenis Transaksi, Kegiatan / Uraian, dan Akumulasi Nota) !", {
	  icon: "warning", button:false, timer: 5000,})
	.then((value) => {
	  document.location="?page=tambahnota";
	});</script>
	<?php
	}else{
	$date = date('Y-m-d', strtotime($_POST['tanggalnota']));
    $stat_kegiatan = mysqli_query($l,"SELECT * FROM kegiatan WHERE nama_kegiatan = '".$_POST["kegiatan"]."'");
    $data_kegiatan = mysqli_fetch_array($stat_kegiatan);
    
    $stat_in = mysqli_query($l,"INSERT INTO nota SET id_nota=".$_POST['idnota'].", tanggal_nota='".$date."', jenis_nota='".$_POST['jenis']."', id_kegiatan=".$data_kegiatan['id_kegiatan'].", akumulasi_nota ='".$_POST['inakumulasi']."'");
    
    if ($stat_in) {
  
    $stat_update_kegiatan = mysqli_query($l,"UPDATE kegiatan SET akumulasi_kegiatan='".$_POST['inakumulasikegiatan']."' WHERE id_kegiatan=".$data_kegiatan['id_kegiatan']." ");
    
    //Pelunasan
  if ($_POST['countPelunasan'] != "") {
  $datePelunasan = date('Y-m-d', strtotime($_POST['tanggalPelunasan']));
  $countPelunasan = str_replace(".", "", $_POST['countPelunasan']);
      $stat_pelunasan = mysqli_query($l, "INSERT INTO penerimaan SET id_nota=".$_POST['idnota'].", count_penerimaan=".$countPelunasan.", tanggal_penerimaan='".$datePelunasan."', ket_penerimaan = 'Penerimaan - Pelunasan'");
      if ($stat_pelunasan) {
        $pilih_pelunasan = mysqli_query($l, "UPDATE nota SET pelunasan_nota=1 WHERE id_nota=".$_POST['idnota']);
        
        $pilih_pelunasan = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_nota=".$_POST['idnota']." AND count_penerimaan=".$countPelunasan." AND tanggal_penerimaan='".$datePelunasan."' AND ket_penerimaan = 'Penerimaan - Pelunasan'");
        $data_pilih_pelunasan = mysqli_fetch_array($pilih_pelunasan);
        $pilih_saldo_pelunasan = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 1");
        $data_saldo_pelunasan = mysqli_fetch_array($pilih_saldo_pelunasan);
        
        $next_count_pelunasan = $data_saldo_pelunasan['count_saldo'] + $data_pilih_pelunasan['count_penerimaan'];
        $next_id_pelunasan = $data_saldo_pelunasan['id_saldo'] + 1;
        
        $in_saldo_pelunasan = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_pelunasan.", count_saldo=".$next_count_pelunasan.", tanggal_saldo='".$data_pilih_pelunasan['tanggal_penerimaan']."', penerimaan_used=".$data_pilih_pelunasan['id_penerimaan']);
      }
    }
    
    //Peneriaan
	if ($_POST['countPenerimaan_1'] != "") {
	$datePenerimaan_1 = date('Y-m-d', strtotime($_POST['tanggalPenerimaan_1']));
	$countPenerimaan_1 = str_replace(".", "", $_POST['countPenerimaan_1']);
   		$stat_penerimaan_1 = mysqli_query($l, "INSERT INTO penerimaan SET id_nota=".$_POST['idnota'].", count_penerimaan=".$countPenerimaan_1.", tanggal_penerimaan='".$datePenerimaan_1."', ket_penerimaan = '".$_POST['ketPenerimaan_1']."'");
   		if ($stat_penerimaan_1) {
   			$pilih_penerimaan_1 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_nota=".$_POST['idnota']." AND count_penerimaan=".$countPenerimaan_1." AND tanggal_penerimaan='".$datePenerimaan_1."' AND ket_penerimaan = '".$_POST['ketPenerimaan_1']."'");
   			$data_pilih_penerimaan_1 = mysqli_fetch_array($pilih_penerimaan_1);
   			$pilih_saldo_penerimaan_1 = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 1");
   			$data_saldo_penerimaan_1 = mysqli_fetch_array($pilih_saldo_penerimaan_1);
   			
   			$next_count_penerimaan_1 = $data_saldo_penerimaan_1['count_saldo'] + $data_pilih_penerimaan_1['count_penerimaan'];
        $next_id_penerimaan_1 = $data_saldo_penerimaan_1['id_saldo'] + 1;
   			
   			$in_saldo_1 = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_penerimaan_1.", count_saldo=".$next_count_penerimaan_1.", tanggal_saldo='".$data_pilih_penerimaan_1['tanggal_penerimaan']."', penerimaan_used=".$data_pilih_penerimaan_1['id_penerimaan']);
   		}
    }
    if ($_POST['countPenerimaan_2'] != "") {
	$datePenerimaan_2 = date('Y-m-d', strtotime($_POST['tanggalPenerimaan_2']));
	$countPenerimaan_2 = str_replace(".", "", $_POST['countPenerimaan_2']);
   		$stat_penerimaan_2 = mysqli_query($l, "INSERT INTO penerimaan SET id_nota=".$_POST['idnota'].", count_penerimaan=".$countPenerimaan_2.", tanggal_penerimaan='".$datePenerimaan_2."', ket_penerimaan = '".$_POST['ketPenerimaan_2']."'");
   		if ($stat_penerimaan_2) {
   			$pilih_penerimaan_2 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_nota=".$_POST['idnota']." AND count_penerimaan=".$countPenerimaan_2." AND tanggal_penerimaan='".$datePenerimaan_2."' AND ket_penerimaan = '".$_POST['ketPenerimaan_2']."'");
   			$data_pilih_penerimaan_2 = mysqli_fetch_array($pilih_penerimaan_2);
   			$pilih_saldo_penerimaan_2 = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 1");
   			$data_saldo_penerimaan_2 = mysqli_fetch_array($pilih_saldo_penerimaan_2);
   			
   			$next_count_penerimaan_2 = $data_saldo_penerimaan_2['count_saldo'] + $data_pilih_penerimaan_2['count_penerimaan'];
   			$next_id_penerimaan_2 = $data_saldo_penerimaan_2['id_saldo'] + 1;
        
        $in_saldo_2 = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_penerimaan_2.", count_saldo=".$next_count_penerimaan_2.", tanggal_saldo='".$data_pilih_penerimaan_2['tanggal_penerimaan']."', penerimaan_used=".$data_pilih_penerimaan_2['id_penerimaan']);
   		}
    }
    if ($_POST['countPenerimaan_3'] != "") {
	$datePenerimaan_3 = date('Y-m-d', strtotime($_POST['tanggalPenerimaan_3']));
	$countPenerimaan_3 = str_replace(".", "", $_POST['countPenerimaan_3']);
   		$stat_penerimaan_3 = mysqli_query($l, "INSERT INTO penerimaan SET id_nota=".$_POST['idnota'].", count_penerimaan=".$countPenerimaan_3.", tanggal_penerimaan='".$datePenerimaan_3."', ket_penerimaan = '".$_POST['ketPenerimaan_3']."'");
   		if ($stat_penerimaan_3) {
   			$pilih_penerimaan_3 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_nota=".$_POST['idnota']." AND count_penerimaan=".$countPenerimaan_3." AND tanggal_penerimaan='".$datePenerimaan_3."' AND ket_penerimaan = '".$_POST['ketPenerimaan_3']."'");
   			$data_pilih_penerimaan_3 = mysqli_fetch_array($pilih_penerimaan_3);
   			$pilih_saldo_penerimaan_3 = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 1");
   			$data_saldo_penerimaan_3 = mysqli_fetch_array($pilih_saldo_penerimaan_3);
   			
   			$next_count_penerimaan_3 = $data_saldo_penerimaan_3['count_saldo'] + $data_pilih_penerimaan_3['count_penerimaan'];
   			$next_id_penerimaan_3 = $data_saldo_penerimaan_3['id_saldo'] + 1;
        
        $in_saldo_3 = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_penerimaan_3.", count_saldo=".$next_count_penerimaan_3.", tanggal_saldo='".$data_pilih_penerimaan_3['tanggal_penerimaan']."', penerimaan_used=".$data_pilih_penerimaan_3['id_penerimaan']);
   		}
    }
    if ($_POST['countPenerimaan_4'] != "") {
	$datePenerimaan_4 = date('Y-m-d', strtotime($_POST['tanggalPenerimaan_4']));
	$countPenerimaan_4 = str_replace(".", "", $_POST['countPenerimaan_4']);
   		$stat_penerimaan_4 = mysqli_query($l, "INSERT INTO penerimaan SET id_nota=".$_POST['idnota'].", count_penerimaan=".$countPenerimaan_4.", tanggal_penerimaan='".$datePenerimaan_4."', ket_penerimaan = '".$_POST['ketPenerimaan_4']."'");
   		if ($stat_penerimaan_4) {
   			$pilih_penerimaan_4 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_nota=".$_POST['idnota']." AND count_penerimaan=".$countPenerimaan_4." AND tanggal_penerimaan='".$datePenerimaan_4."' AND ket_penerimaan = '".$_POST['ketPenerimaan_4']."'");
   			$data_pilih_penerimaan_4 = mysqli_fetch_array($pilih_penerimaan_4);
   			$pilih_saldo_penerimaan_4 = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 1");
   			$data_saldo_penerimaan_4 = mysqli_fetch_array($pilih_saldo_penerimaan_4);
   			
   			$next_count_penerimaan_4 = $data_saldo_penerimaan_4['count_saldo'] + $data_pilih_penerimaan_4['count_penerimaan'];
   			$next_id_penerimaan_4 = $data_saldo_penerimaan_4['id_saldo'] + 1;
        
        $in_saldo_4 = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_penerimaan_4.", count_saldo=".$next_count_penerimaan_4.", tanggal_saldo='".$data_pilih_penerimaan_4['tanggal_penerimaan']."', penerimaan_used=".$data_pilih_penerimaan_4['id_penerimaan']);
   		}
    }
    
    //Pengeluaran
    if ($_POST['countPengeluaran_1'] != "") {
	$datePengeluaran_1 = date('Y-m-d', strtotime($_POST['tanggalPengeluaran_1']));
	$countPengeluaran_1 = str_replace(".", "", $_POST['countPengeluaran_1']);
   		$stat_pengeluaran_1 = mysqli_query($l, "INSERT INTO pengeluaran SET id_nota=".$_POST['idnota'].", count_pengeluaran=".$countPengeluaran_1.", tanggal_pengeluaran='".$datePengeluaran_1."', ket_pengeluaran = '".$_POST['ketPengeluaran_1']."'");
   		if ($stat_pengeluaran_1) {
   			$pilih_pengeluaran_1 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_nota=".$_POST['idnota']." AND count_pengeluaran=".$countPengeluaran_1." AND tanggal_pengeluaran='".$datePengeluaran_1."' AND ket_pengeluaran = '".$_POST['ketPengeluaran_1']."'");
   			$data_pilih_pengeluaran_1 = mysqli_fetch_array($pilih_pengeluaran_1);
   			$pilih_saldo_pengeluaran_1 = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 1");
   			$data_saldo_pengeluaran_1 = mysqli_fetch_array($pilih_saldo_pengeluaran_1);
   			
   			$next_count_pengeluaran_1 = $data_saldo_pengeluaran_1['count_saldo'] - $data_pilih_pengeluaran_1['count_pengeluaran'];
        $next_id_pengeluaran_1 = $data_saldo_pengeluaran_1['id_saldo'] + 1;
   			
   			$in_saldo_1 = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_pengeluaran_1.", count_saldo=".$next_count_pengeluaran_1.", tanggal_saldo='".$data_pilih_pengeluaran_1['tanggal_pengeluaran']."', pengeluaran_used=".$data_pilih_pengeluaran_1['id_pengeluaran']);
   		}
    }
    if ($_POST['countPengeluaran_2'] != "") {
  $datePengeluaran_2 = date('Y-m-d', strtotime($_POST['tanggalPengeluaran_2']));
  $countPengeluaran_2 = str_replace(".", "", $_POST['countPengeluaran_2']);
      $stat_pengeluaran_2 = mysqli_query($l, "INSERT INTO pengeluaran SET id_nota=".$_POST['idnota'].", count_pengeluaran=".$countPengeluaran_2.", tanggal_pengeluaran='".$datePengeluaran_2."', ket_pengeluaran = '".$_POST['ketPengeluaran_2']."'");
      if ($stat_pengeluaran_2) {
        $pilih_pengeluaran_2 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_nota=".$_POST['idnota']." AND count_pengeluaran=".$countPengeluaran_2." AND tanggal_pengeluaran='".$datePengeluaran_2."' AND ket_pengeluaran = '".$_POST['ketPengeluaran_2']."'");
        $data_pilih_pengeluaran_2 = mysqli_fetch_array($pilih_pengeluaran_2);
        $pilih_saldo_pengeluaran_2 = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 2");
        $data_saldo_pengeluaran_2 = mysqli_fetch_array($pilih_saldo_pengeluaran_2);
        
        $next_count_pengeluaran_2 = $data_saldo_pengeluaran_2['count_saldo'] - $data_pilih_pengeluaran_2['count_pengeluaran'];
        $next_id_pengeluaran_2 = $data_saldo_pengeluaran_2['id_saldo'] + 2;
        
        $in_saldo_2 = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_pengeluaran_2.", count_saldo=".$next_count_pengeluaran_2.", tanggal_saldo='".$data_pilih_pengeluaran_2['tanggal_pengeluaran']."', pengeluaran_used=".$data_pilih_pengeluaran_2['id_pengeluaran']);
      }
    }
    if ($_POST['countPengeluaran_3'] != "") {
  $datePengeluaran_3 = date('Y-m-d', strtotime($_POST['tanggalPengeluaran_3']));
  $countPengeluaran_3 = str_replace(".", "", $_POST['countPengeluaran_3']);
      $stat_pengeluaran_3 = mysqli_query($l, "INSERT INTO pengeluaran SET id_nota=".$_POST['idnota'].", count_pengeluaran=".$countPengeluaran_3.", tanggal_pengeluaran='".$datePengeluaran_3."', ket_pengeluaran = '".$_POST['ketPengeluaran_3']."'");
      if ($stat_pengeluaran_3) {
        $pilih_pengeluaran_3 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_nota=".$_POST['idnota']." AND count_pengeluaran=".$countPengeluaran_3." AND tanggal_pengeluaran='".$datePengeluaran_3."' AND ket_pengeluaran = '".$_POST['ketPengeluaran_3']."'");
        $data_pilih_pengeluaran_3 = mysqli_fetch_array($pilih_pengeluaran_3);
        $pilih_saldo_pengeluaran_3 = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 3");
        $data_saldo_pengeluaran_3 = mysqli_fetch_array($pilih_saldo_pengeluaran_3);
        
        $next_count_pengeluaran_3 = $data_saldo_pengeluaran_3['count_saldo'] - $data_pilih_pengeluaran_3['count_pengeluaran'];
        $next_id_pengeluaran_3 = $data_saldo_pengeluaran_3['id_saldo'] + 3;
        
        $in_saldo_3 = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_pengeluaran_3.", count_saldo=".$next_count_pengeluaran_3.", tanggal_saldo='".$data_pilih_pengeluaran_3['tanggal_pengeluaran']."', pengeluaran_used=".$data_pilih_pengeluaran_3['id_pengeluaran']);
      }
    }
    if ($_POST['countPengeluaran_4'] != "") {
  $datePengeluaran_4 = date('Y-m-d', strtotime($_POST['tanggalPengeluaran_4']));
  $countPengeluaran_4 = str_replace(".", "", $_POST['countPengeluaran_4']);
      $stat_pengeluaran_4 = mysqli_query($l, "INSERT INTO pengeluaran SET id_nota=".$_POST['idnota'].", count_pengeluaran=".$countPengeluaran_4.", tanggal_pengeluaran='".$datePengeluaran_4."', ket_pengeluaran = '".$_POST['ketPengeluaran_4']."'");
      if ($stat_pengeluaran_4) {
        $pilih_pengeluaran_4 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_nota=".$_POST['idnota']." AND count_pengeluaran=".$countPengeluaran_4." AND tanggal_pengeluaran='".$datePengeluaran_4."' AND ket_pengeluaran = '".$_POST['ketPengeluaran_4']."'");
        $data_pilih_pengeluaran_4 = mysqli_fetch_array($pilih_pengeluaran_4);
        $pilih_saldo_pengeluaran_4 = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 4");
        $data_saldo_pengeluaran_4 = mysqli_fetch_array($pilih_saldo_pengeluaran_4);
        
        $next_count_pengeluaran_4 = $data_saldo_pengeluaran_4['count_saldo'] - $data_pilih_pengeluaran_4['count_pengeluaran'];
        $next_id_pengeluaran_4 = $data_saldo_pengeluaran_4['id_saldo'] + 4;
        
        $in_saldo_4 = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_pengeluaran_4.", count_saldo=".$next_count_pengeluaran_4.", tanggal_saldo='".$data_pilih_pengeluaran_4['tanggal_pengeluaran']."', pengeluaran_used=".$data_pilih_pengeluaran_4['id_pengeluaran']);
      }
    }
    
    ?>
<script src="../plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
swal("Berhasil menambahkan Nota !", {
  icon: "success", button:false, timer: 2400,})
.then((value) => {
  document.location="?page=nota";
});</script>
    <?php
		
	}
	}
}
?>
