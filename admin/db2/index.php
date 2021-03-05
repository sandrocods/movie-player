<?php
include './../../include/config.php';
include './../../include/header.php';
include '../helper.php';
session_start(); // Start session nya
// Kita cek apakah user sudah login atau belum
// Cek nya dengan cara cek apakah terdapat session username atau tidak
if( ! isset($_SESSION['key'])){ // Jika tidak ada session username berarti dia belum login
  header("location: ./../index.php"); // Kita Redirect ke halaman index.php karena belum login
}
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
        <a class="nav-link" href="./../index.php">Admin Menu</a>
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
<center>
          <div class="card">
            <div class="card-header">
              Melong Movie
            </div>
            <div class="card-body">
                
                <form action="index.php" method="POST" role="form" class="form-horizontal">
                    <div class="form-group">
                      <label for="searchterm" class="col-sm-2 control-label">Page</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="searchterm" name="link" placeholder="1 sd 6" >
                      </div>
                    </div>
                    <br>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Search</button>
                      </div>
                    </div>
                  </form>
                <br>
            </div>
            <div class="card-footer text-muted">
            <a href="http://t.me/Sandroputraaa" class="badge bg-primary">Code by sandroputraa ❤️️</a>
            </div>
            </div>
          </div>
    </center>
<?php
if (!isset($_POST['link']) || empty($_POST['link'])) {
    $a = '';
} else {

  if(!is_numeric($_POST['link'])){
    $parm = '?s='.$_POST['link'];
  }else{
    $parm = '/latest-movies/page/'.$_POST['link'].'/';
  }
// Get Movie List
$scrap = curl(
  'https://melongmovie.com'. $parm,
  'GET',
  null,
  [
    'Max' => '1'
  ],
  [
    'Host: melongmovie.com',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36',
    'Connection: keep-alive',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9'
  ],
  null
);
$slice = getStr($scrap['Body'], '<div class="latest">', 'pagination');
preg_match_all('/href="(.*?)" itemprop="url" title="(.*?)"|src="(.*?)"/m', $slice, $out);
$link = array_values(array_filter($out[1]));
$movie = array_values(array_filter($out[2]));
$thumbnail = array_values(array_filter($out[3]));

    foreach ($link as $key => $value) {
echo '<div class="table-responsive">
<table class="table table-dark">
<thead>
<tr>
  <th scope="col">#</th>
  <th scope="col">Movie</th>
  <th scope="col">Link</th>
  <th scope="col">Image</th>
  <th scope="col">Process</th>
</tr>
</thead>
<tbody>
<tr>
<th scope="row">'.$key.'</th>
<td>'.$movie[$key].'</td>
<td>'.$link[$key].'</td>
<td><img src="'.$thumbnail[$key].'" alt="" class="img-thumbnail" style="width: 100px; height: 200px;"></td>
<td><a href="./../db2/process_scrap.php?link='.$link[$key].'" class="btn btn-secondary" tabindex="-1" role="button" aria-disabled="false">Add to database</a></td>
</tr>
</tbody>
</table>
</div>
';
    }
}
?>
    <?php

include './../../include/header.php';

?>