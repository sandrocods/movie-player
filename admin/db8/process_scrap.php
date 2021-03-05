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
    <h1 class="display-4">Admin Panel | LK21  </h1>
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
//http://149.56.24.226/scooby-doo-the-sword-and-the-scoob-2021/
$LINKS = $_GET['link'];
$LINK = str_replace(array("149.56.24.226","/","http:"), '', $LINKS);
$Scrap = curl(
    'http://149.56.24.226/ajax/movie.php',
    'POST',
    'slug='.$LINK.'',
    null,
    [
        "Accept: */*",
        "Accept-Language: en-US,en;q=0.9,id;q=0.8",
        "Connection: keep-alive",
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "Host: 149.56.24.226",
        "Origin: http://149.56.24.226",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36",
        "X-Requested-With: XMLHttpRequest"
      ],
    null
);
$ID = getStr($Scrap['Body'], '</div><div><a href="','" target="iframe" class="FEMBED">');
if(!empty($ID)){
$explode = explode('/',parse_url($ID, PHP_URL_PATH));

$GetMovie = curl(
    'https://femax20.com/api/source/'.$explode[2],
    'POST',
    'r=https://femax20.com/f/'.$explode[2].'-&d=femax20.com',
    null,
    [
        'Host: femax20.com'
    ],
    null
);
foreach (json_decode($GetMovie['Body'], true)['data'] as $key => $value) {
    echo '
    <tr>
    <th scope="row">'.$key.'</th>
    <td>'.@$LINK.'</td>
    <td>'.@json_decode($GetMovie['Body'], true)['data'][$key]['label'].'</td>
    <td>'.substr(@json_decode($GetMovie['Body'], true)['data'][$key]['file'], 0, 20).' XXX '.substr(@json_decode($GetMovie['Body'], true)['data'][$key]['file'], 20, 30).'</td>
    <td><a href="./../process_add.php?link='.@json_decode($GetMovie['Body'], true)['data'][$key]['file'].'&movie='.@$LINK.'" class="btn btn-secondary" tabindex="-1" role="button" aria-disabled="false">Add to database</a></td>
  </tr>';
}
    echo '<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Success</h4>
    <p>Silahkan Pilih Resolusi Video Anda</p>
    </div>';
} else {

    echo '<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Error</h4>
    <p>Error Get Server Movie </p>
  </div>';

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