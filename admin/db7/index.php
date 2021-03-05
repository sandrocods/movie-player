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
            SOGAFIME
            </div>
            <div class="card-body">
                
                <form action="index.php" method="POST" role="form" class="form-horizontal">
                    <div class="form-group">
                      <label for="searchterm" class="col-sm-2 control-label">Page</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="searchterm" name="link" placeholder="1 sd 6" >
                      </div>
                    </div>

                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select Genre</label>
                    <select class="form-select" aria-label="Default select example" name="genre">
                    <option value=""> </option>
                    <option value="animation">Animation</option>
                    <option value="horror">Horror</option>
                    <option value="action">Action</option>
                    <option value="adventure">Adventure</option>
                    </select>
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
        if (!empty($_POST['genre'])) {
          $parm = 'http://139.99.21.143/category/'.$_POST['genre'].'/page/'. $_POST['link'].'/';
          $parm2 = 'idmuvi-topbanner-archive';
        } else {
          $parm = 'http://139.99.21.143/page/'. $_POST['link'].'/';
          $parm2 = 'UPLOAD FILM BARU'; 
        }
        if (!is_numeric($_POST['link'])){
          $parm = 'http://139.99.21.143/?s='. $_POST['link'].'&post_type%5B%5D=post&post_type%5B%5D=tv';
          $parm2 = 'idmuvi-topbanner-archive';
        }
        echo '
          <center>
          <div class="alert alert-success" role="alert">
          LINK : '.$parm.'
        </div>
        </center>';

$Scrap = curl(
    $parm,
    'GET',
    null,
    [
        'Max' => 2
    ],
    [
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "Accept-Language: en-US,en;q=0.9,id;q=0.8",
        "Connection: keep-alive",
        "Host: 139.99.21.143",
        "Upgrade-Insecure-Requests: 1",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
      ],
    null
);
$Slice = getStr($Scrap['Body'], $parm2,'Muat Lebih');
preg_match_all('/href="(.*)" itemprop="url"|src="(.*)" class="attachment/m', $Slice, $out);
$link = array_values(array_unique(array_filter(str_replace('" class="button gmr-watch-button', '', $out[1]))));
$thumbnail = array_values(array_filter($out[2]));
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
<td>'.$link[$key].'</td>
<td>'.$link[$key].'</td>
<td><img src="'.$thumbnail[$key].'" alt="" class="img-thumbnail"></td>
<td><a href="./../db7/process_scrap.php?link='.$link[$key].'" class="btn btn-secondary" tabindex="-1" role="button" aria-disabled="false">Add to database</a></td>
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