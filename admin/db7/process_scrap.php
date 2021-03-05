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
    <h1 class="display-4">Admin Panel | SOGAFIME  </h1>
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
$movieName = str_replace(array("/","http:","139.99.21.143"), '', $Link);
$scrap = curl(
    $Link,
    'GET',
    null,
    null,
    [
        'Host: 139.99.21.143',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36',
        
    ],
    null
);
$artid = getStr($scrap['Body'], 'id="muvipro_player_content_id" data-id="', '">');
for ($i=1; $i <6; $i++) {
    $Post = curl(
        'http://139.99.21.143/wp-admin/admin-ajax.php',
        'POST',
        'action=muvipro_player_content&tab=player'.$i.'&post_id='.$artid,
        null,
        [
        'Host: 139.99.21.143',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36',
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'Origin: http://139.99.21.143'
    ],
        null
    );

    $arr[] = $Post['Body'];
}
foreach ($arr as $key) {
    @$id[] = getStr($key, 'https://acefile.co/', '"');
}
if (!empty(array_values(array_filter(array_unique($id)))[0])) {
    $post2 = curl(
        'https://acefile.co/'. array_values(array_filter(array_unique($id)))[0],
        'GET',
        null,
        null,
        [
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "Accept-Language: en-US,en;q=0.9,id;q=0.8",
        "Connection: keep-alive",
        "Host: acefile.co",
        "Referer: http://139.99.21.143/",
        "Sec-Fetch-Dest: iframe",
        "Sec-Fetch-Mode: navigate",
        "Sec-Fetch-Site: cross-site",
        "Upgrade-Insecure-Requests: 1",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
    ],
        null
    );
    
    $regex = preg_match('/\b\w{66}\b/m', getStr($post2['Body'], 'eval', '</script>'), $out_regex);
    $token = $out_regex[0];
    $post3 = curl(
        'https://service.acefile.co/acembed/?id='. $token,
        'GET',
        null,
        null,
        [
        "Accept: application/json, text/javascript, */*; q=0.01",
        "Accept-Language: en-US,en;q=0.9,id;q=0.8",
        "Connection: keep-alive",
        "Host: service.acefile.co",
        "Origin: https://acefile.co",
        "Referer: https://acefile.co/",
        "Sec-Fetch-Dest: empty",
        "Sec-Fetch-Mode: cors",
        "Sec-Fetch-Site: same-site",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
    ],
        null
    );
    @$ex = explode('=', parse_url(@json_decode($post3['Body'], true)['data'], PHP_URL_QUERY));
    if (!empty($ex[1])) {
        $scrap = curl(
            'https://femax20.com/api/source/'. $ex[1],
            'POST',
            'r=https://femax20.com/f/'.$ex[1].'&d=femax20.com',
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

    $regex1 = preg_match('/\b\w{40}\b/m', getStr($post2['Body'], 'eval', '</script>'), $out_regex);
    $regex2 = preg_match_all('/\b\d{8}\b/m', getStr($post2['Body'], 'eval', '</script>'), $out_regex1);
    $regex2s = preg_match_all('/\b\w{66}\b/m', getStr($post2['Body'], 'eval', '</script>'), $out_regex3);
    $token = $out_regex[0];
    $a = $out_regex1[0][1];
    $tok = $out_regex3[0][0];

    $post3 = curl(
        'https://acefile.co/local/'.$a.'?key='. $token,
        'GET',
        null,
        null,
        [
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
            "Accept-Language: en-US,en;q=0.9,id;q=0.8",
            "Connection: keep-alive",
            "Host: acefile.co",
            "Referer: https://acefile.co/player/35372664/salinan-sobat-ambyar-2021-720p-web-dl-fhdonline-xyz-mkv",
            "Sec-Fetch-Dest: iframe",
            "Sec-Fetch-Mode: navigate",
            "Sec-Fetch-Site: same-origin",
            "Sec-Fetch-User: ?1",
            "Upgrade-Insecure-Requests: 1",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36",
            "Cookie: ace_csrf=f3a8b657725ad56dd24fc9152768feb2; ps_sess=94l80a9t0ab0pe0m906i5qghfdmheg93; __cf_bm=fd611b4c5fa4b44d9c964bc284eb7a8fcc2937c8-1613978770-1800-AVpOrSOQpWZJKKpmBAhUJlfXh9YrupEHs8timi1/+aJ/nCUKnQTgeTFBP4Zr4dvdBxmgGbFsqj8+PTY1eXsRKkdkLEURJiNvIeEvjaPYIE48Dtru0zdkFqnJZT6mumt9uw=="
          ],
        null
    );
    $source = getStr($post3['Body'],'JSON.parse(atob("','")),');
    if(!empty($source)){
      $str = json_decode(base64_decode($source), true);
         foreach (@$str as $key => $value) {
          echo '
          <tr>
          <th scope="row">'.$key.'</th>
          <td>'.@$movieName.'</td>
          <td>'.$str[$key]['label'].'</td>
          <td>'.substr($str[$key]['file'], 0, 20).' XXX '.substr($str[0][$key]['file'], 20, 30).'</td>
          <td><a href="./../process_add.php?link='.$str[$key]['file'].'&movie='.@$movieName.'" class="btn btn-secondary" tabindex="-1" role="button" aria-disabled="false">Add to database</a></td>
        </tr>';
      echo '<div class="alert alert-success" role="alert">
              <h4 class="alert-heading">Success</h4>
              <p>Silahkan Pilih Resolusi Video Anda</p>
            </div>';
        }
    
      }else{
        echo '<div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Error</h4>
        <p>Error Get Server Movie V2</p>
      </div>';
        $last = curl(
          'https://s3.acefile.co/V3/embed/?page=check&id='.$tok,
          'GET',
          null,
          null,
          [
            "Accept: */*",
            "Accept-Language: en-US,en;q=0.9,id;q=0.8",
            "Connection: keep-alive",
            "Host: s3.acefile.co",
            "Sec-Fetch-Dest: empty",
            "Sec-Fetch-Mode: cors",
            "Sec-Fetch-Site: same-origin",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
          ],
          null
        );

         if(@json_decode($last['Body'], true)['error'] === 0){
          echo '
          <tr>
          <th scope="row">-</th>
          <td>'.@$movieName.'</td>
          <td>-</td>
          <td>'.substr(json_decode($last['Body'], true)['data'], 0, 20).' XXX '.substr(json_decode($last['Body'], true)['data'], 20, 30).'</td>
          <td><a href="./../process_add.php?link='.json_decode($last['Body'], true)['data'].'&movie='.@$movieName.'" class="btn btn-secondary" tabindex="-1" role="button" aria-disabled="false">Add to database</a></td>
        </tr>';
      echo '<div class="alert alert-success" role="alert">
              <h4 class="alert-heading">Success</h4>
              <p>Silahkan Pilih Resolusi Video Anda</p>
            </div>';
        }else{
          echo '<div class="alert alert-danger" role="alert">
          <h4 class="alert-heading">Error</h4>
          <p>Error Get Server Movie V3</p>
        </div>';
          echo '<meta http-equiv="refresh" content="3;url='. $config['BaseUrl'] .'/admin/'. '">';
        } 

      }
  }
} else {
    echo '<div class="alert alert-danger" role="alert">
              <h4 class="alert-heading">Error</h4>
              <p>Error Get Server Movie AceFile</p>
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