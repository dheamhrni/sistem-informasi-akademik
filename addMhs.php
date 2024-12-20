<!DOCTYPE html>
<html>
<head>
	<title>Sistem Informasi Akademik::Tambah Data Mahasiswa</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap4/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/styleku.css">
	<script src="bootstrap4/jquery/3.3.1/jquery-3.3.1.js"></script>
	<script src="bootstrap4/js/bootstrap.js"></script>

</head>
<body>
	<?php
	require "head.html";
	?>
	<div class="utama">		
		<br><br><br>		
		<h3>TAMBAH DATA MAHASISWA</h3>
		<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	  		<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
		</div>	
		<form id="form" method="post" action="sv_addMhs.php" enctype="multipart/form-data">
			<div class="form-group">
				<label for="nim">NIM:</label>
				<input class="form-control" type="text" pattern="^[A-Za-z]{1}\d{2}\.\d{4}\.\d{5}$" name="nim" maxlength="14" id="nim" required oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Harap isi NIM')">
			</div>
			<div class="form-group">
				<label for="nama">Nama:</label>
				<input class="form-control" type="text" name="nama" id="nama" required oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Harap isi Nama')">
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<input class="form-control" type="email" name="email" id="email" required oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Harap isi E-Mail')">
			</div>
			<div class="form-group">
				<label for="foto">Foto</label> 
				<input class="form-control" type="file" name="foto" id="foto" required>
			</div>
			<div>		
				<button type="submit" class="btn btn-primary" value="Simpan">Simpan</button>
			</div>
		</form>
	</div>

    <div class="popup" id="successPopup">
        <h4>Berhasil!</h4> 
        <p>Data mahasiswa telah ditambahkan.</p>
        <button class="btn btn-success" id="closePopup">OK</button>
    </div>

    <script>
        $(document).ready(function() {
            $('#form').on('submit', function(e) {

                var formData = new FormData(this);

                e.preventDefault();
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        // alert('Berhasil menambahkan data mahasiswa');
                        $('#successPopup').fadeIn();
                    }
                })
            })
        })

        $('#closePopup').on('click', function() { $('#successPopup').fadeOut(); }); 
    </script>

	<!-- forum ini berisi inputan nim dengan panjang maksimal 14 carakte , nama, email, dan foto. setelah itu ada button berguna untuk menyimpan data  -->
	<!-- setelah meklik buton simpan tadi, datanya akan di arahkan ke form action svaddmhs.php  -->
</body>
</html>
