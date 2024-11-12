<?php session_start()?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Sistem</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap4/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/styleku.css">
	<script src="bootstrap4/js/bootstrap.js"></script>
	<script src="bootstrap4/jquery/3.3.1/jquery-3.3.1.js"></script>
</head>
<body>
	<div class="container">
		<div class="w-25 mx-auto text-center mt-5">
			<div class="card bg-dark text-light">
				<div class="card-body">
				<h2 class="card-title">LOGIN</h2>	
				<form method="post" action="">
					<div class="form-group">
						<label for="username">Nama user</label>
						<input class="form-control" type="text" name="username" id="username" autofocus>
					</div>
					<div class="form-group">
						<label for="passw">Password</label>
						<input class="form-control" type="password" name="passw" id="passw">
					</div>			
					<div>		
						<button class="btn btn-info" type="submit">Login</button>
					</div>
				</form>
				</div>
			</div>
		</div>	
	</div>
	<?php
	if (isset($_POST['username'])){ // jik-a post username ada isinya maka fungsi if ini akan dijalankan( isset mengecek variabel apakah varibe bernilai null apa tidak)
		require "fungsi.php"; // perintah ini menginpor file fungsi.php ( fungsi php ini untuk menguhubngkan ke database)
		$username=$_POST['username']; // mengambil variabel dari form bernama username kemudian, disimpan ke variabel username
		$passw=md5($_POST['passw']); // mengambil variabel dari form bernama password kemudian, disimpan ke variabel password
		$sql="select * from user where username='$username' and password='$passw'"; //pada query mengecek ini apakah username dan password terdapat di dalam database
		$hasil=mysqli_query($koneksi,$sql) or die(mysqli_error($koneksi)); //perintah sql diatas di query
		$row=mysqli_fetch_assoc($hasil);
		if (mysqli_affected_rows($koneksi)>0){ // mengecek apakah username dan pssw ada dan benar
			$status = $row["status"]; //mendapatkan status dari database
			echo $status;
			$_SESSION['username']=$username; //mengatur session username
			if ($status == "admin") {
				header("location:homeadmin.php");
			}
			if ($status == "mhs") {
				header("location:homemahasiswa.php"); //mengecek statusnya apa mengatur redirect ke page sesuai status
			}
			if ($status == "dsn") {
				header("location:homedosen.php");
			}
			
		}else{ //jika username dan pass yang diisi salah maka akan menampilkan teks yang ada div ini
			echo "<div class='alert alert-danger w-25 mx-auto text-center mt-1 alert-dismissible'>
			<button type='button' class='close' data-dismiss='alert'>&times;</button>
			Maaf, login gagal. Ulangi login.
			</div>";
		}
	}
	?>	
</body>
</html>
