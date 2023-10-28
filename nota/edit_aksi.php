<?php
include '../base/koneksi.php';
if ($_POST['idnotanew'] != $_POST['idnotaold']) {
$cekIdNota = mysqli_num_rows(mysqli_query($l,"SELECT * FROM nota WHERE id_nota =".$_POST['idnotanew']));
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
	swal("Isi Form dengan Lengkap (Tanggal Nota, Jenis Transaksi, Kegiatan / Uraian, dan Akumulasi Nota) !", {
	  icon: "warning", button:false, timer: 5000,})
	.then((value) => {
	  document.location="?page=editnota&idx=<?php echo $_POST['idnotaold'] ?>";
	});</script>
	<?php
	}else{
	$date = date('Y-m-d', strtotime($_POST['tanggalnota']));
    $stat_kegiatan = mysqli_query($l,"SELECT * FROM kegiatan WHERE nama_kegiatan = '".$_POST["kegiatan"]."'");
    $data_kegiatan = mysqli_fetch_array($stat_kegiatan);
    
    $stat_in = mysqli_query($l,"UPDATE nota SET id_nota=".$_POST['idnotanew'].", tanggal_nota='".$date."', jenis_nota='".$_POST['jenis']."', id_kegiatan=".$data_kegiatan['id_kegiatan'].", akumulasi_nota ='".$_POST['inakumulasi']."' WHERE id_nota=".$_POST['idnotaold']);
    $stat_update_kegiatan = mysqli_query($l,"UPDATE kegiatan SET akumulasi_kegiatan='".$_POST['inakumulasikegiatan']."' WHERE id_kegiatan=".$data_kegiatan['id_kegiatan']." ");

	}
}

//NEW IDNota Count
    //Pelunasan
    if ($_POST['countPelunasan'] != "") {
    $datePelunasan = date('Y-m-d', strtotime($_POST['tanggalPelunasan']));
    $countPelunasan = str_replace(".", "", $_POST['countPelunasan']);
      $stat_pelunasan = mysqli_query($l, "INSERT INTO penerimaan SET id_nota=".$_POST['idnotanew'].", count_penerimaan=".$countPelunasan.", tanggal_penerimaan='".$datePelunasan."', ket_penerimaan = 'Penerimaan - Pelunasan'");
      if ($stat_pelunasan) {
        $pilih_pelunasan = mysqli_query($l, "UPDATE nota SET pelunasan_nota=1 WHERE id_nota=".$_POST['idnotanew']);
        
        $pilih_pelunasan = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_nota=".$_POST['idnotanew']." AND count_penerimaan=".$countPelunasan." AND tanggal_penerimaan='".$datePelunasan."' AND ket_penerimaan = 'Penerimaan - Pelunasan'");
        $data_pilih_pelunasan = mysqli_fetch_array($pilih_pelunasan);
        $pilih_saldo_pelunasan = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 1");
        $data_saldo_pelunasan = mysqli_fetch_array($pilih_saldo_pelunasan);
        
        $next_count_pelunasan = $data_saldo_pelunasan['count_saldo'] + $data_pilih_pelunasan['count_penerimaan'];
        $next_id_pelunasan = $data_saldo_pelunasan['id_saldo'] + 1;
        
        $in_saldo_pelunasan = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_pelunasan.", count_saldo=".$next_count_pelunasan.", tanggal_saldo='".$data_pilih_pelunasan['tanggal_penerimaan']."', penerimaan_used=".$data_pilih_pelunasan['id_penerimaan']);
      }
    }
    //Peneriaan
    if (isset($_POST['editCountPenerimaan_1'])) {
      $statPilihEditPenerimaan_1 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_penerimaan=".$_POST['editIdPenerimaan_1']);
      $dataPilihEditPenerimaan_1 = mysqli_fetch_array($statPilihEditPenerimaan_1);
      $dateEditPenerimaan_1 =date('Y-m-d', strtotime($_POST['editTanggalPenerimaan_1']));
    $countEditPenerimaan_1 = str_replace(".", "", $_POST['editCountPenerimaan_1']);
      if ($countEditPenerimaan_1 != $dataPilihEditPenerimaan_1['count_penerimaan']) {
        $selisihCountEditPenerimaan_1 = $dataPilihEditPenerimaan_1['count_penerimaan'] - $countEditPenerimaan_1;
        $statSaldoEditPenerimaan_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPenerimaan_all = mysqli_fetch_array($statSaldoEditPenerimaan_all);
        $statSaldoEditPenerimaan_1 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE penerimaan_used=".$_POST['editIdPenerimaan_1']);
        $dataSaldoEditPenerimaan_1 = mysqli_fetch_array($statSaldoEditPenerimaan_1);
        
            for ($x = $dataSaldoEditPenerimaan_1['id_saldo'] ; $x <= $dataSaldoEditPenerimaan_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] - $selisihCountEditPenerimaan_1;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPenerimaanEdit_1 = mysqli_query($l, "UPDATE penerimaan SET count_penerimaan='".$countEditPenerimaan_1."', tanggal_penerimaan='".$dateEditPenerimaan_1."', ket_penerimaan='".$_POST['editKetPenerimaan_1']."', id_nota=".$_POST['idnotanew']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_1']);
              
      }else{
            $fixPenerimaanEdit_1 = mysqli_query($l, "UPDATE penerimaan SET tanggal_penerimaan='".$dateEditPenerimaan_1."', ket_penerimaan='".$_POST['editKetPenerimaan_1']."', id_nota=".$_POST['idnotanew']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_1']);
      }
    }
    if (isset($_POST['editCountPenerimaan_2'])) {
      $statPilihEditPenerimaan_2 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_penerimaan=".$_POST['editIdPenerimaan_2']);
      $dataPilihEditPenerimaan_2 = mysqli_fetch_array($statPilihEditPenerimaan_2);
      $dateEditPenerimaan_2 =date('Y-m-d', strtotime($_POST['editTanggalPenerimaan_2']));
      $countEditPenerimaan_2 = str_replace(".", "", $_POST['editCountPenerimaan_2']);
      if ($countEditPenerimaan_2 != $dataPilihEditPenerimaan_2['count_penerimaan']) {
        $selisihCountEditPenerimaan_2 = $dataPilihEditPenerimaan_2['count_penerimaan'] - $countEditPenerimaan_2;
        $statSaldoEditPenerimaan_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPenerimaan_all = mysqli_fetch_array($statSaldoEditPenerimaan_all);
        $statSaldoEditPenerimaan_2 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE penerimaan_used=".$_POST['editIdPenerimaan_2']);
        $dataSaldoEditPenerimaan_2 = mysqli_fetch_array($statSaldoEditPenerimaan_2);
        
            for ($x = $dataSaldoEditPenerimaan_2['id_saldo'] ; $x <= $dataSaldoEditPenerimaan_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] - $selisihCountEditPenerimaan_2;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPenerimaanEdit_2 = mysqli_query($l, "UPDATE penerimaan SET count_penerimaan='".$countEditPenerimaan_2."', tanggal_penerimaan='".$dateEditPenerimaan_2."', ket_penerimaan='".$_POST['editKetPenerimaan_2']."', id_nota=".$_POST['idnotanew']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_2']);
              
      }else{
            $fixPenerimaanEdit_2 = mysqli_query($l, "UPDATE penerimaan SET tanggal_penerimaan='".$dateEditPenerimaan_2."', ket_penerimaan='".$_POST['editKetPenerimaan_2']."', id_nota=".$_POST['idnotanew']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_2']);
      }
    }
    if (isset($_POST['editCountPenerimaan_3'])) {
      $statPilihEditPenerimaan_3 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_penerimaan=".$_POST['editIdPenerimaan_3']);
      $dataPilihEditPenerimaan_3 = mysqli_fetch_array($statPilihEditPenerimaan_3);
      $dateEditPenerimaan_3 =date('Y-m-d', strtotime($_POST['editTanggalPenerimaan_3']));
    $countEditPenerimaan_3 = str_replace(".", "", $_POST['editCountPenerimaan_3']);
      if ($countEditPenerimaan_3 != $dataPilihEditPenerimaan_3['count_penerimaan']) {
        $selisihCountEditPenerimaan_3 = $dataPilihEditPenerimaan_3['count_penerimaan'] - $countEditPenerimaan_3;
        $statSaldoEditPenerimaan_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPenerimaan_all = mysqli_fetch_array($statSaldoEditPenerimaan_all);
        $statSaldoEditPenerimaan_3 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE penerimaan_used=".$_POST['editIdPenerimaan_3']);
        $dataSaldoEditPenerimaan_3 = mysqli_fetch_array($statSaldoEditPenerimaan_3);
        
            for ($x = $dataSaldoEditPenerimaan_3['id_saldo'] ; $x <= $dataSaldoEditPenerimaan_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] - $selisihCountEditPenerimaan_3;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPenerimaanEdit_3 = mysqli_query($l, "UPDATE penerimaan SET count_penerimaan='".$countEditPenerimaan_3."', tanggal_penerimaan='".$dateEditPenerimaan_3."', ket_penerimaan='".$_POST['editKetPenerimaan_3']."', id_nota=".$_POST['idnotanew']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_3']);
              
      }else{
            $fixPenerimaanEdit_3 = mysqli_query($l, "UPDATE penerimaan SET tanggal_penerimaan='".$dateEditPenerimaan_3."', ket_penerimaan='".$_POST['editKetPenerimaan_3']."', id_nota=".$_POST['idnotanew']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_3']);
      }
    }
    if (isset($_POST['editCountPenerimaan_4'])) {
      $statPilihEditPenerimaan_4 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_penerimaan=".$_POST['editIdPenerimaan_4']);
      $dataPilihEditPenerimaan_4 = mysqli_fetch_array($statPilihEditPenerimaan_4);
      $dateEditPenerimaan_4 =date('Y-m-d', strtotime($_POST['editTanggalPenerimaan_4']));
    $countEditPenerimaan_4 = str_replace(".", "", $_POST['editCountPenerimaan_4']);
      if ($countEditPenerimaan_4 != $dataPilihEditPenerimaan_4['count_penerimaan']) {
        $selisihCountEditPenerimaan_4 = $dataPilihEditPenerimaan_4['count_penerimaan'] - $countEditPenerimaan_4;
        $statSaldoEditPenerimaan_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPenerimaan_all = mysqli_fetch_array($statSaldoEditPenerimaan_all);
        $statSaldoEditPenerimaan_4 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE penerimaan_used=".$_POST['editIdPenerimaan_4']);
        $dataSaldoEditPenerimaan_4 = mysqli_fetch_array($statSaldoEditPenerimaan_4);
        
            for ($x = $dataSaldoEditPenerimaan_4['id_saldo'] ; $x <= $dataSaldoEditPenerimaan_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] - $selisihCountEditPenerimaan_4;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPenerimaanEdit_4 = mysqli_query($l, "UPDATE penerimaan SET count_penerimaan='".$countEditPenerimaan_4."', tanggal_penerimaan='".$dateEditPenerimaan_4."', ket_penerimaan='".$_POST['editKetPenerimaan_4']."', id_nota=".$_POST['idnotanew']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_4']);
              
      }else{
            $fixPenerimaanEdit_4 = mysqli_query($l, "UPDATE penerimaan SET tanggal_penerimaan='".$dateEditPenerimaan_4."', ket_penerimaan='".$_POST['editKetPenerimaan_4']."', id_nota=".$_POST['idnotanew']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_4']);
      }
    }
    if (isset($_POST['editCountPenerimaan_5'])) {
      $statPilihEditPenerimaan_5 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_penerimaan=".$_POST['editIdPenerimaan_5']);
      $dataPilihEditPenerimaan_5 = mysqli_fetch_array($statPilihEditPenerimaan_5);
      $dateEditPenerimaan_5 =date('Y-m-d', strtotime($_POST['editTanggalPenerimaan_5']));
    $countEditPenerimaan_5 = str_replace(".", "", $_POST['editCountPenerimaan_5']);
      if ($countEditPenerimaan_5 != $dataPilihEditPenerimaan_5['count_penerimaan']) {
        $selisihCountEditPenerimaan_5 = $dataPilihEditPenerimaan_5['count_penerimaan'] - $countEditPenerimaan_5;
        $statSaldoEditPenerimaan_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPenerimaan_all = mysqli_fetch_array($statSaldoEditPenerimaan_all);
        $statSaldoEditPenerimaan_5 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE penerimaan_used=".$_POST['editIdPenerimaan_5']);
        $dataSaldoEditPenerimaan_5 = mysqli_fetch_array($statSaldoEditPenerimaan_5);
        
            for ($x = $dataSaldoEditPenerimaan_5['id_saldo'] ; $x <= $dataSaldoEditPenerimaan_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] - $selisihCountEditPenerimaan_5;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPenerimaanEdit_5 = mysqli_query($l, "UPDATE penerimaan SET count_penerimaan='".$countEditPenerimaan_5."', tanggal_penerimaan='".$dateEditPenerimaan_5."', ket_penerimaan='".$_POST['editKetPenerimaan_5']."', id_nota=".$_POST['idnotanew']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_5']);
              
      }else{
            $fixPenerimaanEdit_5 = mysqli_query($l, "UPDATE penerimaan SET tanggal_penerimaan='".$dateEditPenerimaan_5."', ket_penerimaan='".$_POST['editKetPenerimaan_5']."', id_nota=".$_POST['idnotanew']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_5']);
      }
    }
    
    
	if ($_POST['countPenerimaan_1'] != "") {
	$datePenerimaan_1 = date('Y-m-d', strtotime($_POST['tanggalPenerimaan_1']));
	$countPenerimaan_1 = str_replace(".", "", $_POST['countPenerimaan_1']);
   		$stat_penerimaan_1 = mysqli_query($l, "INSERT INTO penerimaan SET id_nota=".$_POST['idnotanew'].", count_penerimaan=".$countPenerimaan_1.", tanggal_penerimaan='".$datePenerimaan_1."', ket_penerimaan = '".$_POST['ketPenerimaan_1']."'");
   		if ($stat_penerimaan_1) {
   			$pilih_penerimaan_1 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_nota=".$_POST['idnotanew']." AND count_penerimaan=".$countPenerimaan_1." AND tanggal_penerimaan='".$datePenerimaan_1."' AND ket_penerimaan = '".$_POST['ketPenerimaan_1']."'");
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
   		$stat_penerimaan_2 = mysqli_query($l, "INSERT INTO penerimaan SET id_nota=".$_POST['idnotanew'].", count_penerimaan=".$countPenerimaan_2.", tanggal_penerimaan='".$datePenerimaan_2."', ket_penerimaan = '".$_POST['ketPenerimaan_2']."'");
   		if ($stat_penerimaan_2) {
   			$pilih_penerimaan_2 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_nota=".$_POST['idnotanew']." AND count_penerimaan=".$countPenerimaan_2." AND tanggal_penerimaan='".$datePenerimaan_2."' AND ket_penerimaan = '".$_POST['ketPenerimaan_2']."'");
   			$data_pilih_penerimaan_2 = mysqli_fetch_array($pilih_penerimaan_2);
   			$pilih_saldo_penerimaan_2 = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 1");
   			$data_saldo_penerimaan_2 = mysqli_fetch_array($pilih_saldo_penerimaan_2);
   			
   			$next_count_penerimaan_2 = $data_saldo_penerimaan_2['count_saldo'] + $data_pilih_penerimaan_2['count_penerimaan'];
        	$next_id_penerimaan_2 = $data_saldo_penerimaan_2['id_saldo'] + 1;
   			
   			$in_saldo_2 = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_penerimaan_2.", count_saldo=".$next_count_penerimaan_2.", tanggal_saldo='".$data_pilih_penerimaan_2['tanggal_penerimaan']."', penerimaan_used=".$data_pilih_penerimaan_2['id_penerimaan']);
   		}
    }
    
    //Pengeluaran
    if (isset($_POST['editCountPengeluaran_1'])) {
      $statPilihEditPengeluaran_1 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_pengeluaran=".$_POST['editIdPengeluaran_1']);
      $dataPilihEditPengeluaran_1 = mysqli_fetch_array($statPilihEditPengeluaran_1);
      $dateEditPengeluaran_1 =date('Y-m-d', strtotime($_POST['editTanggalPengeluaran_1']));
    $countEditPengeluaran_1 = str_replace(".", "", $_POST['editCountPengeluaran_1']);
      if ($countEditPengeluaran_1 != $dataPilihEditPengeluaran_1['count_pengeluaran']) {
        $selisihCountEditPengeluaran_1 = $dataPilihEditPengeluaran_1['count_pengeluaran'] - $countEditPengeluaran_1;
        $statSaldoEditPengeluaran_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPengeluaran_all = mysqli_fetch_array($statSaldoEditPengeluaran_all);
        $statSaldoEditPengeluaran_1 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE pengeluaran_used=".$_POST['editIdPengeluaran_1']);
        $dataSaldoEditPengeluaran_1 = mysqli_fetch_array($statSaldoEditPengeluaran_1);
        
            for ($x = $dataSaldoEditPengeluaran_1['id_saldo'] ; $x <= $dataSaldoEditPengeluaran_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] + $selisihCountEditPengeluaran_1;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPengeluaranEdit_1 = mysqli_query($l, "UPDATE pengeluaran SET count_pengeluaran='".$countEditPengeluaran_1."', tanggal_pengeluaran='".$dateEditPengeluaran_1."', ket_pengeluaran='".$_POST['editKetPengeluaran_1']."', id_nota=".$_POST['idnotanew']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_1']);
              
      }else{
            $fixPengeluaranEdit_1 = mysqli_query($l, "UPDATE pengeluaran SET tanggal_pengeluaran='".$dateEditPengeluaran_1."', ket_pengeluaran='".$_POST['editKetPengeluaran_1']."', id_nota=".$_POST['idnotanew']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_1']);
      }
    }
    if (isset($_POST['editCountPengeluaran_2'])) {
      $statPilihEditPengeluaran_2 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_pengeluaran=".$_POST['editIdPengeluaran_2']);
      $dataPilihEditPengeluaran_2 = mysqli_fetch_array($statPilihEditPengeluaran_2);
      $dateEditPengeluaran_2 =date('Y-m-d', strtotime($_POST['editTanggalPengeluaran_2']));
    $countEditPengeluaran_2 = str_replace(".", "", $_POST['editCountPengeluaran_2']);
      if ($countEditPengeluaran_2 != $dataPilihEditPengeluaran_2['count_pengeluaran']) {
        $selisihCountEditPengeluaran_2 = $dataPilihEditPengeluaran_2['count_pengeluaran'] - $countEditPengeluaran_2;
        $statSaldoEditPengeluaran_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPengeluaran_all = mysqli_fetch_array($statSaldoEditPengeluaran_all);
        $statSaldoEditPengeluaran_2 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE pengeluaran_used=".$_POST['editIdPengeluaran_2']);
        $dataSaldoEditPengeluaran_2 = mysqli_fetch_array($statSaldoEditPengeluaran_2);
        
            for ($x = $dataSaldoEditPengeluaran_2['id_saldo'] ; $x <= $dataSaldoEditPengeluaran_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] + $selisihCountEditPengeluaran_2;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPengeluaranEdit_2 = mysqli_query($l, "UPDATE pengeluaran SET count_pengeluaran='".$countEditPengeluaran_2."', tanggal_pengeluaran='".$dateEditPengeluaran_2."', ket_pengeluaran='".$_POST['editKetPengeluaran_2']."', id_nota=".$_POST['idnotanew']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_2']);
              
      }else{
            $fixPengeluaranEdit_2 = mysqli_query($l, "UPDATE pengeluaran SET tanggal_pengeluaran='".$dateEditPengeluaran_2."', ket_pengeluaran='".$_POST['editKetPengeluaran_2']."', id_nota=".$_POST['idnotanew']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_2']);
      }
    }
    if (isset($_POST['editCountPengeluaran_3'])) {
      $statPilihEditPengeluaran_3 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_pengeluaran=".$_POST['editIdPengeluaran_3']);
      $dataPilihEditPengeluaran_3 = mysqli_fetch_array($statPilihEditPengeluaran_3);
      $dateEditPengeluaran_3 =date('Y-m-d', strtotime($_POST['editTanggalPengeluaran_3']));
    $countEditPengeluaran_3 = str_replace(".", "", $_POST['editCountPengeluaran_3']);
      if ($countEditPengeluaran_3 != $dataPilihEditPengeluaran_3['count_pengeluaran']) {
        $selisihCountEditPengeluaran_3 = $dataPilihEditPengeluaran_3['count_pengeluaran'] - $countEditPengeluaran_3;
        $statSaldoEditPengeluaran_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPengeluaran_all = mysqli_fetch_array($statSaldoEditPengeluaran_all);
        $statSaldoEditPengeluaran_3 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE pengeluaran_used=".$_POST['editIdPengeluaran_3']);
        $dataSaldoEditPengeluaran_3 = mysqli_fetch_array($statSaldoEditPengeluaran_3);
        
            for ($x = $dataSaldoEditPengeluaran_3['id_saldo'] ; $x <= $dataSaldoEditPengeluaran_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] + $selisihCountEditPengeluaran_3;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPengeluaranEdit_3 = mysqli_query($l, "UPDATE pengeluaran SET count_pengeluaran='".$countEditPengeluaran_3."', tanggal_pengeluaran='".$dateEditPengeluaran_3."', ket_pengeluaran='".$_POST['editKetPengeluaran_3']."', id_nota=".$_POST['idnotanew']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_3']);
              
      }else{
            $fixPengeluaranEdit_3 = mysqli_query($l, "UPDATE pengeluaran SET tanggal_pengeluaran='".$dateEditPengeluaran_3."', ket_pengeluaran='".$_POST['editKetPengeluaran_3']."', id_nota=".$_POST['idnotanew']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_3']);
      }
    }
    if (isset($_POST['editCountPengeluaran_4'])) {
      $statPilihEditPengeluaran_4 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_pengeluaran=".$_POST['editIdPengeluaran_4']);
      $dataPilihEditPengeluaran_4 = mysqli_fetch_array($statPilihEditPengeluaran_4);
      $dateEditPengeluaran_4 =date('Y-m-d', strtotime($_POST['editTanggalPengeluaran_4']));
    $countEditPengeluaran_4 = str_replace(".", "", $_POST['editCountPengeluaran_4']);
      if ($countEditPengeluaran_4 != $dataPilihEditPengeluaran_4['count_pengeluaran']) {
        $selisihCountEditPengeluaran_4 = $dataPilihEditPengeluaran_4['count_pengeluaran'] - $countEditPengeluaran_4;
        $statSaldoEditPengeluaran_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPengeluaran_all = mysqli_fetch_array($statSaldoEditPengeluaran_all);
        $statSaldoEditPengeluaran_4 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE pengeluaran_used=".$_POST['editIdPengeluaran_4']);
        $dataSaldoEditPengeluaran_4 = mysqli_fetch_array($statSaldoEditPengeluaran_4);
        
            for ($x = $dataSaldoEditPengeluaran_4['id_saldo'] ; $x <= $dataSaldoEditPengeluaran_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] + $selisihCountEditPengeluaran_4;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPengeluaranEdit_4 = mysqli_query($l, "UPDATE pengeluaran SET count_pengeluaran='".$countEditPengeluaran_4."', tanggal_pengeluaran='".$dateEditPengeluaran_4."', ket_pengeluaran='".$_POST['editKetPengeluaran_4']."', id_nota=".$_POST['idnotanew']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_4']);
              
      }else{
            $fixPengeluaranEdit_4 = mysqli_query($l, "UPDATE pengeluaran SET tanggal_pengeluaran='".$dateEditPengeluaran_4."', ket_pengeluaran='".$_POST['editKetPengeluaran_4']."', id_nota=".$_POST['idnotanew']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_4']);
      }
    }
    if (isset($_POST['editCountPengeluaran_5'])) {
      $statPilihEditPengeluaran_5 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_pengeluaran=".$_POST['editIdPengeluaran_5']);
      $dataPilihEditPengeluaran_5 = mysqli_fetch_array($statPilihEditPengeluaran_5);
      $dateEditPengeluaran_5 =date('Y-m-d', strtotime($_POST['editTanggalPengeluaran_5']));
    $countEditPengeluaran_5 = str_replace(".", "", $_POST['editCountPengeluaran_5']);
      if ($countEditPengeluaran_5 != $dataPilihEditPengeluaran_5['count_pengeluaran']) {
        $selisihCountEditPengeluaran_5 = $dataPilihEditPengeluaran_5['count_pengeluaran'] - $countEditPengeluaran_5;
        $statSaldoEditPengeluaran_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPengeluaran_all = mysqli_fetch_array($statSaldoEditPengeluaran_all);
        $statSaldoEditPengeluaran_5 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE pengeluaran_used=".$_POST['editIdPengeluaran_5']);
        $dataSaldoEditPengeluaran_5 = mysqli_fetch_array($statSaldoEditPengeluaran_5);
        
            for ($x = $dataSaldoEditPengeluaran_5['id_saldo'] ; $x <= $dataSaldoEditPengeluaran_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] + $selisihCountEditPengeluaran_5;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPengeluaranEdit_5 = mysqli_query($l, "UPDATE pengeluaran SET count_pengeluaran='".$countEditPengeluaran_5."', tanggal_pengeluaran='".$dateEditPengeluaran_5."', ket_pengeluaran='".$_POST['editKetPengeluaran_5']."', id_nota=".$_POST['idnotanew']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_5']);
              
      }else{
            $fixPengeluaranEdit_5 = mysqli_query($l, "UPDATE pengeluaran SET tanggal_pengeluaran='".$dateEditPengeluaran_5."', ket_pengeluaran='".$_POST['editKetPengeluaran_5']."', id_nota=".$_POST['idnotanew']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_5']);
      }
    }
    
    //
    
    if ($_POST['countPengeluaran_1'] != "") {
	$datePengeluaran_1 = date('Y-m-d', strtotime($_POST['tanggalPengeluaran_1']));
	$countPengeluaran_1 = str_replace(".", "", $_POST['countPengeluaran_1']);
   		$stat_pengeluaran_1 = mysqli_query($l, "INSERT INTO pengeluaran SET id_nota=".$_POST['idnotanew'].", count_pengeluaran=".$countPengeluaran_1.", tanggal_pengeluaran='".$datePengeluaran_1."', ket_pengeluaran = '".$_POST['ketPengeluaran_1']."'");
   		if ($stat_pengeluaran_1) {
   			$pilih_pengeluaran_1 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_nota=".$_POST['idnotanew']." AND count_pengeluaran=".$countPengeluaran_1." AND tanggal_pengeluaran='".$datePengeluaran_1."' AND ket_pengeluaran = '".$_POST['ketPengeluaran_1']."'");
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
   		$stat_pengeluaran_2 = mysqli_query($l, "INSERT INTO pengeluaran SET id_nota=".$_POST['idnotanew'].", count_pengeluaran=".$countPengeluaran_2.", tanggal_pengeluaran='".$datePengeluaran_2."', ket_pengeluaran = '".$_POST['ketPengeluaran_2']."'");
   		if ($stat_pengeluaran_2) {
   			$pilih_pengeluaran_2 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_nota=".$_POST['idnotanew']." AND count_pengeluaran=".$countPengeluaran_2." AND tanggal_pengeluaran='".$datePengeluaran_2."' AND ket_pengeluaran = '".$_POST['ketPengeluaran_2']."'");
   			$data_pilih_pengeluaran_2 = mysqli_fetch_array($pilih_pengeluaran_2);
   			$pilih_saldo_pengeluaran_2 = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 1");
   			$data_saldo_pengeluaran_2 = mysqli_fetch_array($pilih_saldo_pengeluaran_2);
   			
   			$next_count_pengeluaran_2 = $data_saldo_pengeluaran_2['count_saldo'] - $data_pilih_pengeluaran_2['count_pengeluaran'];
        	$next_id_pengeluaran_2 = $data_saldo_pengeluaran_2['id_saldo'] + 1;
   			
   			$in_saldo_2 = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_pengeluaran_2.", count_saldo=".$next_count_pengeluaran_2.", tanggal_saldo='".$data_pilih_pengeluaran_2['tanggal_pengeluaran']."', pengeluaran_used=".$data_pilih_pengeluaran_2['id_pengeluaran']);
   		}
    }













////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////














}else{
	if (empty($_POST['tanggalnota']) || empty($_POST['jenis']) || empty($_POST['kegiatan']) || empty($_POST['inakumulasi']) ) {
	?>
	<script src="../plugins/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript">
	swal("Isi Form dengan Lengkap (Tanggal Nota, Jenis Transaksi, Kegiatan / Uraian, dan Akumulasi Nota) !", {
	  icon: "warning", button:false, timer: 5000,})
	.then((value) => {
	  document.location="?page=editnota&idx=<?php echo $_POST['idnotaold'] ?>";
	});</script>
	<?php
	}else{
	$date = date('Y-m-d', strtotime($_POST['tanggalnota']));
    $stat_kegiatan = mysqli_query($l,"SELECT * FROM kegiatan WHERE nama_kegiatan = '".$_POST["kegiatan"]."'");
    $data_kegiatan = mysqli_fetch_array($stat_kegiatan);
    
    $stat_in = mysqli_query($l,"UPDATE nota SET tanggal_nota='".$date."', jenis_nota='".$_POST['jenis']."', id_kegiatan=".$data_kegiatan['id_kegiatan'].", akumulasi_nota ='".$_POST['inakumulasi']."' WHERE id_nota=".$_POST['idnotaold']);
    $stat_update_kegiatan = mysqli_query($l,"UPDATE kegiatan SET akumulasi_kegiatan='".$_POST['inakumulasikegiatan']."' WHERE id_kegiatan=".$data_kegiatan['id_kegiatan']." ");
	}
    //Pelunasan
    if ($_POST['countPelunasan'] != "") {
    $datePelunasan = date('Y-m-d', strtotime($_POST['tanggalPelunasan']));
    $countPelunasan = str_replace(".", "", $_POST['countPelunasan']);
      $stat_pelunasan = mysqli_query($l, "INSERT INTO penerimaan SET id_nota=".$_POST['idnotaold'].", count_penerimaan=".$countPelunasan.", tanggal_penerimaan='".$datePelunasan."', ket_penerimaan = 'Penerimaan - Pelunasan'");
      if ($stat_pelunasan) {
        $pilih_pelunasan = mysqli_query($l, "UPDATE nota SET pelunasan_nota=1 WHERE id_nota=".$_POST['idnotaold']);
        
        $pilih_pelunasan = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_nota=".$_POST['idnotaold']." AND count_penerimaan=".$countPelunasan." AND tanggal_penerimaan='".$datePelunasan."' AND ket_penerimaan = 'Penerimaan - Pelunasan'");
        $data_pilih_pelunasan = mysqli_fetch_array($pilih_pelunasan);
        $pilih_saldo_pelunasan = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 1");
        $data_saldo_pelunasan = mysqli_fetch_array($pilih_saldo_pelunasan);
        
        $next_count_pelunasan = $data_saldo_pelunasan['count_saldo'] + $data_pilih_pelunasan['count_penerimaan'];
        $next_id_pelunasan = $data_saldo_pelunasan['id_saldo'] + 1;
        
        $in_saldo_pelunasan = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_pelunasan.", count_saldo=".$next_count_pelunasan.", tanggal_saldo='".$data_pilih_pelunasan['tanggal_penerimaan']."', penerimaan_used=".$data_pilih_pelunasan['id_penerimaan']);
      }
    }
    //Peneriaan
    if (isset($_POST['editCountPenerimaan_1'])) {
      $statPilihEditPenerimaan_1 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_penerimaan=".$_POST['editIdPenerimaan_1']);
      $dataPilihEditPenerimaan_1 = mysqli_fetch_array($statPilihEditPenerimaan_1);
      $dateEditPenerimaan_1 =date('Y-m-d', strtotime($_POST['editTanggalPenerimaan_1']));
    $countEditPenerimaan_1 = str_replace(".", "", $_POST['editCountPenerimaan_1']);
      if ($countEditPenerimaan_1 != $dataPilihEditPenerimaan_1['count_penerimaan']) {
        $selisihCountEditPenerimaan_1 = $dataPilihEditPenerimaan_1['count_penerimaan'] - $countEditPenerimaan_1;
        $statSaldoEditPenerimaan_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPenerimaan_all = mysqli_fetch_array($statSaldoEditPenerimaan_all);
        $statSaldoEditPenerimaan_1 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE penerimaan_used=".$_POST['editIdPenerimaan_1']);
        $dataSaldoEditPenerimaan_1 = mysqli_fetch_array($statSaldoEditPenerimaan_1);
        
            for ($x = $dataSaldoEditPenerimaan_1['id_saldo'] ; $x <= $dataSaldoEditPenerimaan_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] - $selisihCountEditPenerimaan_1;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPenerimaanEdit_1 = mysqli_query($l, "UPDATE penerimaan SET count_penerimaan='".$countEditPenerimaan_1."', tanggal_penerimaan='".$dateEditPenerimaan_1."', ket_penerimaan='".$_POST['editKetPenerimaan_1']."', id_nota=".$_POST['idnotaold']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_1']);
              
      }else{
            $fixPenerimaanEdit_1 = mysqli_query($l, "UPDATE penerimaan SET tanggal_penerimaan='".$dateEditPenerimaan_1."', ket_penerimaan='".$_POST['editKetPenerimaan_1']."', id_nota=".$_POST['idnotaold']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_1']);
      }
    }
    if (isset($_POST['editCountPenerimaan_2'])) {
      $statPilihEditPenerimaan_2 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_penerimaan=".$_POST['editIdPenerimaan_2']);
      $dataPilihEditPenerimaan_2 = mysqli_fetch_array($statPilihEditPenerimaan_2);
      $dateEditPenerimaan_2 =date('Y-m-d', strtotime($_POST['editTanggalPenerimaan_2']));
      $countEditPenerimaan_2 = str_replace(".", "", $_POST['editCountPenerimaan_2']);
      if ($countEditPenerimaan_2 != $dataPilihEditPenerimaan_2['count_penerimaan']) {
        $selisihCountEditPenerimaan_2 = $dataPilihEditPenerimaan_2['count_penerimaan'] - $countEditPenerimaan_2;
        $statSaldoEditPenerimaan_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPenerimaan_all = mysqli_fetch_array($statSaldoEditPenerimaan_all);
        $statSaldoEditPenerimaan_2 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE penerimaan_used=".$_POST['editIdPenerimaan_2']);
        $dataSaldoEditPenerimaan_2 = mysqli_fetch_array($statSaldoEditPenerimaan_2);
        
            for ($x = $dataSaldoEditPenerimaan_2['id_saldo'] ; $x <= $dataSaldoEditPenerimaan_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] - $selisihCountEditPenerimaan_2;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPenerimaanEdit_2 = mysqli_query($l, "UPDATE penerimaan SET count_penerimaan='".$countEditPenerimaan_2."', tanggal_penerimaan='".$dateEditPenerimaan_2."', ket_penerimaan='".$_POST['editKetPenerimaan_2']."', id_nota=".$_POST['idnotaold']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_2']);
              
      }else{
            $fixPenerimaanEdit_2 = mysqli_query($l, "UPDATE penerimaan SET tanggal_penerimaan='".$dateEditPenerimaan_2."', ket_penerimaan='".$_POST['editKetPenerimaan_2']."', id_nota=".$_POST['idnotaold']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_2']);
      }
    }
    if (isset($_POST['editCountPenerimaan_3'])) {
      $statPilihEditPenerimaan_3 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_penerimaan=".$_POST['editIdPenerimaan_3']);
      $dataPilihEditPenerimaan_3 = mysqli_fetch_array($statPilihEditPenerimaan_3);
      $dateEditPenerimaan_3 =date('Y-m-d', strtotime($_POST['editTanggalPenerimaan_3']));
    $countEditPenerimaan_3 = str_replace(".", "", $_POST['editCountPenerimaan_3']);
      if ($countEditPenerimaan_3 != $dataPilihEditPenerimaan_3['count_penerimaan']) {
        $selisihCountEditPenerimaan_3 = $dataPilihEditPenerimaan_3['count_penerimaan'] - $countEditPenerimaan_3;
        $statSaldoEditPenerimaan_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPenerimaan_all = mysqli_fetch_array($statSaldoEditPenerimaan_all);
        $statSaldoEditPenerimaan_3 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE penerimaan_used=".$_POST['editIdPenerimaan_3']);
        $dataSaldoEditPenerimaan_3 = mysqli_fetch_array($statSaldoEditPenerimaan_3);
        
            for ($x = $dataSaldoEditPenerimaan_3['id_saldo'] ; $x <= $dataSaldoEditPenerimaan_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] - $selisihCountEditPenerimaan_3;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPenerimaanEdit_3 = mysqli_query($l, "UPDATE penerimaan SET count_penerimaan='".$countEditPenerimaan_3."', tanggal_penerimaan='".$dateEditPenerimaan_3."', ket_penerimaan='".$_POST['editKetPenerimaan_3']."', id_nota=".$_POST['idnotaold']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_3']);
              
      }else{
            $fixPenerimaanEdit_3 = mysqli_query($l, "UPDATE penerimaan SET tanggal_penerimaan='".$dateEditPenerimaan_3."', ket_penerimaan='".$_POST['editKetPenerimaan_3']."', id_nota=".$_POST['idnotaold']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_3']);
      }
    }
    if (isset($_POST['editCountPenerimaan_4'])) {
      $statPilihEditPenerimaan_4 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_penerimaan=".$_POST['editIdPenerimaan_4']);
      $dataPilihEditPenerimaan_4 = mysqli_fetch_array($statPilihEditPenerimaan_4);
      $dateEditPenerimaan_4 =date('Y-m-d', strtotime($_POST['editTanggalPenerimaan_4']));
    $countEditPenerimaan_4 = str_replace(".", "", $_POST['editCountPenerimaan_4']);
      if ($countEditPenerimaan_4 != $dataPilihEditPenerimaan_4['count_penerimaan']) {
        $selisihCountEditPenerimaan_4 = $dataPilihEditPenerimaan_4['count_penerimaan'] - $countEditPenerimaan_4;
        $statSaldoEditPenerimaan_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPenerimaan_all = mysqli_fetch_array($statSaldoEditPenerimaan_all);
        $statSaldoEditPenerimaan_4 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE penerimaan_used=".$_POST['editIdPenerimaan_4']);
        $dataSaldoEditPenerimaan_4 = mysqli_fetch_array($statSaldoEditPenerimaan_4);
        
            for ($x = $dataSaldoEditPenerimaan_4['id_saldo'] ; $x <= $dataSaldoEditPenerimaan_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] - $selisihCountEditPenerimaan_4;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPenerimaanEdit_4 = mysqli_query($l, "UPDATE penerimaan SET count_penerimaan='".$countEditPenerimaan_4."', tanggal_penerimaan='".$dateEditPenerimaan_4."', ket_penerimaan='".$_POST['editKetPenerimaan_4']."', id_nota=".$_POST['idnotaold']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_4']);
              
      }else{
            $fixPenerimaanEdit_4 = mysqli_query($l, "UPDATE penerimaan SET tanggal_penerimaan='".$dateEditPenerimaan_4."', ket_penerimaan='".$_POST['editKetPenerimaan_4']."', id_nota=".$_POST['idnotaold']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_4']);
      }
    }
    if (isset($_POST['editCountPenerimaan_5'])) {
      $statPilihEditPenerimaan_5 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_penerimaan=".$_POST['editIdPenerimaan_5']);
      $dataPilihEditPenerimaan_5 = mysqli_fetch_array($statPilihEditPenerimaan_5);
      $dateEditPenerimaan_5 =date('Y-m-d', strtotime($_POST['editTanggalPenerimaan_5']));
    $countEditPenerimaan_5 = str_replace(".", "", $_POST['editCountPenerimaan_5']);
      if ($countEditPenerimaan_5 != $dataPilihEditPenerimaan_5['count_penerimaan']) {
        $selisihCountEditPenerimaan_5 = $dataPilihEditPenerimaan_5['count_penerimaan'] - $countEditPenerimaan_5;
        $statSaldoEditPenerimaan_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPenerimaan_all = mysqli_fetch_array($statSaldoEditPenerimaan_all);
        $statSaldoEditPenerimaan_5 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE penerimaan_used=".$_POST['editIdPenerimaan_5']);
        $dataSaldoEditPenerimaan_5 = mysqli_fetch_array($statSaldoEditPenerimaan_5);
        
            for ($x = $dataSaldoEditPenerimaan_5['id_saldo'] ; $x <= $dataSaldoEditPenerimaan_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] - $selisihCountEditPenerimaan_5;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPenerimaanEdit_5 = mysqli_query($l, "UPDATE penerimaan SET count_penerimaan='".$countEditPenerimaan_5."', tanggal_penerimaan='".$dateEditPenerimaan_5."', ket_penerimaan='".$_POST['editKetPenerimaan_5']."', id_nota=".$_POST['idnotaold']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_5']);
              
      }else{
            $fixPenerimaanEdit_5 = mysqli_query($l, "UPDATE penerimaan SET tanggal_penerimaan='".$dateEditPenerimaan_5."', ket_penerimaan='".$_POST['editKetPenerimaan_5']."', id_nota=".$_POST['idnotaold']." WHERE id_penerimaan=".$_POST['editIdPenerimaan_5']);
      }
    }
    
    
  if ($_POST['countPenerimaan_1'] != "") {
  $datePenerimaan_1 = date('Y-m-d', strtotime($_POST['tanggalPenerimaan_1']));
  $countPenerimaan_1 = str_replace(".", "", $_POST['countPenerimaan_1']);
      $stat_penerimaan_1 = mysqli_query($l, "INSERT INTO penerimaan SET id_nota=".$_POST['idnotaold'].", count_penerimaan=".$countPenerimaan_1.", tanggal_penerimaan='".$datePenerimaan_1."', ket_penerimaan = '".$_POST['ketPenerimaan_1']."'");
      if ($stat_penerimaan_1) {
        $pilih_penerimaan_1 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_nota=".$_POST['idnotaold']." AND count_penerimaan=".$countPenerimaan_1." AND tanggal_penerimaan='".$datePenerimaan_1."' AND ket_penerimaan = '".$_POST['ketPenerimaan_1']."'");
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
      $stat_penerimaan_2 = mysqli_query($l, "INSERT INTO penerimaan SET id_nota=".$_POST['idnotaold'].", count_penerimaan=".$countPenerimaan_2.", tanggal_penerimaan='".$datePenerimaan_2."', ket_penerimaan = '".$_POST['ketPenerimaan_2']."'");
      if ($stat_penerimaan_2) {
        $pilih_penerimaan_2 = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_nota=".$_POST['idnotaold']." AND count_penerimaan=".$countPenerimaan_2." AND tanggal_penerimaan='".$datePenerimaan_2."' AND ket_penerimaan = '".$_POST['ketPenerimaan_2']."'");
        $data_pilih_penerimaan_2 = mysqli_fetch_array($pilih_penerimaan_2);
        $pilih_saldo_penerimaan_2 = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 1");
        $data_saldo_penerimaan_2 = mysqli_fetch_array($pilih_saldo_penerimaan_2);
        
        $next_count_penerimaan_2 = $data_saldo_penerimaan_2['count_saldo'] + $data_pilih_penerimaan_2['count_penerimaan'];
        $next_id_penerimaan_2 = $data_saldo_penerimaan_2['id_saldo'] + 1;
        
        $in_saldo_2 = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_penerimaan_2.", count_saldo=".$next_count_penerimaan_2.", tanggal_saldo='".$data_pilih_penerimaan_2['tanggal_penerimaan']."', penerimaan_used=".$data_pilih_penerimaan_2['id_penerimaan']);
      }
    }
    
    //Pengeluaran
    if (isset($_POST['editCountPengeluaran_1'])) {
      $statPilihEditPengeluaran_1 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_pengeluaran=".$_POST['editIdPengeluaran_1']);
      $dataPilihEditPengeluaran_1 = mysqli_fetch_array($statPilihEditPengeluaran_1);
      $dateEditPengeluaran_1 =date('Y-m-d', strtotime($_POST['editTanggalPengeluaran_1']));
    $countEditPengeluaran_1 = str_replace(".", "", $_POST['editCountPengeluaran_1']);
      if ($countEditPengeluaran_1 != $dataPilihEditPengeluaran_1['count_pengeluaran']) {
        $selisihCountEditPengeluaran_1 = $dataPilihEditPengeluaran_1['count_pengeluaran'] - $countEditPengeluaran_1;
        $statSaldoEditPengeluaran_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPengeluaran_all = mysqli_fetch_array($statSaldoEditPengeluaran_all);
        $statSaldoEditPengeluaran_1 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE pengeluaran_used=".$_POST['editIdPengeluaran_1']);
        $dataSaldoEditPengeluaran_1 = mysqli_fetch_array($statSaldoEditPengeluaran_1);
        
            for ($x = $dataSaldoEditPengeluaran_1['id_saldo'] ; $x <= $dataSaldoEditPengeluaran_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] + $selisihCountEditPengeluaran_1;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPengeluaranEdit_1 = mysqli_query($l, "UPDATE pengeluaran SET count_pengeluaran='".$countEditPengeluaran_1."', tanggal_pengeluaran='".$dateEditPengeluaran_1."', ket_pengeluaran='".$_POST['editKetPengeluaran_1']."', id_nota=".$_POST['idnotaold']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_1']);
              
      }else{
            $fixPengeluaranEdit_1 = mysqli_query($l, "UPDATE pengeluaran SET tanggal_pengeluaran='".$dateEditPengeluaran_1."', ket_pengeluaran='".$_POST['editKetPengeluaran_1']."', id_nota=".$_POST['idnotaold']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_1']);
      }
    }
    if (isset($_POST['editCountPengeluaran_2'])) {
      $statPilihEditPengeluaran_2 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_pengeluaran=".$_POST['editIdPengeluaran_2']);
      $dataPilihEditPengeluaran_2 = mysqli_fetch_array($statPilihEditPengeluaran_2);
      $dateEditPengeluaran_2 =date('Y-m-d', strtotime($_POST['editTanggalPengeluaran_2']));
    $countEditPengeluaran_2 = str_replace(".", "", $_POST['editCountPengeluaran_2']);
      if ($countEditPengeluaran_2 != $dataPilihEditPengeluaran_2['count_pengeluaran']) {
        $selisihCountEditPengeluaran_2 = $dataPilihEditPengeluaran_2['count_pengeluaran'] - $countEditPengeluaran_2;
        $statSaldoEditPengeluaran_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPengeluaran_all = mysqli_fetch_array($statSaldoEditPengeluaran_all);
        $statSaldoEditPengeluaran_2 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE pengeluaran_used=".$_POST['editIdPengeluaran_2']);
        $dataSaldoEditPengeluaran_2 = mysqli_fetch_array($statSaldoEditPengeluaran_2);
        
            for ($x = $dataSaldoEditPengeluaran_2['id_saldo'] ; $x <= $dataSaldoEditPengeluaran_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] + $selisihCountEditPengeluaran_2;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPengeluaranEdit_2 = mysqli_query($l, "UPDATE pengeluaran SET count_pengeluaran='".$countEditPengeluaran_2."', tanggal_pengeluaran='".$dateEditPengeluaran_2."', ket_pengeluaran='".$_POST['editKetPengeluaran_2']."', id_nota=".$_POST['idnotaold']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_2']);
              
      }else{
            $fixPengeluaranEdit_2 = mysqli_query($l, "UPDATE pengeluaran SET tanggal_pengeluaran='".$dateEditPengeluaran_2."', ket_pengeluaran='".$_POST['editKetPengeluaran_2']."', id_nota=".$_POST['idnotaold']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_2']);
      }
    }
    if (isset($_POST['editCountPengeluaran_3'])) {
      $statPilihEditPengeluaran_3 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_pengeluaran=".$_POST['editIdPengeluaran_3']);
      $dataPilihEditPengeluaran_3 = mysqli_fetch_array($statPilihEditPengeluaran_3);
      $dateEditPengeluaran_3 =date('Y-m-d', strtotime($_POST['editTanggalPengeluaran_3']));
    $countEditPengeluaran_3 = str_replace(".", "", $_POST['editCountPengeluaran_3']);
      if ($countEditPengeluaran_3 != $dataPilihEditPengeluaran_3['count_pengeluaran']) {
        $selisihCountEditPengeluaran_3 = $dataPilihEditPengeluaran_3['count_pengeluaran'] - $countEditPengeluaran_3;
        $statSaldoEditPengeluaran_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPengeluaran_all = mysqli_fetch_array($statSaldoEditPengeluaran_all);
        $statSaldoEditPengeluaran_3 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE pengeluaran_used=".$_POST['editIdPengeluaran_3']);
        $dataSaldoEditPengeluaran_3 = mysqli_fetch_array($statSaldoEditPengeluaran_3);
        
            for ($x = $dataSaldoEditPengeluaran_3['id_saldo'] ; $x <= $dataSaldoEditPengeluaran_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] + $selisihCountEditPengeluaran_3;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPengeluaranEdit_3 = mysqli_query($l, "UPDATE pengeluaran SET count_pengeluaran='".$countEditPengeluaran_3."', tanggal_pengeluaran='".$dateEditPengeluaran_3."', ket_pengeluaran='".$_POST['editKetPengeluaran_3']."', id_nota=".$_POST['idnotaold']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_3']);
              
      }else{
            $fixPengeluaranEdit_3 = mysqli_query($l, "UPDATE pengeluaran SET tanggal_pengeluaran='".$dateEditPengeluaran_3."', ket_pengeluaran='".$_POST['editKetPengeluaran_3']."', id_nota=".$_POST['idnotaold']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_3']);
      }
    }
    if (isset($_POST['editCountPengeluaran_4'])) {
      $statPilihEditPengeluaran_4 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_pengeluaran=".$_POST['editIdPengeluaran_4']);
      $dataPilihEditPengeluaran_4 = mysqli_fetch_array($statPilihEditPengeluaran_4);
      $dateEditPengeluaran_4 =date('Y-m-d', strtotime($_POST['editTanggalPengeluaran_4']));
    $countEditPengeluaran_4 = str_replace(".", "", $_POST['editCountPengeluaran_4']);
      if ($countEditPengeluaran_4 != $dataPilihEditPengeluaran_4['count_pengeluaran']) {
        $selisihCountEditPengeluaran_4 = $dataPilihEditPengeluaran_4['count_pengeluaran'] - $countEditPengeluaran_4;
        $statSaldoEditPengeluaran_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPengeluaran_all = mysqli_fetch_array($statSaldoEditPengeluaran_all);
        $statSaldoEditPengeluaran_4 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE pengeluaran_used=".$_POST['editIdPengeluaran_4']);
        $dataSaldoEditPengeluaran_4 = mysqli_fetch_array($statSaldoEditPengeluaran_4);
        
            for ($x = $dataSaldoEditPengeluaran_4['id_saldo'] ; $x <= $dataSaldoEditPengeluaran_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] + $selisihCountEditPengeluaran_4;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPengeluaranEdit_4 = mysqli_query($l, "UPDATE pengeluaran SET count_pengeluaran='".$countEditPengeluaran_4."', tanggal_pengeluaran='".$dateEditPengeluaran_4."', ket_pengeluaran='".$_POST['editKetPengeluaran_4']."', id_nota=".$_POST['idnotaold']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_4']);
              
      }else{
            $fixPengeluaranEdit_4 = mysqli_query($l, "UPDATE pengeluaran SET tanggal_pengeluaran='".$dateEditPengeluaran_4."', ket_pengeluaran='".$_POST['editKetPengeluaran_4']."', id_nota=".$_POST['idnotaold']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_4']);
      }
    }
    if (isset($_POST['editCountPengeluaran_5'])) {
      $statPilihEditPengeluaran_5 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_pengeluaran=".$_POST['editIdPengeluaran_5']);
      $dataPilihEditPengeluaran_5 = mysqli_fetch_array($statPilihEditPengeluaran_5);
      $dateEditPengeluaran_5 =date('Y-m-d', strtotime($_POST['editTanggalPengeluaran_5']));
    $countEditPengeluaran_5 = str_replace(".", "", $_POST['editCountPengeluaran_5']);
      if ($countEditPengeluaran_5 != $dataPilihEditPengeluaran_5['count_pengeluaran']) {
        $selisihCountEditPengeluaran_5 = $dataPilihEditPengeluaran_5['count_pengeluaran'] - $countEditPengeluaran_5;
        $statSaldoEditPengeluaran_all = mysqli_query($l, "SELECT COUNT(id_saldo) AS all_saldo FROM saldo");
        $dataSaldoEditPengeluaran_all = mysqli_fetch_array($statSaldoEditPengeluaran_all);
        $statSaldoEditPengeluaran_5 = mysqli_query($l, "SELECT id_saldo FROM saldo WHERE pengeluaran_used=".$_POST['editIdPengeluaran_5']);
        $dataSaldoEditPengeluaran_5 = mysqli_fetch_array($statSaldoEditPengeluaran_5);
        
            for ($x = $dataSaldoEditPengeluaran_5['id_saldo'] ; $x <= $dataSaldoEditPengeluaran_all['all_saldo']; $x++) {
              $stat_SaldoEdit = mysqli_query($l, "SELECT * FROM saldo WHERE id_saldo=".$x);
              $data_SaldoEdit = mysqli_fetch_array($stat_SaldoEdit);
              $countSaldoEdit = $data_SaldoEdit['count_saldo'] + $selisihCountEditPengeluaran_5;
              $fixSaldoEdit = mysqli_query($l, "UPDATE saldo SET count_saldo=".$countSaldoEdit." WHERE id_saldo=".$x);
        }
            $fixPengeluaranEdit_5 = mysqli_query($l, "UPDATE pengeluaran SET count_pengeluaran='".$countEditPengeluaran_5."', tanggal_pengeluaran='".$dateEditPengeluaran_5."', ket_pengeluaran='".$_POST['editKetPengeluaran_5']."', id_nota=".$_POST['idnotaold']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_5']);
              
      }else{
            $fixPengeluaranEdit_5 = mysqli_query($l, "UPDATE pengeluaran SET tanggal_pengeluaran='".$dateEditPengeluaran_5."', ket_pengeluaran='".$_POST['editKetPengeluaran_5']."', id_nota=".$_POST['idnotaold']." WHERE id_pengeluaran=".$_POST['editIdPengeluaran_5']);
      }
    }
    
    //
    
    if ($_POST['countPengeluaran_1'] != "") {
  $datePengeluaran_1 = date('Y-m-d', strtotime($_POST['tanggalPengeluaran_1']));
  $countPengeluaran_1 = str_replace(".", "", $_POST['countPengeluaran_1']);
      $stat_pengeluaran_1 = mysqli_query($l, "INSERT INTO pengeluaran SET id_nota=".$_POST['idnotaold'].", count_pengeluaran=".$countPengeluaran_1.", tanggal_pengeluaran='".$datePengeluaran_1."', ket_pengeluaran = '".$_POST['ketPengeluaran_1']."'");
      if ($stat_pengeluaran_1) {
        $pilih_pengeluaran_1 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_nota=".$_POST['idnotaold']." AND count_pengeluaran=".$countPengeluaran_1." AND tanggal_pengeluaran='".$datePengeluaran_1."' AND ket_pengeluaran = '".$_POST['ketPengeluaran_1']."'");
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
      $stat_pengeluaran_2 = mysqli_query($l, "INSERT INTO pengeluaran SET id_nota=".$_POST['idnotaold'].", count_pengeluaran=".$countPengeluaran_2.", tanggal_pengeluaran='".$datePengeluaran_2."', ket_pengeluaran = '".$_POST['ketPengeluaran_2']."'");
      if ($stat_pengeluaran_2) {
        $pilih_pengeluaran_2 = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_nota=".$_POST['idnotaold']." AND count_pengeluaran=".$countPengeluaran_2." AND tanggal_pengeluaran='".$datePengeluaran_2."' AND ket_pengeluaran = '".$_POST['ketPengeluaran_2']."'");
        $data_pilih_pengeluaran_2 = mysqli_fetch_array($pilih_pengeluaran_2);
        $pilih_saldo_pengeluaran_2 = mysqli_query($l , "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 1");
        $data_saldo_pengeluaran_2 = mysqli_fetch_array($pilih_saldo_pengeluaran_2);
        
        $next_count_pengeluaran_2 = $data_saldo_pengeluaran_2['count_saldo'] - $data_pilih_pengeluaran_2['count_pengeluaran'];
        $next_id_pengeluaran_2 = $data_saldo_pengeluaran_2['id_saldo'] + 1;
        
        $in_saldo_2 = mysqli_query($l, "INSERT INTO saldo SET id_saldo=".$next_id_pengeluaran_2.", count_saldo=".$next_count_pengeluaran_2.", tanggal_saldo='".$data_pilih_pengeluaran_2['tanggal_pengeluaran']."', pengeluaran_used=".$data_pilih_pengeluaran_2['id_pengeluaran']);
      }
    }
}


    
    ?>
<script src="../plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
swal("Berhasil Mengedit Nota !", {
  icon: "success", button:false, timer: 2400,})
.then((value) => {
  document.location="?page=nota";
});</script>
