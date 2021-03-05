<?php
set_time_limit(0);
 include './../../include/header.php';
include './../../include/config.php';
include '../helper.php';

$link = $_GET['link'];
$movieName = str_replace('-', ' ', getStr($link, 'https://melongmovie.com/','/'));
$scrap = curl(
    $link ,
    'GET',
    null,
    [
        'Max' => 1
    ],
    [
        'Host: melongmovie.com',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36',
        'Accept: image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8',
        'Referer: https://melongmovie.com/latest-movies/'
    ],
    null
);
preg_match_all('/<a href="(.*?)">SERVER 1<\/a> <a href="(.*?)">SERVER 2<\/a>/m', $scrap['Body'], $hasil);
if(strpos(@$hasil[1][0]  , 'pixeldrain.com')){

    @$conf1 = curl(
        $hasil[1][0],
        'GET',
        null,
        null,
        [
            'Host: pixeldrain.com',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36',
            'Connection: keep-alive'
        ],
        null
    );
    @$getstr = getStr($conf1['Body'], "'file', '","'");

   @$conf2 = curl(
        'https://pixeldrain.com/api/' . str_replace('/u', 'file', parse_url($hasil[1][0] , PHP_URL_PATH)).'/view',
        'POST',
        'token='.@$getstr,
        null,
        [
            "Connection: keep-alive",
            "Content-Type: application/x-www-form-urlencoded",
            "Host: pixeldrain.com"
          ],
        null
    );
    @$success = 'https://pixeldrain.com/api/' . str_replace('/u', 'file', parse_url(@$hasil[1][0] , PHP_URL_PATH));
}else {
    @$a = "<h1> Trying Another Server Movie Error </h1> ";
    echo '<meta http-equiv="refresh" content="2;url='. $config['BaseUrl'].'/admin/' .'">';
}

?>
<div class="container-fluid">
<div class="card text-center">
  <div class="card-header">
      Select Resolution<br>
    
      <?php echo $movieName; ?>
    <?php echo @$a; ?>
  </div>
  <div class="card-body">
  <div class="table-responsive">
  <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Link</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">-</th>
      <td><?php echo @$success; ?></td>
      <td><a href="./../process_add.php?link=<?php echo $success; ?>&movie=<?php echo $movieName; ?>" class="btn btn-secondary" tabindex="-1" role="button" aria-disabled="false">Add to database</a></td>
    </tr>
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