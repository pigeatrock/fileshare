<?php
require_once 'config.php';
$conn = ftp_connect(FTP_PATH) or die("Could not connect");
ftp_login($conn,"anonymous","");
$remote_file=$_FILES["file"]["name"];
$local_file=$_FILES["file"]["tmp_name"];
if (file_exists(DIR_PATH . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
        ftp_put($conn, $remote_file, $local_file, FTP_BINARY);
        ftp_close($conn);
      }
      header('Location: ./index.php');
?>