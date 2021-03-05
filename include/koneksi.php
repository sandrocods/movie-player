<?php
include 'config.php';
// Create connection
$conn = mysqli_connect($config['ServerSql'], $config['UsernameSql'], $config['PasswordSql'], $config['DatabaseSql']);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}