<!-- Setting Form -->

<?php
$jumlahFormPP = 2;
$stat_nota = mysqli_query($l, "SELECT * FROM nota n JOIN kegiatan k ON n.id_kegiatan=k.id_kegiatan WHERE id_nota=".$_GET['idx']);
$data_nota = mysqli_fetch_array($stat_nota);
$stat_jumlahEditPengeluaran = mysqli_query($l, "SELECT COUNT(id_pengeluaran) AS jumlah_pengeluaran FROM pengeluaran WHERE id_nota=".$_GET['idx']);
$jumlahEditPengeluaran = mysqli_fetch_array($stat_jumlahEditPengeluaran);
$stat_jumlahEditPenerimaan = mysqli_query($l, "SELECT COUNT(id_penerimaan) AS jumlah_penerimaan FROM penerimaan WHERE id_nota=".$_GET['idx']);
$jumlahEditPenerimaan = mysqli_fetch_array($stat_jumlahEditPenerimaan);

$cek_jumlahEditPengeluaran = mysqli_num_rows(mysqli_query($l, "SELECT COUNT(id_pengeluaran) AS jumlah_pengeluaran FROM pengeluaran WHERE id_nota=".$_GET['idx']));
$cek_jumlahEditPenerimaan = mysqli_num_rows(mysqli_query($l, "SELECT COUNT(id_penerimaan) AS jumlah_penerimaan FROM penerimaan WHERE id_nota=".$_GET['idx']));
?>

<div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a href="?"><button class="btn btn-warning waves-effect"><i class="material-icons" style="font-size: 17px" title="Kembali ke Halaman Kegiatan">arrow_back</i> Kembali</button></a>
                
                    <div class="card">
                        <div class="header">
                            <h2>
                                Tambah Nota
                            </h2>
                            
                            <!-- Akumulasi Sebelumnya -->
                            <div class="info-box bg-blue hover-expand-effect" style="position: fixed;top:80px;right:15px;z-index: 1000">
                            <div class="icon">
                                <i class="material-icons">attach_money</i>
                            </div>
                            <div class="content">
                                <div class="text">Akumulasi Kegiatan Sebelumnya</div>
                                <?php
                                 if ($data_nota["akumulasi_kegiatan"] < 0) {
                                    $akumulasiKegiatanIn = $data_nota["akumulasi_kegiatan"];
                                     $akumulasiKegiatan = $data_nota["akumulasi_kegiatan"] * -1;
                                 echo '<div id="show_akumulasiprev"><input type="hidden" id="prevAkumulasiKegiatan" value="'.$akumulasiKegiatanIn.'"/> <div class="number count-to" style="padding-right: 10px;background: transparent;border:none;color: #000;width: 250px" id="nilaiAkumulasiPrev">- Rp'.number_format($akumulasiKegiatan).'</div></div>';  
                                 }else{
                                     $akumulasiKegiatan = $data_nota["akumulasi_kegiatan"];
                                 echo '<div id="show_akumulasiprev"><input type="hidden" id="prevAkumulasiKegiatan" value="'.$akumulasiKegiatan.'"/> <div class="number count-to" style="padding-right: 10px;background: transparent;border:none;color: #000;width: 250px" id="nilaiAkumulasiPrev">Rp'.number_format($akumulasiKegiatan).'</div></div>';  
                                 }
                                ?>
                                
                                <!-- <input  value="" readonly /> -->
                            </div>
                            </div>
                            <!-- #END Akumulasi -->
                            
                            <ul class="header-dropdown m-r--5">
                                <!-- <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Catat Kerusakan</a></li>
                                    </ul>
                                </li> -->
                            </ul>
                        </div>
                        <div class="body">
                        <form action="?page=editaksi" method="post">
                        <div class="body">
                            <!--Nomor Nota-->
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                <h2 class="card-inside-title">No. Nota</h2>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="idnotanew" value="<?php echo $data_nota['id_nota']; ?>"/>
                                            <input type="hidden" class="form-control" name="idnotaold" value="<?php echo $data_nota['id_nota']; ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--#END Nomor Nota-->
                            
                            <!--Tanggal-->
                            <div class="row clearfix">
                                <div class="col-xs-6">
                                    <h2 class="card-inside-title">Tanggal Nota</h2>
                                    <div class="input-group date" id="bs_datepicker_container">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Pilih tanggal..." value="<?php echo date('m/d/Y', strtotime($data_nota['tanggal_nota'])) ?>" name="tanggalnota">
                                        </div>
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!--#End Tanggal-->
                            
                            <!--Jenis-->
                            <div class="row clearfix" style="margin-bottom: 25px">
                                <div class="col-sm-6">
                                <h2 class="card-inside-title">Jenis Transaksi</h2>
                                    <select class="form-control show-tick" name="jenis">
                                        <option value="Tunai" <?php if($data_nota['jenis_nota']=="Tunai"){echo "SELECTED";} ?> >Tunai</option>
                                        <option value="Transfer" <?php if($data_nota['jenis_nota']=="Transfer"){echo "SELECTED";} ?> >Transfer</option>
                                        <option value="Lainnya" <?php if($data_nota['jenis_nota']=="Lainnya"){echo "SELECTED";} ?> >Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <!--#END Jenis-->
                            <div class="row clearfix" style="margin-bottom: 25px">
                                <div class="col-sm-6">
                                <h2 class="card-inside-title">Kegiatan / Uraian</h2>
                                <div class="form-line">
                                <script type="text/javascript">
                                
                                </script>
                                    <input type="text" id="inKegiatan" class="form-control" name="kegiatan" onchange="akumulasiPrev()" list="ket-kegiatan" value="<?php echo $data_nota['nama_kegiatan'] ?>" />
                                    <datalist id="ket-kegiatan">
                                    <?php
                                    $statListKegiatan=mysqli_query($l, "SELECT * FROM kegiatan ORDER BY id_kegiatan DESC") OR die(mysql_error($l));
                                    while ($dataListKegiatan=mysqli_fetch_array($statListKegiatan)) {
                                    
                                    ?>
                                        <option value="<?php echo $dataListKegiatan['nama_kegiatan'] ?>" ><?php echo $dataListKegiatan['nama_kegiatan'] ?></option>
                                    <?php } ?>
                                    </datalist>
                                </div>
                            </div>
                            </div>
                            
                            <!--Jumlah penerimaan-->
                            <div class="row clearfix">
                            <div class="col-sm-12" style="margin-bottom: 0">
                                <h2 class="card-inside-title">Penerimaan / Realisasi</h2>
                            </div>
                            <?php
                            $cek_penerimaan =mysqli_num_rows(mysqli_query($l, "SELECT * FROM penerimaan WHERE id_nota=".$_GET['idx']));
                            if ($cek_penerimaan > 0) {
                            $noPenerimaan=1;
                            $stat_penerimaan = mysqli_query($l, "SELECT * FROM penerimaan WHERE id_nota=".$_GET['idx']." ORDER BY tanggal_penerimaan ASC");
                            while ($data_penerimaan=mysqli_fetch_array($stat_penerimaan)) {
                            ?>
                            <div class="col-sm-12" style="margin-bottom: 0">
                                <div class="col-sm-4" style="margin-bottom: 0">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Rp
                                        </span>
                                        <div class="form-line">
                                        <!-- $( this ).mask('0.000.000.000', {reverse: true});$(document).on('keyup', '.inputPengeluaran', function() {var sumIP1 = 0; $('.inputPengeluaran').each(function(){sumIP1 += +$(this).val(); }); $('.Tsum1').val(sumIP1);document.getElementById('ketSumIP1').value = formatRupiah(this.value , 'Rp. '); }); -->
                                        <input type="hidden" id="<?php echo "prevInPenerimaan_".$noPenerimaan; ?>"  value="<?php echo number_format($data_penerimaan['count_penerimaan'],0,"",".") ?>" />
                                        <input type="text" class="form-control inputPengeluaran" onkeyup="$( this ).mask('0.000.000.000.000', {reverse: true});allSum()" name="<?php echo "editCountPenerimaan_".$noPenerimaan; ?>" id="<?php echo "editInPenerimaan_".$noPenerimaan; ?>"  value="<?php echo number_format($data_penerimaan['count_penerimaan'],0,"",".") ?>" />
                                        
                                        <input type="hidden" name="<?php echo "editIdPenerimaan_".$noPenerimaan; ?>" value="<?php echo $data_penerimaan['id_penerimaan'] ?>" />
                                        
                                            <!-- <p value="<?php if(isset($kelebihanSaldo)){echo $kelebihanSaldo;} ?>"> -->
                                        </div>
                                        <label>Jumlah Penerimaan</label>
                                    </div>
                                </div>
                                <div class="col-sm-4" style="margin-bottom: 0">
                                    <div class="input-group date" id="bs_datepicker_container">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Pilih tanggal Penerimaan..." value="<?php echo date('m/d/Y', strtotime($data_penerimaan['tanggal_penerimaan'])) ?>" name="<?php echo "editTanggalPenerimaan_".$noPenerimaan; ?>">
                                        </div>
                                        <label>Tanggal Penerimaan</label>
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4" style="margin-bottom: 0">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-tasks"></i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="<?php echo "editKetPenerimaan_".$noPenerimaan; ?>" list="ket-penerimaan-edit" value="<?php echo $data_penerimaan['ket_penerimaan'] ?>" />
                                            <datalist id="ket-penerimaan-edit">
                                            <?php
                                            $stat_ket_penerimaan_edit = mysqli_query($l, "SELECT * FROM ket_penerimaan");
                                            while ($data_ket_penerimaan_edit = mysqli_fetch_array($stat_ket_penerimaan_edit)) {
                                                ?>
                                                <option value='<?php echo $data_ket_penerimaan_edit['ket_penerimaan'] ?>' ><?php echo $data_ket_penerimaan_edit['ket_penerimaan'] ?></option>
                                                <?php
                                            }
                                            ?>
                                            </datalist>
                                        </div>
                                        <label>Keterangan Penerimaan</label>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $noPenerimaan++;}
                            }
                            ?>
                            
                            <?php
                            for ($x = 1; $x <= $jumlahFormPP; $x++) {
                            ?>
                            <div class="col-sm-12" style="margin-bottom: 0">
                                <div class="col-sm-4" style="margin-bottom: 0">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Rp
                                        </span>
                                        <div class="form-line">
                                        <!-- var inPenerimaan = this.value; var toTsum2 = inPenerimaan.replace(/0.0/g, '00'); $(document).on('keyup', '.inputPenerimaan', function() {var sumIP2 = 0; $('.inputPenerimaan').each(function(){sumIP2 += +$(this).val(); }); $('.Tsum2').val(sumIP2);document.getElementById('ketSumIP2').value = formatRupiah(this.value , 'Rp. '); });angka(this) -->
                                         
                                        <input type="text" class="form-control inputPenerimaan" onkeyup="$( this ).mask('0.000.000.000.000', {reverse: true});allSum()" name="<?php echo "countPenerimaan_".$x; ?>" id="<?php echo "inPenerimaan_".$x; ?>" />
                                        </div>
                                        
                                        
                                        <label>Jumlah Penerimaan</label>
                                    </div>
                                </div>
                                <div class="col-sm-4" style="margin-bottom: 0">
                                    <div class="input-group date" id="bs_datepicker_container">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Pilih tanggal Penerimaan..." value="<?php echo date('m/d/Y') ?>" name="<?php echo "tanggalPenerimaan_".$x; ?>">
                                        </div>
                                        <label>Tanggal Penerimaan</label>
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4" style="margin-bottom: 0">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-tasks"></i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="<?php echo "ketPenerimaan_".$x; ?>" list="ket-penerimaan" />
                                            <datalist id="ket-penerimaan">
                                            <?php
                                            $stat_ket_penerimaan = mysqli_query($l, "SELECT * FROM ket_penerimaan");
                                            while ($data_ket_penerimaan = mysqli_fetch_array($stat_ket_penerimaan)) {
                                                ?>
                                                <option value='<?php echo $data_ket_penerimaan['ket_penerimaan'] ?>' ><?php echo $data_ket_penerimaan['ket_penerimaan'] ?></option>
                                                <?php
                                            }
                                            ?>
                                            </datalist>
                                        </div>
                                        <label>Keterangan Penerimaan</label>
                                    </div>
                                </div>
                                </div>
                                <?php } ?>
                                
                            </div>
                            <!--#END Jumlah Penerimaan-->
                            
                            <!--Jumlah Pengeluaran-->
                            <div class="row clearfix" style="margin-bottom: 30px">
                            <div class="col-sm-12" style="margin-bottom: 0">
                                <h2 class="card-inside-title">Pengeluaran / SPJ</h2>
                            </div>
                            <?php
                            $cek_pengeluaran =mysqli_num_rows(mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_nota=".$_GET['idx']));
                            if ($cek_pengeluaran > 0) {
                            $noPengeluaran=1;
                            $stat_pengeluaran = mysqli_query($l, "SELECT * FROM pengeluaran WHERE id_nota=".$_GET['idx']." ORDER BY tanggal_pengeluaran ASC");
                            while ($data_pengeluaran=mysqli_fetch_array($stat_pengeluaran)) {
                            ?>
                            <div class="col-sm-12" style="margin-bottom: 0">
                                <div class="col-sm-4" style="margin-bottom: 0">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Rp
                                        </span>
                                        <div class="form-line">
                                        <!-- $( this ).mask('0.000.000.000', {reverse: true});$(document).on('keyup', '.inputPengeluaran', function() {var sumIP1 = 0; $('.inputPengeluaran').each(function(){sumIP1 += +$(this).val(); }); $('.Tsum1').val(sumIP1);document.getElementById('ketSumIP1').value = formatRupiah(this.value , 'Rp. '); }); -->
                                        <input type="hidden" id="<?php echo "prevInPengeluaran_".$noPengeluaran; ?>"  value="<?php echo number_format($data_pengeluaran['count_pengeluaran'],0,"",".") ?>" />
                                        
                                        <input type="text" class="form-control inputPengeluaran" onkeyup="$( this ).mask('0.000.000.000.000', {reverse: true});allSum()" name="<?php echo "editCountPengeluaran_".$noPengeluaran; ?>" id="<?php echo "editInPengeluaran_".$noPengeluaran; ?>"  value="<?php echo number_format($data_pengeluaran['count_pengeluaran'],0,"",".") ?>" />
                                        
                                        <input type="hidden" name="<?php echo "editIdPengeluaran_".$noPengeluaran; ?>" value="<?php echo $data_pengeluaran['id_pengeluaran'] ?>" />
                                        
                                            <!-- <p value="<?php if(isset($kelebihanSaldo)){echo $kelebihanSaldo;} ?>"> -->
                                        </div>
                                        <label>Jumlah Pengeluaran</label>
                                    </div>
                                </div>
                                <div class="col-sm-4" style="margin-bottom: 0">
                                    <div class="input-group date" id="bs_datepicker_container">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Pilih tanggal Pengeluaran/permintaan..." value="<?php echo date('m/d/Y', strtotime($data_pengeluaran['tanggal_pengeluaran'])) ?>" name="<?php echo "editTanggalPengeluaran_".$noPengeluaran; ?>">
                                        </div>
                                        <label>Tanggal Pengeluaran</label>
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4" style="margin-bottom: 0">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-tasks"></i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="<?php echo "editKetPengeluaran_".$noPengeluaran; ?>" list="ket-pengeluaran-edit" value="<?php echo $data_pengeluaran['ket_pengeluaran'] ?>" />
                                            <datalist id="ket-pengeluaran-edit">
                                            <?php
                                            $stat_ket_pengeluaran_edit = mysqli_query($l, "SELECT * FROM ket_pengeluaran");
                                            while ($data_ket_pengeluaran_edit = mysqli_fetch_array($stat_ket_pengeluaran_edit)) {
                                                ?>
                                                <option value='<?php echo $data_ket_pengeluaran_edit['ket_pengeluaran'] ?>' ><?php echo $data_ket_pengeluaran_edit['ket_pengeluaran'] ?></option>
                                                <?php
                                            }
                                            ?>
                                            </datalist>
                                        </div>
                                        <label>Keterangan Pengeluaran</label>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $noPengeluaran++;}
                            }
                            ?>
                            
                            <?php
                            for ($x = 1; $x <= $jumlahFormPP; $x++) {
                            ?>
                            <div class="col-sm-12" style="margin-bottom: 0">
                                <div class="col-sm-4" style="margin-bottom: 0">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Rp
                                        </span>
                                        <div class="form-line">
                                        <!-- $( this ).mask('0.000.000.000', {reverse: true});$(document).on('keyup', '.inputPengeluaran', function() {var sumIP1 = 0; $('.inputPengeluaran').each(function(){sumIP1 += +$(this).val(); }); $('.Tsum1').val(sumIP1);document.getElementById('ketSumIP1').value = formatRupiah(this.value , 'Rp. '); }); -->
                                        <input type="text" class="form-control inputPengeluaran" onkeyup="$( this ).mask('0.000.000.000.000', {reverse: true});allSum()" name="<?php echo "countPengeluaran_".$x; ?>" id="<?php echo "inPengeluaran_".$x; ?>"  />
                                            <!-- <p value="<?php if(isset($kelebihanSaldo)){echo $kelebihanSaldo;} ?>"> -->
                                        </div>
                                        <label>Jumlah Pengeluaran</label>
                                    </div>
                                </div>
                                <div class="col-sm-4" style="margin-bottom: 0">
                                    <div class="input-group date" id="bs_datepicker_container">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Pilih tanggal Pengeluaran/permintaan..." value="<?php echo date('m/d/Y') ?>" name="<?php echo "tanggalPengeluaran_".$x; ?>">
                                        </div>
                                        <label>Tanggal Pengeluaran</label>
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4" style="margin-bottom: 0">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-tasks"></i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="<?php echo "ketPengeluaran_".$x; ?>" list="ket-pengeluaran" />
                                            <datalist id="ket-pengeluaran">
                                            <?php
                                            $stat_ket_pengeluaran = mysqli_query($l, "SELECT * FROM ket_pengeluaran");
                                            while ($data_ket_pengeluaran = mysqli_fetch_array($stat_ket_pengeluaran)) {
                                                ?>
                                                <option value='<?php echo $data_ket_pengeluaran['ket_pengeluaran'] ?>' ><?php echo $data_ket_pengeluaran['ket_pengeluaran'] ?></option>
                                                <?php
                                            }
                                            ?>
                                            </datalist>
                                        </div>
                                        <label>Keterangan Pengeluaran</label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                                

                            </div>
                            <!--#END Jumlah Pengeluaran-->
                            
                            <!--Jumlah Pelunasan-->
                            <div class="row clearfix" style="margin-bottom: 30px">
                            <div class="col-sm-12" style="margin-bottom: 0">
                                <h2 class="card-inside-title">Pelunasan (Realisasi)</h2>
                            </div>
                            <div class="col-sm-12" style="margin-bottom: 0">
                                <div class="col-sm-6" style="margin-bottom: 0">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Rp
                                        </span>
                                        <div class="form-line">                                         
                                        <input type="text" class="form-control" onkeyup="$( this ).mask('0.000.000.000', {reverse: true});allSum()" onchange="" id="pelunasan" name="countPelunasan" />
                                        </div>
                                        <label>Jumlah Penerimaan</label>
                                    </div>
                                </div>
                                <div class="col-sm-6" style="margin-bottom: 0">
                                    <div class="input-group date" id="bs_datepicker_container">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Pilih tanggal Pelunasan..." value="<?php echo date('m/d/Y') ?>" name="tanggalPelunasan">
                                        </div>
                                        <label>Tanggal Pelunasan</label>
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!--#END Jumlah Pelunasan-->
                            
                            <!--Akumulasi-->
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                <h2 class="card-inside-title">Akumulasi (Saldo per Nota)</h2>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            Rp
                                        </span>
                                        <div class="form-line">
                                            <?php
                                         if ($data_nota["akumulasi_nota"] < 0) {
                                             $akumulasiNota = $data_nota["akumulasi_nota"] * -1;
                                         echo '<input type="text" class="form-control" id="akumulasiNota" onkeyup="" value="- '. number_format($akumulasiNota,0,"",".").'" readonly />';  
                                         }else{
                                             $akumulasiNota = $data_nota["akumulasi_nota"];
                                         echo '<input type="text" class="form-control" id="akumulasiNota" onkeyup="" value="'. number_format($akumulasiNota,0,"",".").'" readonly />';  
                                         }
                                        ?>
                                            <input type="hidden" name="inakumulasi" id="inakumulasi" value="<?php echo $data_nota['akumulasi_nota']; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                <h2 class="card-inside-title">Akumulasi (Saldo per Kegiatan)</h2>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            Rp
                                        </span>
                                        <div class="form-line">
                                        <?php
                                         if ($data_nota["akumulasi_kegiatan"] < 0) {
                                             $akumulasiKegiatan = $data_nota["akumulasi_kegiatan"] * -1;
                                         echo '<input type="text" class="form-control" id="akumulasi" onkeyup="" value="- '. number_format($akumulasiKegiatan,0,"",".").'" readonly />';  
                                         }else{
                                             $akumulasiKegiatan = $data_nota["akumulasi_kegiatan"];
                                         echo '<input type="text" class="form-control" id="akumulasi" onkeyup="" value="'. number_format($akumulasiKegiatan,0,"",".").'" readonly />';  
                                         }
                                        ?>
                                            
                                            <input type="hidden" name="inakumulasikegiatan" id="inakumulasikegiatan" value="<?php echo $data_nota['akumulasi_kegiatan']; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--#END Akumulasi-->

                            <script type="text/javascript">
                            function allSum() {
                                // Pengeluaran
                                <?php
                                if ($cek_jumlahEditPengeluaran > 0){
                                for ($x = 1; $x <= $jumlahEditPengeluaran['jumlah_pengeluaran']; $x++) {
                                ?>
                                var <?php echo "editInPengeluaran".$x; ?> = $('#editInPengeluaran_<?php echo $x; ?>').val().split('.').join('');
                                <?php
                                }
                                ?>
                                var totalPengeluaran_1= <?php for ($x = 1; $x <= $jumlahEditPengeluaran['jumlah_pengeluaran']; $x++) { ?>parseInt(<?php echo "editInPengeluaran".$x; ?>) + <?php } ?> 0;
                                
                                <?php
                                //prev Pengeluaran
                                for ($x = 1; $x <= $jumlahEditPengeluaran['jumlah_pengeluaran']; $x++) {
                                ?>
                                var <?php echo "prevInPengeluaran".$x; ?> = $('#prevInPengeluaran_<?php echo $x; ?>').val().split('.').join('');
                                <?php
                                }
                                ?>
                                var totalPengeluaran_1a= <?php for ($x = 1; $x <= $jumlahEditPengeluaran['jumlah_pengeluaran']; $x++) { ?>parseInt(<?php echo "prevInPengeluaran".$x; ?>) + <?php } ?> 0;
                                <?php
                                }
                                ?>
                                
                                var inPengeluaran1 = $('#inPengeluaran_1').val().split('.').join('');
                                var inPengeluaran2 = $('#inPengeluaran_2').val().split('.').join('');
                                if (inPengeluaran1 == "") {inPengeluaran1 = 0} else {$('#inPengeluaran_1').val().split('.').join('');}
                                if (inPengeluaran2 == "") {inPengeluaran2 = 0} else {$('#inPengeluaran_2').val().split('.').join('');}
                                var totalPengeluaran_2 = parseInt(inPengeluaran1) + parseInt(inPengeluaran2);
                                
                                <?php
                                if ($cek_jumlahEditPengeluaran > 0){
                                ?>
                                var totalPengeluaran_all = parseInt(totalPengeluaran_1) + parseInt(totalPengeluaran_2);
                                <?php
                                }else{
                                   ?>
                                var totalPengeluaran_all = totalPengeluaran_2;
                                <?php
                                }
                                ?>
                                
                                // Penerimaan
                                <?php
                                if ($cek_jumlahEditPenerimaan > 0){
                                for ($x = 1; $x <= $jumlahEditPenerimaan['jumlah_penerimaan']; $x++) {
                                ?>
                                var <?php echo "editInPenerimaan".$x; ?> = $('#editInPenerimaan_<?php echo $x; ?>').val().split('.').join('');
                                <?php
                                }
                                ?>
                                var totalPenerimaan_1= <?php for ($x = 1; $x <= $jumlahEditPenerimaan['jumlah_penerimaan']; $x++) { ?>parseInt(<?php echo "editInPenerimaan".$x; ?>) + <?php } ?> 0;
                                
                                <?php
                                //prev Pengeluaran
                                for ($x = 1; $x <= $jumlahEditPenerimaan['jumlah_penerimaan']; $x++) {
                                ?>
                                var <?php echo "prevInPenerimaan".$x; ?> = $('#prevInPenerimaan_<?php echo $x; ?>').val().split('.').join('');
                                <?php
                                }
                                ?>
                                var totalPenerimaan_1a= <?php for ($x = 1; $x <= $jumlahEditPenerimaan['jumlah_penerimaan']; $x++) { ?>parseInt(<?php echo "prevInPenerimaan".$x; ?>) + <?php } ?> 0;
                                <?php
                                }
                                ?>
                                
                                var inPelunasan = $('#pelunasan').val().split('.').join('');
                                var inPenerimaan1 = $('#inPenerimaan_1').val().split('.').join('');
                                var inPenerimaan2 = $('#inPenerimaan_2').val().split('.').join('');
                                if (inPelunasan == "") {inPelunasan = 0} else {$('#pelunasan').val().split('.').join('');}
                                if (inPenerimaan1 == "") {inPenerimaan1 = 0} else {$('#inPenerimaan_1').val().split('.').join('');}
                                if (inPenerimaan2 == "") {inPenerimaan2 = 0} else {$('#inPenerimaan_2').val().split('.').join('');}
                                var totalPenerimaan_2 = parseInt(inPenerimaan1) + parseInt(inPenerimaan2) + parseInt(inPelunasan);
                                
                                <?php
                                if ($cek_jumlahEditPenerimaan > 0){
                                ?>
                                var totalPenerimaan_all = parseInt(totalPenerimaan_1) + parseInt(totalPenerimaan_2);
                                <?php
                                }else{
                                   ?>
                                var totalPenerimaan_all = totalPenerimaan_2;
                                <?php
                                }
                                ?>
                                // +kurang2 +result_1+kurang2 +result_2+kurang2 +result_3
                                
                                var prevAkumulasiKegiatan = $('#prevAkumulasiKegiatan').val();
                                
                                var selisihPenerimaan = parseInt(totalPenerimaan_1a) - parseInt(totalPenerimaan_1);
                                var selisihPengeluaran = parseInt(totalPengeluaran_1a) - parseInt(totalPengeluaran_1);
                                
                                var totalNewIn = parseInt(totalPenerimaan_2) - parseInt(totalPengeluaran_2);
                                
                                var result = parseInt(totalPenerimaan_all) - parseInt(totalPengeluaran_all);
                                var resultfix = parseInt(prevAkumulasiKegiatan) - parseInt(selisihPenerimaan) + parseInt(selisihPengeluaran) + parseInt(totalNewIn);
                                var kurang = "";
                                var kurang2 = "";
                                var testN = parseFloat(resultfix);
                                if (testN < 0) {kurang = "- "}
                                var testN2 = parseFloat(result);
                                if (testN2 < 0) {kurang2 = "- "}
                                document.getElementById('akumulasi').value =kurang + formatRupiah('"'+resultfix+'"');
                                document.getElementById('akumulasiNota').value =kurang2 + formatRupiah('"'+result+'"');
                                document.getElementById('inakumulasi').value = result;
                                document.getElementById('inakumulasikegiatan').value =resultfix;

                            }
                            
                            </script>
                            
                            <div class="row clearfix js-sweetalert">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <button class="btn btn-block btn-danger waves-effect" style="font-size: 20px" type="submit">Save Nota</button>
                                </div>
                            </div>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic -->
             <script>  
            function akumulasiPrev(){
                    var namaKegiatan = $('#inKegiatan').val();  
                       $.ajax({  
                            url:"load_akumulasi.php",  
                            method:"POST",  
                            data:{namaKegiatan:namaKegiatan},  
                            success:function(data){  
                                 $('#show_akumulasiprev').html(data);  
                            }  
                       });  
            }
             </script>
        </div>
<script type="text/javascript">
    function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split           = number_string.split(','),
    sisa            = split[0].length % 3,
    rupiah          = split[0].substr(0, sisa),
    ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
</script>
<script>
function addFormPenerimaan(){
    function appendNCopies(n, original, appendTo) {
    for(var i = 0; i < n; i++) {
    var clone = original.cloneNode(true);
    appendTo.appendChild(clone);
    }
    }    
    var formPenerimaan = document.getElementById("formPenerimaan");
    var appendForm2 = document.getElementById("appendFormPenerimaan");
    appendNCopies(1, formPenerimaan, appendForm2);
}
</script>