<?php
include './../include/header.php';
include './../include/config.php';
include './../include/koneksi.php';
session_start(); // Start session nya
if (! isset($_SESSION['key'])) { // Jika tidak ada session username berarti dia belum login
    header("location: index.php"); // Kita Redirect ke halaman index.php karena belum login
  }
?>

<?php

$msg = '';
@$user = $_GET['delete'];
if (!empty($user)){ 
    $sql = "DELETE FROM user_play WHERE id = $user";
    if (mysqli_query($conn, $sql)) {
        @$msg = 'Success Delete User : '.$user.' from database';
    } else {
        @$msg = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
    echo '<meta http-equiv="refresh" content="1;url='. $config['BaseUrl'] .'/admin/process_user.php'. '">';
}else{


}

@$key = $_GET['generate'];
if (!isset($key) || !empty($key)){
    //MVS01XYZ
    function random($length, $a)
    {
        $str = "";
        if ($a == 0) {
            $characters = array_merge(range('0', '9'));
        } elseif ($a == 1) {
            $characters = array_merge(range('0', '9'), range('A', 'Z'), range('a', 'z'));
        }
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    $generator = "MVS" . random(5,1);
    
    
}
@$username = $_POST['username'];
@$key = $_POST['key'];
if (!empty($username)){
        
    $sql = "INSERT INTO `user_play` (`id`, `key`, `username`) VALUES (NULL, '$key', '$username');";
    if (mysqli_query($conn, $sql)) {
        @$msg = 'Success Add User : '.$username.' in database';
    } else {
        @$msg = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
    echo '<meta http-equiv="refresh" content="1;url='. $config['BaseUrl'] .'/admin/process_user.php'. '">';
}else{
    //@$msg = 'Harap isi semua fields';

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
        <a class="nav-link" href="./index.php">Admin Menu</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <body>
  <div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Admin Panel | User Management </h1>
    <p class="lead">Sandro Movies</p>
  </div>
</div>

<div class="container">
          <div class="card">
            <div class="card-header">
            User
            </div>
            <div class="card-body">
                
                <form action="process_user.php" method="POST" role="form" class="form-horizontal">
                    <div class="form-group">
                      <label for="searchterm" class="col-sm-2 control-label">Username</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="searchterm" name="username" placeholder="username" >
                      </div>
                      <br>
                      <label for="searchterm" class="col-sm-2 control-label">Key</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="searchterm" name="key" placeholder="key" value="<?php echo $generator; ?>"  readonly>
                        <br>
                        <a href="./../admin/process_user.php?generate=1" class="btn btn-secondary" tabindex="-1" role="button" aria-disabled="false">Generate Key</a>
                      </div>
                    </div>
                    <br>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Input</button>
                      </div>
                    </div>
                  </form>
                <br>
                <?php echo $msg; ?>
            </div>
            <div class="card-footer text-muted">
            <a href="http://t.me/Sandroputraaa" class="badge bg-primary">Code by sandroputraa ❤️️</a>
            </div>
            </div>
          </div>
          </div>
          <br>



  <div class="container">
  <div class="table-responsive">
  <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">Key</th>
            <th scope="col">Username</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
<?php

$sql = "SELECT * FROM `user_play` ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo'<tr>
            <th scope="row">-</th>
            <td>'.$row['id'].'</td>
            <td>'.$row['key'].'</td>
            <td>'.$row['username'].'</td>
            <td><a href="./../admin/process_user.php?delete='.$row['id'].'" class="btn btn-danger" tabindex="-1" role="button" aria-disabled="false">Delete User</a></td>
            ';

        ob_flush();
        flush();
    }
} else {
    echo '
    <div class="container">
    <center>
    <h1> Video Tidak ada silahkan Tambah Video </h1>
          </center>
 </div>';
}
?>
</tr>
          </tbody>
          </table>