<div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Daftar Kegiatan
                            </h2>
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
                            <div class="table-responsive">
                                <div class="row clearfix">
                                <!-- Saldo All -->
    <!--                                 <div class="col-lg-5 col-md-5 col-sm-8 col-xs-12 right" style="margin-bottom: 0">
                                        <div class="info-box bg-orange hover-expand-effect" style="margin-bottom: 0">
                                            <div class="icon">
                                                <i class="material-icons">attach_money</i>
                                            </div>
                                            <div class="content">
                                            <?php
                                            $statSaldo=mysqli_query($l, "SELECT * FROM saldo ORDER BY id_saldo DESC LIMIT 1") OR die(mysql_error($l));
                                            while ($dataSaldo=mysqli_fetch_array($statSaldo)){
                                            $countSaldo=$dataSaldo['count_saldo'];
                                            if ($dataSaldo['count_saldo']<0) {
                                                $countSaldo=$dataSaldo['count_saldo']*-1;
                                            }
                                            ?>
                                                <div class="text">Saldo di PPTK</div>
                                                <div class="number count-to" style="padding-right: 10px " data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"><?php if($dataSaldo['count_saldo']<0){echo "( - ) ";} ?>Rp<?php echo number_format($countSaldo,0) ?></div>
                                            <?php } ?>
                                            </div>
                                        </div>
                                    </div> -->
                                <div class="col-lg-5 col-md-5 col-sm-4 col-xs-12">
                                    <a href="?page=tambahnota"><button class="btn btn-primary waves-effect" style="margin-top: 20px"><i class="material-icons" style="font-size: 17px;" title="Tambah Nota">add</i> Tambah Nota</button></a>
                                </div>
                                </div>
                                <br /> <br />
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <td style="display: none">No.</td>
                                            <th>Nomor Nota</th>
                                            <th>Kegiatan</th>
                                            <th>Tanggal</th>
                                            <th>Total Penerimaan</th>
                                            <th>Total Pengeluaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <!-- <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </tfoot> -->
                                    <tbody>
                                    <?php
                                    $no = 1;
                                    $stat=mysqli_query($l, "SELECT * FROM nota n JOIN kegiatan k ON n.id_kegiatan=k.id_kegiatan ORDER BY id_nota DESC") OR die(mysql_error($l));
                                    while ($data=mysqli_fetch_array($stat)) {
                                    
                                    ?>
                                        <tr>
                                            <td style="display: none"><?php echo $no; ?></td>
                                            <td><?php echo $data['id_nota'] ?></td>
                                            <td><?php echo $data['nama_kegiatan'] ?></td>
                                            <td><?php echo date_format(date_create($data['tanggal_nota']), "d M Y") ?></td>
                                            <?php
                                            $stat2=mysqli_query($l, "SELECT SUM(count_penerimaan) AS total_penerimaan FROM penerimaan WHERE id_nota=".$data['id_nota']) OR die(mysql_error($l));

                                            while ($data2=mysqli_fetch_array($stat2)) {
                                            
                                            if ($data2['total_penerimaan'] < 0) {
                                                $penerimaanNota = $data2['total_penerimaan'] * -1;
                                            echo "<td> - Rp".number_format($penerimaanNota,0)."</td>";
                                            }else{
                                                $penerimaanNota = $data2['total_penerimaan'];
                                            echo "<td> Rp".number_format($penerimaanNota,0)."</td>";
                                            }
                                            
                                            }
                                            
                                            $stat3=mysqli_query($l, "SELECT SUM(count_pengeluaran) AS total_pengeluaran FROM pengeluaran WHERE id_nota=".$data['id_nota']) OR die(mysql_error($l));
                                            while ($data3=mysqli_fetch_array($stat3)) {
                                            
                                            
                                            if ($data3['total_pengeluaran'] < 0) {
                                                $pengeluaranNota = $data3['total_pengeluaran'] * -1;
                                            echo "<td> - Rp".number_format($pengeluaranNota,0)."</td>";
                                            }else{
                                                $pengeluaranNota = $data3['total_pengeluaran'];
                                            echo "<td> Rp".number_format($pengeluaranNota,0)."</td>";
                                            }
                                            
                                            }
                                            
                                            if ($data['pelunasan_nota'] > 0) {
                                                echo "<td style='color:#f00;font-size:16px'>Nota Lunas</td>";
                                            }else{
                                            ?>
                                            <td>
                                            <a href="?page=editnota&idx=<?php echo $data['id_nota'] ?>"><button class="btn bg-teal waves-effect" title="Edit Kegiatan"><i class="fa fa-pencil"></i></button></a>
                                            <a href="../laporan/print.php?mode=pernota&idx=<?php echo $data['id_nota'] ?>" target="_BLANK"><button class="btn btn-primary waves-effect"><i class="material-icons" style="font-size: 17px" title="Lihat Nota Kegiatan">print</i></button></a>
                                            <button onclick="hapusNota(<?php echo $data['id_nota'] ?>)" class="btn btn-danger waves-effect" title="Hapus Kegiatan"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                            <?php
                                            }
                                            ?>
                                           
                                            
                                        </tr>
                                    <?php $no++; } ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic -->
        </div>