<?php
// Installer Sandro Movies
function getVar($text)
{
    echo $text . ': ';
    $var = trim(fgets(STDIN));
    return $var;
}
function save($fileName, $line, $opt)
{
    $file = fopen($fileName, $opt);
    fwrite($file, $line);
    fclose($file);
}
echo "
======================== Configuration ==============================
                     _                                  _           
 ___  __ _ _ __   __| |_ __ ___    _ __ ___   _____   _(_) ___  ___ 
/ __|/ _` | '_ \ / _` | '__/ _ \  | '_ ` _ \ / _ \ \ / / |/ _ \/ __|
\__ \ (_| | | | | (_| | | | (_) | | | | | | | (_) \ V /| |  __/\__ \
|___/\__,_|_| |_|\__,_|_|  \___/  |_| |_| |_|\___/ \_/ |_|\___||___/
                                                                   
======================== Configuration ==============================
\n";

// Database Initialization
$dbHost = getVar("Database Host ");
$dbUser = getVar("Database Username ");
$dbPass = getVar("Database Password ");
echo "\n";
$connection = mysqli_connect($dbHost, $dbUser, $dbPass);
if ($connection) {
    echo "[" . date("d-m-Y") . " " . date("h:i:s") . "] [ INFO ] Connection Database successfully \n";
    sleep(1);
    // Creating Database
    if (mysqli_query($connection, "CREATE DATABASE movie_sandro")) {
        echo "[" . date("d-m-Y") . " " . date("h:i:s") . "] [ INFO ] Database created successfully\n";
    } else {
        echo "[" . date("d-m-Y") . " " . date("h:i:s") . "] [ INFO ] Error creating database: " . mysqli_error($connection) . "\n";
    }

    $database = mysqli_select_db($connection, "movie_sandro");

    // Execute Script
    $sql = "CREATE TABLE `history` (
        `id` int(11) NOT NULL,
        `movie_name` varchar(200) NOT NULL,
        `link` varchar(2000) NOT NULL,
        `date` datetime NOT NULL DEFAULT current_timestamp()
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $sql .= "CREATE TABLE `movie_play` (
        `id` int(11) NOT NULL,
        `link` varchar(2000) NOT NULL,
        `movie_name` varchar(200) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $sql .= "CREATE TABLE `user_play` (
        `id` int(11) NOT NULL,
        `key` varchar(200) NOT NULL,
        `username` varchar(200) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $sql .= "INSERT INTO `user_play` (`id`, `key`, `username`) VALUES
    (20, 'MVSADMIN', 'Sandro Putraa');";

    $sql .= "ALTER TABLE `history`
    ADD PRIMARY KEY (`id`);";

    $sql .= "ALTER TABLE `user_play`
    ADD PRIMARY KEY (`id`);";

    $sql .= "ALTER TABLE `history`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";

    $sql .= "ALTER TABLE `movie_play` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);";

    $sql .= "ALTER TABLE `user_play`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  COMMIT;";

    if (mysqli_multi_query($connection, $sql)) {
        echo "[" . date("d-m-Y") . " " . date("h:i:s") . "] [ INFO ] Table created successfully\n";
    } else {
        echo "[" . date("d-m-Y") . " " . date("h:i:s") . "] [ INFO ] Error: " . $sql . "\n" . mysqli_error($connection);
        die();
    }

    mysqli_close($connection);

    echo "[" . date("d-m-Y") . " " . date("h:i:s") . "] [ INFO ] Creating INI File Configuration \n";
    $link = getVar("Base Url Application ");
$iniSetting = "
[application]
BaseUrl         = " . $link . "

[database]
ServerSql       = " . $dbHost . "
UsernameSql     = " . $dbUser . "
PasswordSql     = " . $dbPass . "
DatabaseSql     = movie_sandro
";
save(__DIR__ . "/include/setting.ini", $iniSetting, "w");
echo "Process Successfuly\n Key Login : MVSADMIN \n Login : ". $link."/admin\n\n";
} else {
    print_r($connection);
}
