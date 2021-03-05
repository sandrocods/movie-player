
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
    <h1 class="display-4">Admin Panel | Movindo21  </h1>
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


$link = $_GET['link'];
$movieName = str_replace('.htm', '', $_GET['link']);
$scrap = curl(
    'http://95.216.153.180/index.php?v=show&act=fetchVideo',
    'POST',
    'code='.$movieName.'',
    [
        'Max' => 2
    ],
    [
        'Host: 95.216.153.180',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36',
        'Accept: application/json, text/javascript, */*; q=0.01',
        'Origin: http://95.216.153.180'
    ],
    null
);
if (json_decode($scrap['Body'],true)['player']['playlist'][0]['title'] !== NULL ){
  $movieName = json_decode($scrap['Body'],true)['player']['playlist'][0]['title'];
  foreach (json_decode($scrap['Body'], true)['player']['playlist'][0]['sources'] as $key => $value) {
    echo '
    <tr>
    <th scope="row">'.$key.'</th>
    <td>'.@$movieName.'</td>
    <td>'.@json_decode($scrap['Body'], true)['player']['playlist'][0]['sources'][$key]['label'].'</td>
    <td>'.@json_decode($scrap['Body'], true)['player']['playlist'][0]['sources'][$key]['file'].'</td>
    <td><a href="./../process_add.php?link='.@json_decode($scrap['Body'], true)['player']['playlist'][0]['sources'][$key]['file'].'&movie='.@$movieName.'" class="btn btn-secondary" tabindex="-1" role="button" aria-disabled="false">Add to database</a></td>
  </tr>';
  }
} else {
  @$a = "<h1> Trying Another Server Movie Error </h1> ";
  echo '<meta http-equiv="refresh" content="2;url='. $config['BaseUrl'].'/admin/' .'">';
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
