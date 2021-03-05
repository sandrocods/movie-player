<?php include './../include/header.php'; ?>
<meta http-equiv="refresh" content="900;url= <?php echo $config['BaseUrl'] .'/admin/process_logout.php' ?>" />
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
  <a class="navbar-brand" href="<?php echo $config['BaseUrl'] ?>">Sandro Movies</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" href="./../index.php">Admin Menu</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">

<?php
$link = $_GET['link'];
$movie_name = $_GET['movie'];
include './../include/koneksi.php';


$sql = "INSERT INTO `movie_play` (`id`, `link`, `movie_name`) VALUES (NULL, '$link', '$movie_name')";
if (mysqli_query($conn, $sql)) {
    echo '<div class="card text-center">
    <div class="card-header">
      Info
    </div>
    <div class="card-body">
      <h5 class="card-title">Success Add Movie : '.$movie_name.' in database </h5>
    </div>
    <div class="card-footer text-muted">
      sandro.putraa
    </div>
  </div>';
  echo '
  <meta name="referrer" content="no-referrer">';
  echo '<meta http-equiv="refresh" content="3;url='. $config['BaseUrl'] .'/admin/'. '">';

} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>

</div>

<?php

include './../include/footer.php';

?>
