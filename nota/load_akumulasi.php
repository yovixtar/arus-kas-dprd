 <?php  
 //load_data.php  
include '../base/koneksi.php';
 $output = '';  
 if(isset($_POST["namaKegiatan"]))  
 {  
      if($_POST["namaKegiatan"] != '')  
      {  
           $statfix = mysqli_query($l,"SELECT * FROM kegiatan WHERE nama_kegiatan = '".$_POST["namaKegiatan"]."'");
           if (!$statfix) {
             $output = '<div class="number count-to" style="padding-right: 10px;background: transparent;border:none;color: #f00;width: 300px; font-size:30px" id="nilaiAkumulasiPrev">Tidak ada Akumulasi</div>';
           }else{
           while($datafix = mysqli_fetch_array($statfix))  
          {  
           if ($datafix["akumulasi_kegiatan"] < 0) {
               $akumulasiKegiatanIn = $datafix["akumulasi_kegiatan"];
               $akumulasiKegiatan = $datafix["akumulasi_kegiatan"] * -1;
           $output = '<input type="hidden" id="prevAkumulasiKegiatan" value="'.$akumulasiKegiatanIn.'"/> <div class="number count-to" style="padding-right: 10px;background: transparent;border:none;color: #000;width: 250px" id="nilaiAkumulasiPrev">- Rp'.number_format($akumulasiKegiatan).'</div>';  
           }else{
               $akumulasiKegiatan = $datafix["akumulasi_kegiatan"];
           $output = '<input type="hidden" id="prevAkumulasiKegiatan" value="'.$akumulasiKegiatan.'"/> <div class="number count-to" style="padding-right: 10px;background: transparent;border:none;color: #000;width: 250px" id="nilaiAkumulasiPrev">Rp'.number_format($akumulasiKegiatan).'</div>';  
           }
          } }
      }else{
        
      }  
      
      echo $output;  
 }  
 ?>
 