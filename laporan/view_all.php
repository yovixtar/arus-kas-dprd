<div class="container-fluid">
    <!-- Basic Examples -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Lihat Semua Laporan
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
                <a href="print.php?all" target="BLANK"><button type="button" class="btn bg-indigo waves-effect">Lihat Laporan</button></a>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Basic -->
    
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Lihat Laporan Per Tanggal
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
                <form action="print.php?mode=pertanggal" method="POST" target="BLANK">
                    <div class="input-daterange input-group" id="bs_datepicker_range_container">
                        <div class="form-line">
                            <input type="text" class="form-control" name="date_start" placeholder="Tanggal Awal...">
                        </div>
                        <span class="input-group-addon">to</span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="date_end" placeholder="Tanggal Akhir...">
                        </div>
                    </div>
                    <button type="submit" class="btn bg-indigo waves-effect">Lihat Laporan</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    
        <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Lihat Laporan Per Nota
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
                <form action="print.php" method="GET" target="BLANK">
                <input type="hidden" name="mode" value="pernota">
                    <div class="col-sm-6">
                        <select class="form-control show-tick" name="idx">
                            <option value="">-- Please select --</option>
                            <?php
                            $stat=mysqli_query($l, "SELECT * FROM nota n JOIN kegiatan k ON n.id_kegiatan=k.id_kegiatan ORDER BY id_nota ASC") OR die(mysql_error($l));
                            while ($data=mysqli_fetch_array($stat)) {
                            
                            ?>
                            <option value="<?php echo $data['id_nota'] ?>"><?php echo $data['id_nota'].'. '.$data['nama_kegiatan'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn bg-indigo waves-effect">Lihat Laporan</button>
                </form>
                </div>
            </div>
        </div>
    </div>

</div>