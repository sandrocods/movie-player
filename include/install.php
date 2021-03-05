<?php
include 'header.php';
include 'config.php';
?>
<title>Installer Sandro Movies</title>
  </head>
  <body>
  <br>
  <center>
  <div class="container">
  <h5>Auto Installer Database</h5>
  <div class="card" style="width: 60rem;">
  <ul class="list-group list-group-flush">
  <?php
    
    $conn = mysqli_connect("localhost", "root", "1");
    if (!$conn){
        $a = "Connection failed: " . mysqli_connect_error();
        echo '<li class="list-group-item">Msyql Connection :  '.$a.'</li>'; 
        die(); 
    }else{
        $a = '<span class="badge bg-success">Success</span>';
        echo '<li class="list-group-item">Msyql Connection   '.$a.'</li>';  
    }
   ?>
    
    <li class="list-group-item">A second item</li>
    <li class="list-group-item">A third item</li>
  </ul>
  <div class="card-footer">
    Card footer
  </div>
</div>
</div>
</center>
<?php 
include 'header.php';
?>