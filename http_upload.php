
<?php
require 'function.php';
require 'config.php';
//�ϴ������ݿ�
    $num=strlen($_FILES["file"]["name"]);
   if($num>35){
    echo "<h1 style=\"text-align:center\">"."�ϴ��ļ������ȴ���35,���޸��ļ������ϴ�<br/>"."3�����ת����ҳ������"."<h1>";
    header( "refresh:3;url=./index.php" );
   }else{
   $file=DIR_PATH . $_FILES["file"]["name"];
    if (file_exists($file))
      {
      echo "<h1 style=\"text-align:center\">".$_FILES["file"]["name"] . " �Ѿ�����. <br/>"."2�����ת����ҳ������"."</h1>";
      header( "refresh:2;url=./index.php" );
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      DIR_PATH . $_FILES["file"]["name"]);    
 //�������ݵ����ݿ�
      connectDB($_FILES["file"]["name"]);
  
 //������ҳ header('Location: ./index.php');     
      }
}
?>
