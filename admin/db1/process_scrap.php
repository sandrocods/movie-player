<?php
set_time_limit(0);
error_reporting(0);
include './../../include/header.php';
include './../../include/config.php';
include '../helper.php';

$link = $_GET['link'];
$movieName = str_replace('-', ' ', getStr($link, 'http://159.65.11.63/','/'));
$scrap = curl(
    $link . '?watching',
    'GET',
    null,
    [
        'Max' => 1
    ],
    [
        'Host: 159.65.11.63',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36',
        'Accept: image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8',
        'Referer: http://159.65.11.63/'
    ],
    null
);
preg_match_all('/<iframe src="\/movie\/\?id=(.*?)" width="100%" height="100%"/', $scrap['Body'], $hasil);
$id = $hasil[1][0];

$scrap2 = curl(
    'http://159.65.11.63/movie/?id='. $id,
    'GET',
    null,
    [
        'Max' => 1
    ],
    [
        'Host: 159.65.11.63',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36',
        'Accept: image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8',
        'Referer: http://159.65.11.63/'
    ],
    null
);
@$getLink = getStr($scrap2['Body'], '<iframe id="calendar" src="https://femax20.com/v/', '" width="100%" height="100%" frameborder="0" scrolling="no" allowfullscreen></iframe>');
@$scrap3 = curl(
    'https://femax20.com/api/source/'. @$getLink,
    'POST',
    'r=http://159.65.11.63/&d=femax20.com',
    null,
    [
        'Host: femax20.com',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36',
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'Origin: https://femax20.com',
        'Referer: https://femax20.com/v/08j1qfl7x0m652d'
    ],
    null
);
if (@json_decode($scrap3['Body'], true)['success'] === true) {
    foreach (@json_decode($scrap3['Body'], true)['data'] as $key => $value) {
        @$scrap4 = curl(
            json_decode($scrap3['Body'], true)['data'][$key]['file'],
            'GET',
            null,
            null,
            [
                'Host: fvs.io',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36',
                'Connection: keep-alive',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9'
            ],
            null
        );
        preg_match('/^location:\s*([^\n]*)/m', @$scrap4['Header'], $matches);
        @$array[] = [
            'link' => $matches[1],
            'label' => json_decode($scrap3['Body'], true)['data'][$key]['label']
        ];
    }
} else {
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
      <th scope="col">Resolution</th>
      <th scope="col">Link</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>

      <?php
      $a = 0;
      foreach (@$array as $key => $value) {
          echo '
    <tr>
      <th scope="row">'.$a.'</th>
      <td>'.@$array[$key]['label'].'</td>
      <td>'.@$array[$key]['link'].'</td>
      <td><a href="./../process_add.php?link='.@$array[$key]['link'].'&movie='.@$movieName.'" class="btn btn-secondary" tabindex="-1" role="button" aria-disabled="false">Add to database</a></td>
    </tr>';
          $a++;
      }?>
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
