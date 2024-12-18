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
		<h3>TAMBAH DATA MATA KULIAH</h3>
		<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	  		<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
		</div>	
		<form id="form" method="post" action="sv_addmatkul.php" enctype="multipart/form-data">
			<div class="form-group">
				<label for="kdmatkul">Kode Matakuliah:</label>
				<input class="form-control" type="text" pattern="^[A-Za-z]{1}\d{2}\.\d{6}$" name="kdmatkul" maxlength="10" id="idmatkul" required oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Harap isi Id Matakuliah')">
			</div>
			<div class="form-group">
				<label for="namamatkul">Nama Matakuliah:</label>
				<input class="form-control" type="text" name="namamatkul" id="namamatkul" required oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Harap isi Nama Matakuliah')">
			</div>
			<div class="form-group">
				<label for="sks">SKS:</label>
				<input class="form-control" type="text" name="sks" id="sks" required oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Harap isi SKS')">
			</div>
			<div class="form-group">
				<label for="jenis">Jenis</label> 
				<input class="form-control" type="text" name="jenis" id="jenis" required>
			</div>
            <div class="form-group">
				<label for="semester">Semester:</label>
				<input class="form-control" type="text" name="semester" id="semester" required oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Harap isi Semester')">
			</div>
			<div>		
				<button type="submit" class="btn btn-primary" value="Simpan">Simpan</button>
			</div>
		</form>
	</div>

    <div class="popup" id="successPopup">
        <h4>Berhasil!</h4> 
        <p>Data matakuliah telah ditambahkan.</p>
        <button class="btn btn-success" id="closePopup" onclick="window.location.href = 'updateMatkul.php'">OK</button>
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
