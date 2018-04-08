<?php require_once 'config.php';?>
<?php
//格式化文件大小
function format_size($size) {
    $prec = 3;
    $size = round($size);
    $units = array(
            0 => " B ",
            1 => " KB",
            2 => " MB",
            3 => " GB",
            4 => " TB"
    );
    if ($size == 0)
        return str_repeat(" ", $prec) . "0$units[0]";
    $unit = min(4, floor(log($size) / log(2) / 10));
    $size = $size * pow(2, -10 * $unit);
    $digi = $prec - 1 - floor(log($size) / log(10));
    $size = round($size * pow(10, $digi)) * pow(10, -$digi);
    return $size . $units[$unit];
}
//获取用户IP地址
function getIp(){
   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
       $ip = getenv("HTTP_CLIENT_IP");
   else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
       $ip = getenv("HTTP_X_FORWARDED_FOR");
  else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
       $ip = getenv("REMOTE_ADDR");
  else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
           $ip = $_SERVER['REMOTE_ADDR'];
       else
           $ip = "unknown";
       return($ip);
}
//获得文件类型
function getFileInfo($filename){
     $finfo= finfo_open(FILEINFO_MIME);
     $finfo_file=finfo_file($finfo,$filename);
     $fileType=explode("/", $finfo_file);
     return $fileType['0'];
    finfo_close($finfo);
}
//根据文件属性放图标
function putPic($fileType){
  switch ($fileType){
    case 'text':
      return "<img src=\"sourse\pic/text.png\">";
      break;
    case 'video':
      return "<img src=\"sourse\pic/video.png\">";
      break;
    case 'audio':
      return "<img src=\"sourse\pic/audio.png\">";
      break;
    case 'image':
      return "<img src=\"sourse\pic/image.png\">";
      break;
    case 'application':
      return "<img src=\"sourse\pic/app.png\">";
      break;
    default:
      return "<img src=\"sourse\pic/other.png\">";
      break;
  }
}
//保存上传文件的IP
function connectDB($file_name){
    $ip=getIp();
      $con = mysql_connect(DB_IP,DB_USER,DB_PW);
    if (!$con)
     {
      die('Could not connect: ' . mysql_error());
     }
     mysql_select_db(DB_NAME, $con);
     mysql_query("INSERT INTO ip (IP, file_name) 
VALUES ('$ip', '$file_name')");
     mysql_close($con);
  }
  
  //选取指定上传文件的IP
  function showIP($file_name){
     $con = mysql_connect(DB_IP,DB_USER,DB_PW);
    if (!$con)
     {
      die('Could not connect: ' . mysql_error());
     }
     mysql_select_db(DB_NAME, $con);
     $result = mysql_query("SELECT * FROM ip
WHERE file_name='$file_name'");
     $row=mysql_fetch_array($result);
     return $row[0];
     mysql_close($con);
  }
  //选取指定IP的文件
  function showFile($ip){
     $con = mysql_connect(DB_IP,DB_USER,DB_PW);
    if (!$con)
     {
      die('Could not connect: ' . mysql_error());
     }
     mysql_select_db(DB_NAME, $con);
     $result = mysql_query("SELECT * FROM ip
      WHERE IP='$ip'");
     return $result;
     mysql_close($con);
  }
    ?>