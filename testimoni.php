<?php
session_start();
include 'koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$pesan = "";

// CREATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $komentar = $_POST['komentar'];
    $kepuasan = $_POST['kepuasan'];
    $username = $_SESSION['username'];

    $gambar = "";
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambar = "uploads/img_" . time() . "." . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar);
    }

    $stmt = $conn->prepare("INSERT INTO testimoni (nama, komentar, kepuasan, gambar, username) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama, $komentar, $kepuasan, $gambar, $username);
    $stmt->execute();
    $pesan = "Testimonial berhasil ditambahkan!";
}

// DELETE (only if user owns the testimonial)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $cek = $conn->query("SELECT * FROM testimoni WHERE id = $id AND username = '{$_SESSION['username']}'");
    if ($cek->num_rows > 0) {
        $conn->query("DELETE FROM testimoni WHERE id = $id");
    }
    header("Location: testimoni.php");
}

// UPDATE (only if user owns the testimonial)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $komentar = $_POST['komentar'];
    $kepuasan = $_POST['kepuasan'];
    $gambar = $_POST['gambar_lama'];

    $cek = $conn->query("SELECT * FROM testimoni WHERE id = $id AND username = '{$_SESSION['username']}'");
    if ($cek->num_rows > 0) {
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
            $gambar = "uploads/img_" . time() . "." . $ext;
            move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar);
        }
        $conn->query("UPDATE testimoni SET nama='$nama', komentar='$komentar', kepuasan='$kepuasan', gambar='$gambar' WHERE id=$id");
        $pesan = "Testimonial berhasil diperbarui!";
    }
}

// Mengambil data untuk form edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM testimoni WHERE id = $id AND username = '{$_SESSION['username']}'");
    if ($result->num_rows > 0) {
        $editData = $result->fetch_assoc();
    }
}
$result = $conn->query("SELECT * FROM testimoni ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <link href="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/css/lightbox.min.css" rel="stylesheet">
    <title>Pet Boarding</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">


    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
body {
  margin: 0;
  padding: 0;
  font-family: 'Segoe UI', sans-serif;
  background-color: #f8fffc;
  color: #212529;
}


h2 {
  color: #20c997;
  margin-bottom: 1.5rem;
  font-size: 1.8rem;
}


label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: #212529;
}

input[type="text"],
textarea,
select,
input[type="file"] {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  margin-bottom: 1rem;
  transition: border-color 0.3s;
  font-size: 1rem;
}

input[type="text"]:focus,
textarea:focus,
select:focus,
input[type="file"]:focus {
  border-color: #20c997;
  outline: none;
}

input[type="submit"] {
  background-color: #20c997;
  color: white;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  font-weight: bold;
  letter-spacing: 1px;
  cursor: pointer;
  transition: background 0.3s;
}

input[type="submit"]:hover {
  background-color: #17b292;
}

#image-preview {
  margin-top: 0.5rem;
  font-style: italic;
  color: #6c757d;
}

</style>

  </head>
  <body>
    
    <div class="wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center">
                        <p class="mb-0 phone pl-md-2">
                            <a href="#" class="mr-2"><span class="fa fa-phone mr-1"></span> +62 851 5634 4813</a> 
							              <a href="#"><span class="fa fa-paper-plane mr-1"></span> woofypet@gmail.com</a>
						</p>
                    </div>
                    <div class="col-md-6 d-flex justify-content-md-end">
                        <div class="social-media">
                        <p class="mb-0 d-flex">
                            <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-facebook"><i class="sr-only">Facebook</i></span></a>
                            <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-twitter"><i class="sr-only">Twitter</i></span></a>
                            <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-instagram"><i class="sr-only">Instagram</i></span></a>
                            <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-dribbble"><i class="sr-only">Dribbble</i></span></a>
                        </p>
                </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php"><span class="flaticon-pawprint-1 mr-2"></span>Woofy pet</a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="fa fa-bars"></span> Menu
	      </button>
          <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
                <li class="nav-item"><a href="vet.php" class="nav-link">Veterinarian</a></li>
                <li class="nav-item"><a href="services.php" class="nav-link">Services</a></li>
              <li class="nav-item"><a href="Petlist.php" class="nav-link">On board</a></li>
              <li class="nav-item"><a href="pricing.php" class="nav-link">Pricing</a></li>
              <li class="nav-item active"><a href="testimoni.php" class="nav-link">Testimonial</a></li>
              <li class="nav-item"><a href="logout.php" class="nav-link">Log out</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bgr_2.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>On Board <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-0 bread">Testimonial</h1>
          </div>
        </div>
      </div>
    </section>

<div class="container mt-5">
    <h2>Tulis Testimonial Anda</h2>
    <?php if ($pesan) echo "<div class='alert alert-success'>$pesan</div>"; ?>

    <form action="testimoni.php" method="post" enctype="multipart/form-data">
        <?php if ($editData): ?>
            <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <input type="hidden" name="gambar_lama" value="<?= $editData['gambar'] ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required value="<?= $editData['nama'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label>Komentar</label>
            <textarea name="komentar" class="form-control" required><?= $editData['komentar'] ?? '' ?></textarea>
        </div>
        <div class="mb-3">
            <label>Kepuasan</label>
            <select name="kepuasan" class="form-control">
                <option value="Puas" <?= (isset($editData) && $editData['kepuasan'] == 'Puas') ? 'selected' : '' ?>>Puas</option>
                <option value="Tidak Puas" <?= (isset($editData) && $editData['kepuasan'] == 'Tidak Puas') ? 'selected' : '' ?>>Tidak Puas</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control">
            <?php if (!empty($row['gambar']) && file_exists($row['gambar'])): ?>
                    <a href="<?= $row['gambar'] ?>" data-lightbox="testimoni-<?= $row['id'] ?>">
                        <img src="<?= $row['gambar'] ?>" width="150" class="img-thumbnail">
                    </a>
                <?php else: ?>
                    <p class="text-muted">Tidak ada gambar</p>
                <?php endif; ?>
        </div>
        <button type="submit" name="<?= $editData ? 'update' : 'submit' ?>" class="btn btn-success">
            <?= $editData ? 'Update' : 'Submit' ?>
        </button>
    </form>

    <hr>
    
<h4 class="mt-4 mb-4">Testimonial Kami</h4>
<div class="row">
<?php while($row = $result->fetch_assoc()): ?>
  <div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative" style="transition: transform 0.3s ease-in-out;" onmouseover="this.style.transform='scale(1.03)';" onmouseout="this.style.transform='scale(1)';">
      <?php if (!empty($row['gambar']) && file_exists($row['gambar'])): ?>
        <a href="<?= $row['gambar'] ?>" data-lightbox="testimoni-<?= $row['id'] ?>">
          <img src="<?= $row['gambar'] ?>" class="card-img-top" style="height:200px; object-fit:cover;">
        </a>
      <?php else: ?>
        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
          <span class="text-muted">No Image</span>
        </div>
      <?php endif; ?>
      <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($row['nama']) ?></h5>
        <p class="card-text"><?= htmlspecialchars($row['komentar']) ?></p>
        <span class="badge bg-<?= $row['kepuasan'] == 'Puas' ? 'success' : 'danger' ?>" style="color:white; font-size: 1.2rem;">
    <?= $row['kepuasan'] ?>
</span>

      </div>
      <?php if ($_SESSION['username'] == $row['username']): ?>
      <div class="card-footer text-end">
        <a href="testimoni.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="testimoni.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus testimonial ini?')">Hapus</a>
      </div>
      <?php endif; ?>
    </div>
  </div>
<?php endwhile; ?>
</div>

</div>

    <footer class="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-lg-3 mb-4 mb-md-0">
						<h2 class="footer-heading">Woofy pet</h2>
						<p>Tempat nyaman dan penuh cinta untuk si meong & si guguk. Titip di sini, peliharaan happy, kamu pun tenang! 🐾</p>
						<ul class="ftco-footer-social p-0">
              <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><span class="fa fa-twitter"></span></a></li>
              <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><span class="fa fa-facebook"></span></a></li>
              <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="Instagram"><span class="fa fa-instagram"></span></a></li>
					</div>
					<div class="col-md-6 col-lg-3 mb-4 mb-md-0">
						<h2 class="footer-heading">Have a Questions?</h2>
						<div class="block-23 mb-3">
              <ul>
                <li><span class="icon fa fa-map"></span><span class="text">Jl. Puncak Indah Lontar No. 2, Lontar, Sambikerep, Surabaya, Jawa Timur 60216</span></li>
                <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">+62 851 5634 4813</span></a></li>
                <li><a href="#"><span class="icon fa fa-paper-plane"></span><span class="text">woofypet@gmail.com</span></a></li>
              </ul>
            </div>
					</div>
				</div>
				<div class="row mt-5">
          <div class="col-md-12 text-center">

            <p class="copyright"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Woofy Pet <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">woofypet.com</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
			</div>
		</footer>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>

  </body>
</html>

