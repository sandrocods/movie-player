<?php include './../../include/header.php'; ?>

<div class="container-fluid">



<?php
$link = $_GET['link'];
$movie_name = $_GET['movie'];
include './../../include/koneksi.php';



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
  echo '<meta http-equiv="refresh" content="3;url='. $config['BaseUrl'] .'/admin/'. '">';

} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>

</div>

<?php

include './../../include/footer.php';

?>
