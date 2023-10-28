    <style>
    #table {
      font-family: Arial;
      border-collapse: collapse;
      width: 50%;
      margin:30px auto;
      position: relative;
    }

    #table td, #table th {
      border: 1px solid #ddd;
      padding: 8px;
      word-wrap:break-word;
    }
    
    #table td {font-size:12px;}

    #table tr:nth-child(even){background-color: #f2f2f2;}

    #table tr:hover {background-color: #ddd;}

    #table th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: center;
      font-size:14px;
    }
    .no, .td-no{width: 5px}
    .tanggal, .td-tanggal{width: 45px}
    .jenis, .td-jenis{width: 30px}
    .uraian, .td-uraian{width: 385px}
    .penerimaan,.pengeluaran,.td-penerimaan,.td-pengeluaran{width: 100px}
    .saldo,.td-saldo{width: 110px}
    </style>
    
<page backtop="0mm" backbottom="5mm" backleft="6mm" backright="6mm">
<?php
include '../base/koneksi.php';
$limit_select = $_GET['idx'] - 1;
$stat_select_1 = mysqli_query($l, "SELECT * FROM nota n JOIN kegiatan k ON n.id_kegiatan=k.id_kegiatan ORDER BY id_nota ASC LIMIT ".$limit_select);
$stat_select_nota_1 = mysqli_query($l, "SELECT * FROM nota n JOIN kegiatan k ON n.id_kegiatan=k.id_kegiatan WHERE id_nota=".$_GET['idx']." ORDER BY id_nota ASC");
?>
<table id="table">

<tr>
    <th class="no">No</th>
    <th class="tanggal">Tanggal</th>
    <th class="jenis">Jenis</th>
    <th class="uraian" colspan="2">Uraian</th>
    <th class="penerimaan">Penerimaan</th>
    <th class="pengeluaran">Pengeluaran</th>
    <th class="saldo">Saldo di PPTK</th>
</tr>
  
  <?php
  if ($_GET['idx'] != 1) {
    $show_saldo = 0;
    while ($data_select_1 = mysqli_fetch_array($stat_select_1)) {

    $stat_select_3 = mysqli_query($l, "SELECT id_saldo, id_nota, count_saldo, count_penerimaan, ket_penerimaan,NULL AS count_pengeluaran, NULL AS ket_pengeluaran FROM saldo,penerimaan WHERE penerimaan_used=id_penerimaan AND id_nota=".$data_select_1['id_nota']." UNION SELECT id_saldo, id_nota, count_saldo,NULL AS count_penerimaan, NULL AS ket_penerimaan,count_pengeluaran, ket_pengeluaran FROM saldo,pengeluaran WHERE pengeluaran_used=id_pengeluaran AND id_nota=".$data_select_1['id_nota']." ORDER BY id_saldo ASC");
    while ($data_select_3 = mysqli_fetch_array($stat_select_3)) {    
        if ($data_select_3['count_penerimaan'] != NULL) {
            $show_saldo=$show_saldo + $data_select_3['count_penerimaan'];
        }else{
            $show_saldo= $show_saldo - $data_select_3['count_pengeluaran'];
        }
    }}
   }else{
    $show_saldo = 0;
   }
    ?>
  
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="2">SALDO SEBELUMNYA</td>
    <td></td>
    <td></td>
    <?php
    if ($show_saldo < 0) {
    $show_saldo_2 = $show_saldo * -1;
    ?>
    <td><?php echo "- Rp".number_format($show_saldo_2,0,"",".") ?></td>
    <?php
    }else{
    $show_saldo_2 = $show_saldo;
    ?>
    <td><?php echo "Rp".number_format($show_saldo_2,0,"",".") ?></td>
    <?php
    }
    ?>
  </tr>
  

<?php
while ($data_select_nota_1 = mysqli_fetch_array($stat_select_nota_1)) {
$stat_select_nota_2 = mysqli_query($l, "SELECT id_saldo, id_nota, count_saldo, count_penerimaan, ket_penerimaan,NULL AS count_pengeluaran, NULL AS ket_pengeluaran FROM saldo,penerimaan WHERE penerimaan_used=id_penerimaan AND id_nota=".$data_select_nota_1['id_nota']." UNION SELECT id_saldo, id_nota, count_saldo,NULL AS count_penerimaan, NULL AS ket_penerimaan,count_pengeluaran, ket_pengeluaran FROM saldo,pengeluaran WHERE pengeluaran_used=id_pengeluaran AND id_nota=".$data_select_nota_1['id_nota']." ORDER BY id_saldo ASC LIMIT 1");
while ($data_select_nota_2 = mysqli_fetch_array($stat_select_nota_2)) {
?>
  <tr>
    <td style="text-align:center" class="td-no"><?php echo $data_select_nota_1['id_nota']; ?></td>
    <td class="td-tanggal"><?php echo date("d-m-Y", strtotime($data_select_nota_1['tanggal_nota'])); ?></td>
    <td class="td-jenis"><?php echo $data_select_nota_1['jenis_nota']; ?></td>
    <?php
    if ($data_select_nota_2['count_penerimaan'] != NULL) {
        if ($data_select_nota_2['ket_penerimaan'] != "" || $data_select_nota_2['ket_penerimaan'] != NULL) {
        ?>
        <td colspan="2" class="td-uraian"><?php echo "<i>".$data_select_nota_2['ket_penerimaan']."</i> ".$data_select_nota_1['nama_kegiatan']; ?></td>
        <?php
        }else{
        ?>
        <td colspan="2" class="td-uraian"><?php echo "<i>Penerimaan</i> ".$data_select_nota_1['nama_kegiatan']; ?></td>
        <?php
        }
    }else{
    if ($data_select_nota_2['ket_pengeluaran'] != "" || $data_select_nota_2['ket_pengeluaran'] != NULL) {
        ?>
        <td width="8%"></td>
        <td class="td-uraian"><?php echo "<i>".$data_select_nota_2['ket_pengeluaran']."</i> ".$data_select_nota_1['nama_kegiatan']; ?></td>
        <?php
        }else{
        ?>
        <td width="8%"></td>
        <td class="td-uraian"><?php echo "<i>Pengeluaran</i> ".$data_select_nota_1['nama_kegiatan']; ?></td>
        <?php
        }
    }
    
    if ($data_select_nota_2['count_penerimaan'] != NULL) {
        $show_saldo=$show_saldo + $data_select_nota_2['count_penerimaan'];
    ?>
    <td class="td-penerimaan"><?php echo "Rp".number_format($data_select_nota_2['count_penerimaan'],0,"",".") ?></td>
    <td></td>
    <?php
    }else{
        $show_saldo= $show_saldo - $data_select_nota_2['count_pengeluaran'];
    ?>
    <td></td>
    <td class="td-pengeluaran"><?php echo "Rp".number_format($data_select_nota_2['count_pengeluaran'],0,"",".") ?></td>
    <?php
    }
    
    if ($show_saldo < 0) {
    $show_saldo_2 = $show_saldo * -1;
    ?>
    <td class="td-saldo"><?php echo "- Rp".number_format($show_saldo_2,0,"",".") ?></td>
    <?php
    }else{
    $show_saldo_2 = $show_saldo;
    ?>
    <td class="td-saldo"><?php echo "Rp".number_format($show_saldo_2,0,"",".") ?></td>
    <?php
    }
    ?>
  </tr>
<?php
$stat_select_nota_3 = mysqli_query($l, "SELECT id_saldo, id_nota, count_saldo, count_penerimaan, ket_penerimaan,NULL AS count_pengeluaran, NULL AS ket_pengeluaran FROM saldo,penerimaan WHERE penerimaan_used=id_penerimaan AND id_nota=".$data_select_nota_1['id_nota']." AND NOT id_saldo=".$data_select_nota_2['id_saldo']." UNION SELECT id_saldo, id_nota, count_saldo,NULL AS count_penerimaan, NULL AS ket_penerimaan,count_pengeluaran, ket_pengeluaran FROM saldo,pengeluaran WHERE pengeluaran_used=id_pengeluaran AND id_nota=".$data_select_nota_1['id_nota']." AND NOT id_saldo=".$data_select_nota_2['id_saldo']." ORDER BY id_saldo ASC");
while ($data_select_nota_3 = mysqli_fetch_array($stat_select_nota_3)) {
?>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <?php
    if ($data_select_nota_3['count_penerimaan'] != NULL) {
        if ($data_select_nota_3['ket_penerimaan'] != "" || $data_select_nota_3['ket_penerimaan'] != NULL) {
        ?>
        <td colspan="2" class="td-uraian"><?php echo "<i>".$data_select_nota_3['ket_penerimaan']."</i> ".$data_select_nota_1['nama_kegiatan']; ?></td>
        <?php
        }else{
        ?>
        <td colspan="2" class="td-uraian"><?php echo "<i>Penerimaan</i> ".$data_select_nota_1['nama_kegiatan']; ?></td>
        <?php
        }
    }else{
    if ($data_select_nota_3['ket_pengeluaran'] != "" || $data_select_nota_3['ket_pengeluaran'] != NULL) {
        ?>
        <td width="8%"></td>
        <td class="td-uraian"><?php echo "<i>".$data_select_nota_3['ket_pengeluaran']."</i> ".$data_select_nota_1['nama_kegiatan']; ?></td>
        <?php
        }else{
        ?>
        <td width="8%"></td>
        <td class="td-uraian"><?php echo "<i>Pengeluaran</i> ".$data_select_nota_1['nama_kegiatan']; ?></td>
        <?php
        }
    }
    
    if ($data_select_nota_3['count_penerimaan'] != NULL) {
        $show_saldo=$show_saldo + $data_select_nota_3['count_penerimaan'];
    ?>
    <td class="td-penerimaan"><?php echo "Rp".number_format($data_select_nota_3['count_penerimaan'],0,"",".") ?></td>
    <td></td>
    <?php
    }else{
        $show_saldo= $show_saldo - $data_select_nota_3['count_pengeluaran'];
    ?>
    <td></td>
    <td class="td-pengeluaran"><?php echo "Rp".number_format($data_select_nota_3['count_pengeluaran'],0,"",".") ?></td>
    <?php
    }
    
    if ($show_saldo < 0) {
    $show_saldo_2 = $show_saldo * -1;
    ?>
    <td class="td-saldo"><?php echo "- Rp".number_format($show_saldo_2,0,"",".") ?></td>
    <?php
    }else{
    $show_saldo_2 = $show_saldo;
    ?>
    <td class="td-saldo"><?php echo "Rp".number_format($show_saldo_2,0,"",".") ?></td>
    <?php
    }
    ?>
  </tr>
<?php
}}}
?>


  
<tr>
<th colspan="5">Total</th>

<?php
$stat_jumlah = mysqli_query($l, "SELECT SUM(count_penerimaan) AS Tpenerimaan, NULL AS Tpengeluaran FROM penerimaan WHERE id_nota=".$_GET['idx']." UNION SELECT NULL AS Tpenerimaan, SUM(count_pengeluaran) AS Tpengeluaran FROM pengeluaran WHERE id_nota=".$_GET['idx']);
while ($data_jumlah = mysqli_fetch_array($stat_jumlah)) {
if ($data_jumlah['Tpenerimaan'] != NULL) {
?>
<th>Rp<?php echo number_format($data_jumlah['Tpenerimaan'],0,"",".")?></th>
<?php
}else{
?>
<th>Rp<?php echo number_format($data_jumlah['Tpengeluaran'],0,"",".")?></th>
<?php
}

}
if ($show_saldo < 0) {
$show_saldo_jumlah = $show_saldo * -1;
?>
<th>- Rp<?php echo number_format($show_saldo_jumlah,0,"",".") ?></th>
<?php
}else{
$show_saldo_jumlah = $show_saldo;
?>
<th>Rp<?php echo number_format($show_saldo_jumlah,0,"",".") ?></th>
<?php
}
?>
</tr>
</table>
</page>
