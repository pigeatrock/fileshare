<?php
require 'config.php';
$filename = DIR_PATH.$_GET["file_name"];
if (file_exists($filename))
      {
        echo "1";
    }
    else{
    	echo "2";
    }
?>