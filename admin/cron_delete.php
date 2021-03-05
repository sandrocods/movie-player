<?php
include '.././include/header.php';
include '.././include/koneksi.php';
$sql = "SELECT * FROM `movie_play` ORDER BY id ASC LIMIT 1";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        @$id = $row["id"];
        @$link = $row["link"];
        @$moviename = $row["movie_name"];
    }
    $sql1 = "DELETE FROM movie_play WHERE id = $id";
    mysqli_query($conn, $sql1);

    $sql1 = "INSERT INTO `history` (`id`, `movie_name`, `link`, `date`) VALUES ( '$id', '$moviename', '$link', current_timestamp())";
    if (mysqli_query($conn, $sql1)) {
    } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);

}

?>
<meta http-equiv="refresh" content="120;url= <?php echo  $config['BaseUrl']; ?>">';