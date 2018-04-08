
<?php
require 'function.php';
require 'config.php';
//上传到数据库
    $num=strlen($_FILES["file"]["name"]);
   if($num>35){
    echo "<h1 style=\"text-align:center\">"."上传文件名长度大于35,请修改文件名后上传<br/>"."3秒后跳转回主页。。。"."<h1>";
    header( "refresh:3;url=./index.php" );
   }else{
   $file=DIR_PATH . $_FILES["file"]["name"];
    if (file_exists($file))
      {
      echo "<h1 style=\"text-align:center\">".$_FILES["file"]["name"] . " 已经存在. <br/>"."2秒后跳转回主页。。。"."</h1>";
      header( "refresh:2;url=./index.php" );
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      DIR_PATH . $_FILES["file"]["name"]);    
 //保存数据到数据库
      connectDB($_FILES["file"]["name"]);
  
 //返回首页 header('Location: ./index.php');     
      }
}
?>
