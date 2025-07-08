<?php

    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';
    if(empty($_SESSION['USER']))
    {
        echo '<script>alert("Harap login !");window.location="index.php"</script>';
    }
    $id = $_GET['id'];
    $isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();
?>
<br>
<br>
<div class="container">
<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <img src="assets/image/<?php echo $isi['gambar'];?>" class="card-img-top" style="height:200px;">
            <div class="card-body" style="background:#ddd">
            <h5 class="card-title"><?php echo $isi['merk'];?></h5>
            </div>
            <ul class="list-group list-group-flush">

            <?php if($isi['status'] == 'Tersedia'){?>
                <li class="list-group-item bg-primary text-white">
                    <i class="fa fa-check"></i> Available
                </li>
            <?php }else{?>
                <li class="list-group-item bg-danger text-white">
                    <i class="fa fa-close"></i> Not Available
                </li>
            <?php }?>
            <li class="list-group-item bg-info text-white"><i class="fa fa-check"></i> Free E-toll 50k</li>
            <li class="list-group-item bg-dark text-white">
                <i class="fa fa-money"></i> Rp. <?php echo number_format($isi['harga']);?>/ day
            </li>
            </ul>
        </div>
    </div>
    <div class="col-sm-8">
         <div class="card">
           <div class="card-body">
               <form method="post" action="koneksi/proses.php?id=booking" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="">KTP</label>
                      <div class="input-group">
                        <input type="file" name="ktp_file" id="ktp_file" required class="form-control">
                        <div class="input-group-append">
                          <button type="button" id="extract_ocr" class="btn btn-info">Extract OCR</button>
                        </div>
                      </div>
                      <small class="form-text text-muted">Upload gambar KTP Anda.</small>
                    </div> 
                    <div class="form-group">
                      <label for="">NIK</label>
                      <input type="text" name="nik" id="nik" required class="form-control" placeholder="Nomor NIK">
                    </div> 
                    <div class="form-group">
                      <label for="">Nama</label>
                      <input type="text" name="nama" id="nama" required class="form-control" placeholder="Nama Anda">
                    </div> 
                    <div class="form-group">
                      <label for="">Alamat</label>
                      <input type="text" name="alamat" id="alamat" required class="form-control" placeholder="Alamat">
                    </div> 
                    <div class="form-group">
                      <label for="">Telepon</label>
                      <input type="text" name="no_tlp" id="no_tlp" required class="form-control" placeholder="Telepon">
                    </div> 
                    <div class="form-group">
                      <label for="">Tanggal Sewa</label>
                      <input type="date" name="tanggal" id="" required class="form-control" placeholder="Nama Anda">
                    </div> 
                    <div class="form-group">
                      <label for="">Lama Sewa</label>
                      <input type="number" name="lama_sewa" id="" required class="form-control" placeholder="Lama Sewa">
                    </div> 
                    <input type="hidden" value="<?php echo $_SESSION['USER']['id_login'];?>" name="id_login">
                    <input type="hidden" value="<?php echo $isi['id_mobil'];?>" name="id_mobil">
                    <input type="hidden" value="<?php echo $isi['harga'];?>" name="total_harga">
                    <hr/>
                    <?php if($isi['status'] == 'Tersedia'){?>
                        <button type="submit" class="btn btn-primary float-right">Booking Now</button>
                    <?php }else{?>
                        <button type="submit" class="btn btn-danger float-right" disabled>Booking Now</button>
                    <?php }?>
               </form>
           </div>
         </div> 
    </div>
</div>
</div>

<br>

<br>

<br>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('extract_ocr').addEventListener('click', function() {
        const fileInput = document.getElementById('ktp_file');
        
        if (!fileInput.files || fileInput.files.length === 0) {
            alert('Silakan pilih file KTP terlebih dahulu');
            return;
        }
        
        const loadingBtn = this;
        loadingBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
        loadingBtn.disabled = true;
        
        var myHeaders = new Headers();
        myHeaders.append("apikey", "K86256048588957");

        var formdata = new FormData();
        formdata.append("file", fileInput.files[0]);
        formdata.append("language", "eng");
        formdata.append("isOverlayRequired", "true");

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: formdata,
            redirect: 'follow'
        };

        fetch("https://api.ocr.space/Parse/Image", requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                loadingBtn.innerHTML = 'Extract OCR';
                loadingBtn.disabled = false;
                
                if (result.ParsedResults && result.ParsedResults.length > 0) {
                    const extractedText = result.ParsedResults[0].ParsedText;
                    console.log("Extracted text:", extractedText);
                    
                    // Extract NIK (format: ": 3171234567890123")
                    const nikMatch = extractedText.match(/: (\d{16})/);
                    if (nikMatch && nikMatch[1]) {
                        document.getElementById('nik').value = nikMatch[1].trim();
                    }
                    
                    // Extract Name (format: "; MIRA SETIAWAN")
                    const nameMatch = extractedText.match(/; ([A-Z\s]+)/);
                    if (nameMatch && nameMatch[1]) {
                        document.getElementById('nama').value = nameMatch[1].trim();
                    }
                    
                    // Extract address - look for "KALIO" patterns commonly in addresses
                    const addressMatch = extractedText.match(/: ([A-Z]+ERES)/i) || 
                                        extractedText.match(/: (KALI[A-Z]+)/i);
                    if (addressMatch && addressMatch[1]) {
                        document.getElementById('alamat').value = addressMatch[1].trim();
                    }
                    
                    alert('Data extracted successfully!');
                } else {
                    alert('Tidak dapat mengekstrak data dari gambar');
                }
            })
            .catch(error => {
                console.log('error', error);
                alert('Terjadi kesalahan saat mengekstrak data');
                loadingBtn.innerHTML = 'Extract OCR';
                loadingBtn.disabled = false;
            });
    });
});
</script>

<?php include 'footer.php';?>