<?php
set_time_limit(0);
include './../../include/config.php';
include './../../include/header.php';
include '../helper.php';
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
    <h1 class="display-4">Admin Panel | REBAHIN MOVIE  </h1>
    <p class="lead">Sandro Movies</p>
  </div>
</div>
<div class="container-fluid">
<div class="card text-center">
  <div class="card-header">
      Select Resolution<br>
      </div>
  <div class="card-body">
  <div class="table-responsive">
  <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Movie Name</th>
      <th scope="col">Resolution</th>
      <th scope="col">Link</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
<?php
$Link = $_GET['link'];
$movieName = str_replace(array("/","http:","85.114.138.56"), '', $Link);
$Ecrap = curl(
    $Link.'play',
    'GET',
    null,
    [
        'Max' => 1
    ],
    [
        'Host: 85.114.138.56',
        'Connection: keep-alive',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36',
        'Referer: http://85.114.138.56/nonton-the-conqueror-sub-indo/'
    ],
    null
);
if (strpos($Ecrap['Body'], 'kotakajaiv')){
  $id = getStr($Ecrap['Body'], '<a href="https://kotakajaiv.xyz/f/','"');
}else{
  $id = getStr($Ecrap['Body'], '<a href="https://kotakajaih.xyz/f/','"');
}
if (!empty($id)) {
    $scrap = curl(
        'https://femax20.com/api/source/'. $id,
        'POST',
        'r=https://femax20.com/f/'.$id.'&d=femax20.com',
        null,
        [
        "Accept: */*",
        "Accept-Language: en-US,en;q=0.9,id;q=0.8",
        "Connection: keep-alive",
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "Host: femax20.com",
        "Origin: https://femax20.com",
        "Referer: https://femax20.com/v/qx4l6ae8xgz1nxn",
        "Sec-Fetch-Dest: empty",
        "Sec-Fetch-Mode: cors",
        "Sec-Fetch-Site: same-origin",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36",
        "X-Requested-With: XMLHttpRequest"
      ],
        null
    );
foreach (json_decode($scrap['Body'], true)['data'] as $key => $value) {
    echo '
    <tr>
    <th scope="row">'.$key.'</th>
    <td>'.@$movieName.'</td>
    <td>'.@json_decode($scrap['Body'], true)['data'][$key]['label'].'</td>
    <td>'.substr(@json_decode($scrap['Body'], true)['data'][$key]['file'], 0, 20).' XXX '.substr(@json_decode($scrap['Body'], true)['data'][$key]['file'], 20, 30).'</td>
    <td><a href="./../process_add.php?link='.@json_decode($scrap['Body'], true)['data'][$key]['file'].'&movie='.@$movieName.'" class="btn btn-secondary" tabindex="-1" role="button" aria-disabled="false">Add to database</a></td>
  </tr>';
        }
        echo '<div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Success</h4>
        <p>Silahkan Pilih Resolusi Video Anda</p>
      </div>';
    } else {

      echo '<div class="alert alert-danger" role="alert">
      <h4 class="alert-heading">Error</h4>
      <p>Error : '.$scrap['Body'].'</p>
    </div>';
    echo '<meta http-equiv="refresh" content="3;url='. $config['BaseUrl'] .'/admin/'. '">';

    }
    ?>
</tbody>
</table>
  </div>
  </div>
  <div class="card-footer text-muted">
    sandro.putraa
  </div>
</div>
</div>
<?php

include './../../include/footer.php';

?>