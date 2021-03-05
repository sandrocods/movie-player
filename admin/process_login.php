<?php
session_start();
include 'helper.php';
include './../include/koneksi.php';
include './../include/config.php';
include './../include/header.php';


$key = $_POST['key'];

$sql = "SELECT * FROM `user_play` WHERE `key` = '$key'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['key'] = $row['key'];
        header("location: adminMenu.php");
    }
}else{
    echo '
    <div class="container">
    <center>
    <h1> Key anda tidak terdaftar </h1>
          </center>
 </div>';
 echo '<meta http-equiv="refresh" content="3;url='. $config['BaseUrl'] .'/admin/'. '">';
}


?>