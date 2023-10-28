<div style="">
<div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Daftar Keterangan Penerimaan / Realisasi
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
                        <a onclick="getElementById('tambahPenerimaan').style.display='block'"><button class="btn btn-primary waves-effect"><i class="material-icons" style="font-size: 17px" title="Tambah Penerimaan">add</i> Tambah Penerimaan</button></a>
                            <div id="tambahPenerimaan" style="display: none">
                                <form method="post" class="form-add" action="?page=tambahpenerimaanaksi">
                                <div class="body">
                                    <div class="row clearfix js-sweetalert">
                                        <div class="col-sm-12" style="margin-bottom: 0">
                                        <h2 class="card-inside-title">Keterangan Penerimaan</h2>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="ket_penerimaan"/>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row clearfix js-sweetalert">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <button class="btn btn-primary waves-effect" type="submit">Save Keterangan</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <br /> <br />
                            <div class="table-responsive">
                                
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Keterangan Penerimaan</th>
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
                                    $stat_ket_penerimaan=mysqli_query($l, "SELECT * FROM ket_penerimaan") OR die(mysql_error($l));
                                    while ($data_ket_penerimaan=mysqli_fetch_array($stat_ket_penerimaan)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $data_ket_penerimaan['ket_penerimaan']; ?></td>
                                            <td>
                                            <button onclick="hapusPenerimaan('<?php echo $data_ket_penerimaan['ket_penerimaan'] ?>')" class="btn btn-danger waves-effect" title="Hapus Penerimaan"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                            
                                        </tr>
                                    <?php } ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Daftar Keterangan Pengeluaran / SPJ
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
                        <a onclick="getElementById('tambahPengeluaran').style.display='block'"><button class="btn btn-primary waves-effect"><i class="material-icons" style="font-size: 17px" title="Tambah Pengeluaran">add</i> Tambah Pengeluaran</button></a>
                            <div id="tambahPengeluaran" style="display: none">
                                <form method="post" class="form-add" action="?page=tambahpengeluaranaksi">
                                <div class="body">
                                    <div class="row clearfix js-sweetalert">
                                        <div class="col-sm-12" style="margin-bottom: 0">
                                        <h2 class="card-inside-title">Keterangan Pengeluaran</h2>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="ket_pengeluaran"/>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row clearfix js-sweetalert">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <button class="btn btn-primary waves-effect" type="submit">Save Keterangan</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <br /> <br />
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Keterangan Pengeluaran</th>
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
                                    $stat_ket_pengeluaran=mysqli_query($l, "SELECT * FROM ket_pengeluaran") OR die(mysql_error($l));
                                    while ($data_ket_pengeluaran=mysqli_fetch_array($stat_ket_pengeluaran)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $data_ket_pengeluaran['ket_pengeluaran']; ?></td>
                                            <td>
                                            <button onclick="hapusPengeluaran('<?php echo $data_ket_pengeluaran['ket_pengeluaran'] ?>')" class="btn btn-danger waves-effect" title="Hapus Pengeluaran"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                            
                                        </tr>
                                    <?php } ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic -->
        </div>
</div>