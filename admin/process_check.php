<?php
include './../include/header.php';
include './../include/koneksi.php';
include './../include/config.php';
include 'helper.php';
?>
<title>Movie Player | ADMIN</title>
  </head>
  <body>
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
        <a class="nav-link" href="./index.php">Admin Menu</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <body>
  <div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Admin Panel | Movie Status </h1>
    <p class="lead">Sandro Movies</p>
  </div>
</div>

  
  <div class="container">
  <div class="table-responsive">
  <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">Movie Name</th>
            <th scope="col">Link</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
<?php

$sql = "SELECT * FROM `movie_play` ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $CheckUP = curl(
            $row['link'],
            'GET',
            null,
            null,
            [
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36',
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
                
            ],
            null
        );
        $stats = ($CheckUP['HttpCode'] == '302' || $CheckUP['HttpCode'] == '200' ) ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Error</span>';
        echo'<tr>
            <th scope="row">-</th>
            <td>'.$row['id'].'</td>
            <td>'.$row['movie_name'].'</td>
            <td>'.substr($row['link'], 0, 20).' XXX '.substr($row['link'], 20, 30).'</td>
            <td>'.$stats.'</td>
            ';

        ob_flush();
        flush();
    }
} else {
    echo '
    <div class="container">
    <center>
    <h1> Video Tidak ada silahkan Tambah Video </h1>
          </center>
 </div>';
}
?>
</tr>
          </tbody>
          </table>