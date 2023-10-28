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
                                <a href="?page=tambahkegiatan"><button class="btn btn-primary waves-effect"><i class="material-icons" style="font-size: 17px" title="Tambah Kegiatan">add</i> Tambah Kegiatan</button></a>
                                <br /> <br />
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Nomor</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Akumulasi Kegiatan</th>
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
                                    $no=1;
                                    $stat=mysqli_query($l, "SELECT * FROM kegiatan ORDER BY id_kegiatan DESC") OR die(mysql_error($l));
                                    while ($data=mysqli_fetch_array($stat)) {
                                    $akumulasiKegiatan = $data['akumulasi_kegiatan'];
                                    
                                    ?>
                                        <tr>
                                            <td><?php echo $no ?></td>
                                            <td><?php echo $data['nama_kegiatan'] ?></td>
                                            <td><?php if ($akumulasiKegiatan < 0) {$akumulasiKegiatan=$data['akumulasi_kegiatan'] * -1;echo "- Rp".number_format($akumulasiKegiatan,0,"","."); }else{echo "Rp".number_format($akumulasiKegiatan,0,"",".");} ?></td>
                                            <td>
                                            <a href="?page=editkegiatan&idx=<?php echo $data['id_kegiatan'] ?>"><button class="btn bg-teal waves-effect" title="Edit Kegiatan"><i class="fa fa-pencil"></i></button></a>
                                            <button onclick="hapusKegiatan(<?php echo $data['id_kegiatan'] ?>)" class="btn btn-danger waves-effect" title="Hapus Kegiatan"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                            
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