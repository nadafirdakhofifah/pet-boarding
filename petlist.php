<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
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
  </head>
  <body>

    <!-- HEADER -->
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
            <li class="nav-item active"><a href="Petlist.php" class="nav-link">On board</a></li>
            <li class="nav-item"><a href="pricing.php" class="nav-link">Pricing</a></li>
            <li class="nav-item"><a href="testimoni.php" class="nav-link">Testimonial</a></li>
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
            <h1 class="mb-0 bread">On Boarding</h1>
          </div>
        </div>
      </div>
    </section>

<!-- CONTENT -->
<section class="ftco-section">
  <div class="container">
    <h2 class="mb-4">Pets Currently Staying With Us</h2>

    <form method="GET" class="form-inline mb-3">
      <input type="text" name="search" class="form-control mr-2" placeholder="Cari nama hewan..." value="<?= $_GET['search'] ?? '' ?>">
      <select name="jenis" class="form-control mr-2">
        <option value="">Semua</option>
        <option value="kucing" <?= ($_GET['jenis'] ?? '') == 'kucing' ? 'selected' : '' ?>>Kucing</option>
        <option value="anjing" <?= ($_GET['jenis'] ?? '') == 'anjing' ? 'selected' : '' ?>>Anjing</option>
      </select>
      <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <style>
/* Table Container */
.table-container {
  padding: 1rem;
  background: #f8fffc;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 128, 128, 0.1);
  font-family: 'Segoe UI', sans-serif;
}

/* Table Style */
table {
  width: 100%;
  border-collapse: collapse;
  border-radius: 12px;
  overflow: hidden;
}

thead {
  background: #20c997; /* Hijau tosca */
  color: white;
  text-align: center;
  font-weight: bold;
  font-size: 1rem;
}

thead th {
  padding: 1rem;
}

tbody td {
  padding: 0.75rem;
  text-align: center;
  color: #212529;
  font-size: 0.95rem;
  transition: background 0.3s ease;
}

tbody tr:nth-child(even) {
  background-color: #e6f7f4;
}

tbody tr:hover {
  background-color: #c3f3eb;
}

/* Pagination */
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 1rem;
  gap: 6px;
}

.pagination a {
  color: #20c997;
  border: 1px solid #20c997;
  padding: 6px 12px;
  border-radius: 6px;
  text-decoration: none;
  transition: all 0.2s ease-in-out;
  font-weight: 500;
}

.pagination a:hover {
  background: #20c997;
  color: white;
}

.pagination .active {
  background: #20c997;
  color: white;
  font-weight: bold;
  pointer-events: none;
}
</style>


    <table class="table table-bordered table-custom">
      <thead>
        <tr><th>Nama Hewan</th><th>Jenis</th></tr>
      </thead>
      <tbody>
<?php
$pets = [
  ["nama" => "Milo", "jenis" => "anjing"],
  ["nama" => "Kitty", "jenis" => "kucing"],
  ["nama" => "Bobby", "jenis" => "anjing"],
  ["nama" => "Luna", "jenis" => "kucing"],
  ["nama" => "Rocky", "jenis" => "anjing"],
  ["nama" => "Snowy", "jenis" => "kucing"],
  ["nama" => "Bruno", "jenis" => "anjing"],
  ["nama" => "Mimi", "jenis" => "kucing"],
  ["nama" => "Charlie", "jenis" => "anjing"],
  ["nama" => "Nala", "jenis" => "kucing"],
  ["nama" => "Max", "jenis" => "anjing"],
  ["nama" => "Coco", "jenis" => "kucing"],
  ["nama" => "Rex", "jenis" => "anjing"],
  ["nama" => "Lily", "jenis" => "kucing"],
  ["nama" => "Buddy", "jenis" => "anjing"],
  ["nama" => "Bella", "jenis" => "kucing"],
  ["nama" => "Oscar", "jenis" => "anjing"],
  ["nama" => "Simba", "jenis" => "kucing"],
  ["nama" => "Duke", "jenis" => "anjing"],
  ["nama" => "Lulu", "jenis" => "kucing"],
  ["nama" => "Shadow", "jenis" => "anjing"],
  ["nama" => "Olive", "jenis" => "kucing"],
  ["nama" => "Zeus", "jenis" => "anjing"],
  ["nama" => "Daisy", "jenis" => "kucing"],
  ["nama" => "Hunter", "jenis" => "anjing"],
  ["nama" => "Toby", "jenis" => "anjing"],
  ["nama" => "Sassy", "jenis" => "kucing"],
  ["nama" => "Ace", "jenis" => "anjing"],
  ["nama" => "Chloe", "jenis" => "kucing"],
  ["nama" => "Rusty", "jenis" => "anjing"],
  ["nama" => "Pepper", "jenis" => "kucing"],
  ["nama" => "Tank", "jenis" => "anjing"],
  ["nama" => "Ginger", "jenis" => "kucing"],
  ["nama" => "Sam", "jenis" => "anjing"],
  ["nama" => "Mocha", "jenis" => "kucing"],
  ["nama" => "King", "jenis" => "anjing"],
  ["nama" => "Cleo", "jenis" => "kucing"],
  ["nama" => "Boomer", "jenis" => "anjing"],
  ["nama" => "ilsan", "jenis" => "kucing"],
  ["nama" => "Bear", "jenis" => "anjing"],
  ["nama" => "Mochi", "jenis" => "kucing"],
  ["nama" => "Scout", "jenis" => "anjing"],
  ["nama" => "Maya", "jenis" => "kucing"],
  ["nama" => "Ziggy", "jenis" => "anjing"],
  ["nama" => "Babi", "jenis" => "kucing"],
  ["nama" => "Buster", "jenis" => "anjing"],
  ["nama" => "Ruby", "jenis" => "kucing"]
];

// Filter dan paginasi
$search = $_GET['search'] ?? '';
$jenis = $_GET['jenis'] ?? '';
$filteredPets = array_filter($pets, function($pet) use ($search, $jenis) {
  return ($search === '' || stripos($pet['nama'], $search) !== false) &&
         ($jenis === '' || $pet['jenis'] === $jenis);
});

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 10;

$totalData = count($filteredPets);
$totalPages = ceil($totalData / $limit);
$start = ($page - 1) * $limit;
$paginatedPets = array_slice($filteredPets, $start, $limit);

foreach ($paginatedPets as $pet) {
  echo "<tr><td>{$pet['nama']}</td><td>{$pet['jenis']}</td></tr>";
}
?>
      </tbody>
    </table>

<?php if ($totalPages > 1): ?>
  <nav>
    <ul class="pagination justify-content-center">
      <?php if ($page > 1): ?>
        <li class="page-item">
          <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">&laquo;</a>
        </li>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
          <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
      
      <?php if ($page < $totalPages): ?>
        <li class="page-item">
          <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">&raquo;</a>
        </li>
      <?php endif; ?>
    </ul>
  </nav>
<?php endif; ?>

  </div>
</section>

<!-- FOOTER -->
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