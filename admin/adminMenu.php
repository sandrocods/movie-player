<?php
include 'helper.php';
include './../include/koneksi.php';
include './../include/config.php';
include './../include/header.php';

$sql = "SELECT COUNT(*) FROM movie_play";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    @$a_count = mysqli_fetch_assoc($result);
}
mysqli_close($conn);
session_start(); // Start session nya
// Kita cek apakah user sudah login atau belum
// Cek nya dengan cara cek apakah terdapat session username atau tidak
if (! isset($_SESSION['key'])) { // Jika tidak ada session username berarti dia belum login
  header("location: index.php"); // Kita Redirect ke halaman index.php karena belum login
}
?>

  <title>Movie Player | ADMIN Menu</title>
  </head>
  <meta http-equiv="refresh" content="900;url= <?php echo $config['BaseUrl'] .'/admin/process_logout.php' ?>" />
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
  <a class="navbar-brand" href="<?php echo $config['BaseUrl'] ?>">Sandro Movies</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" href="./index.php">Admin Menu</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Admin Panel</h1>
    <p class="lead">Sandro Movies</p>
    <hr>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-6">

    <div class="card text-white bg-success mb-2" >
  <div class="card-header">Welcome</div>
  <div class="card-body">
    <h5 class="card-title"><?php echo $_SESSION['username']; ?></h5>
    <hr>
    <div class="d-grid gap-2 d-md-block">
    <a href="././process_logout.php" type="button" class="btn btn-warning btn-sm" >Logout Account</a>
  </div>
  </div>
</div>
    
    </div>
    <div class="col-6">
    <div class="card text-white bg-primary mb-2" >
  <div class="card-header">Playlist Video</div>
  <div class="card-body">
    <h5 class="card-title">Total Playlist : <?php echo $a_count['COUNT(*)']; ?></h5>
    <hr>
    <div class="d-grid gap-2 d-md-block">

    <a href="././process_check.php" type="button" class="btn btn-success btn-sm" >Check Active Server Movie</a>
    <a href="././process_history.php" type="button" class="btn btn-secondary btn-sm" >Check History Playing</a>
    <a href="././process_delete.php" type="button" class="btn btn-warning btn-sm" >Delete Playing Movie</a>
  </div>
  </div>
</div>

    </div>
  </div>

</div>
<br>
<br>


  <div class="container">
  <div class="list-group">
  <a href="#" class="list-group-item list-group-item-action active">
    Select Provider Movie
  </a>
  <a href="./../admin/db1" class="list-group-item list-group-item-action">IndoXX1 Server 1 </a>
  <a href="./../admin/db2" class="list-group-item list-group-item-action">MELONGMOVIE </a>
  <a href="./../admin/db3" class="list-group-item list-group-item-action">MOVINDO21 </a>
  <a href="./../admin/db4" class="list-group-item list-group-item-action">SAVEFILM21 </a>
  <a href="./../admin/db5" class="list-group-item list-group-item-action">FILMAPIK </a>
  <a href="./../admin/db6" class="list-group-item list-group-item-action">REBAHAN MOVIE </a>
  <a href="./../admin/db7" class="list-group-item list-group-item-action">SOGAFIME </a>
  <a href="./../admin/db8" class="list-group-item list-group-item-action">LK21 </a>
</div>
<br>
<div class="list-group">
  <a href="#" class="list-group-item list-group-item-action active">
    Option
  </a>
  <a href="./../admin/process_user.php?generate=1" class="list-group-item list-group-item-action">Management User </a>
  
</div>
  </div>
  </div>
  <!-- Content here -->
<?php

include './../include/footer.php';

?>