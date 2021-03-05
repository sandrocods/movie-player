<?php
include 'helper.php';
include './../include/koneksi.php';
include './../include/config.php';
include './../include/header.php';
session_start(); // Start session nya
// Kita cek apakah user sudah login atau belum
// Cek nya dengan cara cek apakah terdapat session username atau tidak
if(isset($_SESSION['key'])){ // Jika session username ada berarti dia sudah login
  header("location: adminMenu.php"); // Kita Redirect ke halaman welcome.php
}



?>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Admin Panel | Login </h1>
    <p class="lead">Sandro Movies</p>
  </div>
</div>
   <center>
          <div class="card">
            <div class="card-header">
            LOGIN
            </div>
            <div class="card-body">
                <form action="process_login.php" method="POST" role="form" class="form-horizontal">
                    <div class="form-group">
                      <label for="searchterm" class="col-sm-2 control-label">KEY</label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control" id="searchterm" name="key" placeholder="KEY" >
                      </div>
                    </div>
                    <br>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Login</button>
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