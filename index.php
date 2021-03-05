<?php

if (!file_exists(__DIR__ . '/include/setting.ini')){
    echo "<center><h1> Configuration File not exists , install first </h1></center>";

}

include 'include/header.php';
include 'include/koneksi.php';
include 'include/config.php';
include 'admin/helper.php';

$sql = "SELECT * FROM `movie_play` ORDER BY id DESC LIMIT 1";
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
        $stats = ($CheckUP['HttpCode'] == '302' || $CheckUP['HttpCode'] == '200' ) ? 'ok' : 'error';
        if ($stats == 'error'){

            @$video = '<div class="container">
            <center>
            <div class="alert alert-error" role="alert">
  <h4 class="alert-heading">Error</h4>
  <p>Cannot retrieve data from server video</p>
  <hr>
  <p class="mb-0">Please Add Another Server</p>
</div>
                </center>
            </div>';
            ob_flush();
            flush();

            echo '
            <script type="text/javascript" charset="utf-8">
            setTimeout(function () {
                window.location.href = "' . $config['BaseUrl'] . 'admin/cron_delete.php' . '"; //will redirect to your blog page (an ex: blog.html)
             }, 5000); //will call the function after 2 secs.

            </script>';
        }else {
            @$video = '
            <video autoplay poster="include/thumbnail.gif" class="js-player" src="'.$row["link"].'">
            </video>';
        }
    }
} else {
    ob_flush();
    flush();
    @$video = '
    <div class="container">
	<div class="row">
	<div class="alert alert-danger alert-dismissible" role="alert">
  <strong><i class="fa fa-warning"></i> Danger!</strong> <marquee><p style="font-family: Impact; font-size: 18pt">Video Tidak ada silahkan hubungi admin !</p></marquee>
</div>
	</div>
</div>
';
echo '
<script type="text/javascript" charset="utf-8">
setTimeout(function () {
    window.location.href = "' . $config['BaseUrl'] . '/index.php' . '";
 }, 60000); //will call the function after 60 secs.

</script>';

}

mysqli_close($conn);

?>
    <script src='https://cdn.plyr.io/3.5.6/plyr.js'></script>

<script type="text/javascript" charset="utf-8">

         document.addEventListener('DOMContentLoaded', () => {  
        const player = Plyr.setup('.js-player', {
                hideControls: false,
                keyboard: { focused: true},
                fullscreen: { enabled: true},
                autoplay: true,
        });
        player[0].on('ended', function(event) {
            window.location.href= "<?php echo $config['BaseUrl'] . 'admin/cron_delete.php'; ?>"
        });
    });


    </script>

  <title>Movie Player</title>
  </head>
  <body>
      <?php echo $video; ?>
<?php
include 'include/footer.php';
?>