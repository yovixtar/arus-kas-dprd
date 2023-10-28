<!-- Setting Form -->
<?php
$jumlahFormPP = 4;
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
                                <div id="show_akumulasiprev"></div>
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
                        <form action="?page=tambahaksi" method="post">
                        <div class="body">
                            <!--Nomor Nota-->
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                <?php
                                $statnonota=mysqli_query($l,"SELECT * FROM nota ORDER BY id_nota DESC LIMIT 1");
                                $datanonota=mysqli_fetch_array($statnonota);
                                ?>
                                <h2 class="card-inside-title">No. Nota</h2>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="idnota" value="<?php echo $datanonota['id_nota']+1; ?>"/>
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
                                            <input type="text" class="form-control" placeholder="Pilih tanggal..." value="<?php echo date('m/d/Y') ?>" name="tanggalnota">
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
                                        <option value="Tunai">Tunai</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Lainnya">Lainnya</option>
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
                                    <input type="text" id="inKegiatan" class="form-control" name="kegiatan" onchange="akumulasiPrev()" list="ket-kegiatan" />
                                    <datalist id="ket-kegiatan">
                                    <?php
                                    $statListKegiatan=mysqli_query($l, "SELECT * FROM kegiatan ORDER BY id_kegiatan DESC") OR die(mysql_error($l));
                                    while ($dataListKegiatan=mysqli_fetch_array($statListKegiatan)) {
                                    
                                    ?>
                                        <option value='<?php echo $dataListKegiatan['nama_kegiatan'] ?>'><?php echo $dataListKegiatan['nama_kegiatan'] ?></option>
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
                                         
                                        <input type="text" class="form-control inputPenerimaan" onkeyup="$( this ).mask('0.000.000.000', {reverse: true});allSum()" onchange="" name="<?php echo "countPenerimaan_".$x; ?>" id="<?php echo "inPenerimaan_".$x; ?>" />
                                        </div>
                                        
                                        
                                        <label>Jumlah Penerimaan</label>
                                    </div>
                                </div>
                                <div class="col-sm-4" style="margin-bottom: 0">
                                    <div class="input-group date" id="bs_datepicker_container">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Pilih tanggal Penerimaan..." value="<?php echo date('m/d/Y') ?>" name="<?php echo "tanggalPenerimaan_".$x; ?>">
                                        </div>
                                        <label>tanggal Penerimaan</label>
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
                                        <input type="text" class="form-control inputPengeluaran" onkeyup="$( this ).mask('0.000.000.000', {reverse: true});allSum()" onchange="allSum()" name="<?php echo "countPengeluaran_".$x; ?>" id="<?php echo "inPengeluaran_".$x; ?>"  />
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
                                        <label>tanggal Pengeluaran</label>
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
                                        <input type="text" class="form-control inputPenerimaan" onkeyup="$( this ).mask('0.000.000.000', {reverse: true});allSum()" onchange="" name="countPelunasan" id="pelunasan"/>
                                        </div>
                                        <label>Jumlah Pelunasan</label>
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
                                            <input type="text" class="form-control" id="akumulasiNota" onkeyup="" value="" readonly />
                                            <input type="hidden" name="inakumulasi" id="inakumulasi" />
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
                                            <input type="text" class="form-control" id="akumulasi" onkeyup="" value="" readonly />
                                            <input type="hidden" name="inakumulasikegiatan" id="inakumulasikegiatan" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--#END Akumulasi-->

                            <script type="text/javascript">
                            function allSum() {
                                var inPengeluaran1 = $('#inPengeluaran_1').val().split('.').join('');
                                var inPengeluaran2 = $('#inPengeluaran_2').val().split('.').join('');
                                var inPengeluaran3 = $('#inPengeluaran_3').val().split('.').join('');
                                var inPengeluaran4 = $('#inPengeluaran_4').val().split('.').join('');
                                if (inPengeluaran1 == "") {inPengeluaran1 = 0} else {$('#inPengeluaran_1').val().split('.').join('');}
                                if (inPengeluaran2 == "") {inPengeluaran2 = 0} else {$('#inPengeluaran_2').val().split('.').join('');}
                                if (inPengeluaran3 == "") {inPengeluaran3 = 0} else {$('#inPengeluaran_3').val().split('.').join('');}
                                if (inPengeluaran4 == "") {inPengeluaran4 = 0} else {$('#inPengeluaran_4').val().split('.').join('');}
                                var totalPengeluaran = parseInt(inPengeluaran1) + parseInt(inPengeluaran2) + parseInt(inPengeluaran3) + parseInt(inPengeluaran4);
                                
                                var inPelunasan = $('#pelunasan').val().split('.').join('');
                                var inPenerimaan1 = $('#inPenerimaan_1').val().split('.').join('');
                                var inPenerimaan2 = $('#inPenerimaan_2').val().split('.').join('');
                                var inPenerimaan3 = $('#inPenerimaan_3').val().split('.').join('');
                                var inPenerimaan4 = $('#inPenerimaan_4').val().split('.').join('');
                                if (inPelunasan == "") {inPelunasan = 0} else {$('#pelunasan').val().split('.').join('');}
                                if (inPenerimaan1 == "") {inPenerimaan1 = 0} else {$('#inPenerimaan_1').val().split('.').join('');}
                                if (inPenerimaan2 == "") {inPenerimaan2 = 0} else {$('#inPenerimaan_2').val().split('.').join('');}
                                if (inPenerimaan3 == "") {inPenerimaan3 = 0} else {$('#inPenerimaan_3').val().split('.').join('');}
                                if (inPenerimaan4 == "") {inPenerimaan4 = 0} else {$('#inPenerimaan_4').val().split('.').join('');}
                                var totalPenerimaan = parseInt(inPenerimaan1) + parseInt(inPenerimaan2) + parseInt(inPenerimaan3) + parseInt(inPenerimaan4) + parseInt(inPelunasan);
                                
                                var prevAkumulasiKegiatan = $('#prevAkumulasiKegiatan').val();
                                var result = parseInt(totalPenerimaan) - parseInt(totalPengeluaran);
                                var resultfix = parseInt(prevAkumulasiKegiatan) + parseInt(result);
                                var kurang = "";
                                var testN = parseFloat(resultfix);
                                if (testN < 0) {kurang = "- "}
                                document.getElementById('akumulasi').value =kurang + formatRupiah('"'+resultfix+'"');
                                document.getElementById('akumulasiNota').value =kurang + formatRupiah('"'+result+'"');
                                document.getElementById('inakumulasi').value =result;
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