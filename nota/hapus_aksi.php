<?php
include '../base/koneksi.php';

$stat_1 = mysqli_query($l, "SELECT * FROM nota WHERE id_nota=".$_GET['idx']) OR die(mysql_error($l));
$data_1 = mysqli_fetch_array($stat_1);
if ($stat_1) {
	$stat_jumlah_penerimaan = mysqli_query($l, "SELECT SUM(count_penerimaan) AS jumlah_penerimana FROM penerimaan WHERE id_nota=".$_GET['idx']);
	$data_jumlah_penerimaan = mysqli_fetch_array($stat_jumlah_penerimaan);
	
	$stat_jumlah_pengeluaran = mysqli_query($l, "SELECT SUM(count_pengeluaran) AS jumlah_pengeluaran FROM pengeluaran WHERE id_nota=".$_GET['idx']);
	$data_jumlah_pengeluaran = mysqli_fetch_array($stat_jumlah_pengeluaran);
	
	$stat_saldo = mysqli_query($l, "SELECT count_saldo FROM saldo ORDER BY id_saldo DESC LIMIT 1");
	$data_saldo = mysqli_fetch_array($stat_saldo);
	
	$stat_akumulasi_kegiatan = mysqli_query($l, "SELECT * FROM kegiatan WHERE id_kegiatan=".$data_1['id_kegiatan']);
	$data_akumulasi_kegiatan = mysqli_fetch_array($stat_akumulasi_kegiatan);
	
	$next_count = ( $data_saldo['count_saldo'] - $data_jumlah_penerimaan['jumlah_penerimana'] ) + $data_jumlah_pengeluaran['jumlah_pengeluaran'];
	$fix_count = ( $data_akumulasi_kegiatan['akumulasi_kegiatan'] - $data_jumlah_penerimaan['jumlah_penerimana'] ) + $data_jumlah_pengeluaran['jumlah_pengeluaran'];
	
	$date_now = date('Y-m-d');
	$stat_new_saldo = mysqli_query($l, "INSERT INTO saldo SET count_saldo=".$next_count.", fixing_nota=".$_GET['idx'].", tanggal_saldo = '".$date_now."'");
	$stat_fix_akumulasi = mysqli_query($l, "UPDATE kegiatan SET akumulasi_kegiatan='".$fix_count."' WHERE id_kegiatan=".$data_akumulasi_kegiatan['id_kegiatan']);
	if ($stat_new_saldo && $stat_fix_akumulasi) {
	mysqli_query($l, "DELETE FROM nota WHERE id_nota=".$_GET['idx']) OR die(mysql_error($l));
	mysqli_query($l, "DELETE FROM penerimaan WHERE id_nota=".$_GET['idx']) OR die(mysql_error($l));
	mysqli_query($l, "DELETE FROM pengeluaran WHERE id_nota=".$_GET['idx']) OR die(mysql_error($l));
	}
}
?>
