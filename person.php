<!DOCTYPE html>
<?php require_once 'function.php';require_once 'config.php';require_once 'menu.php'; ?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="web.css" >
        <title>个人中心</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
</head>
<body>
     <div id="header">
		<h1>你的IP地址是：<?php echo getIp(); ?></h1>
	 </div>
	    <?php showMenu() ?>
	<div id="content">
		<table cellpadding="5" class="table1">
	<tr><th>类型</th><th>自己上传的文件</th><th>大小</th><th>上传日期</th></tr>
<?php
$path_ftp=FTP_PATH;
$path_dir=DIR_PATH;
$ip=getIp();
$result=showFile($ip);
	while($row = mysql_fetch_array($result))
	{
		$url_file=rawurlencode($row['file_name']);
		$stat=stat(DIR_PATH.$row['file_name']);
		$size=format_size($stat["size"]);
		$path_dir_file=$path_dir.$row['file_name'];
		$fileType=getFileInfo($path_dir_file);
		$putpic=putPic($fileType);
		$time = date("Y-m-d H:i:s",$stat["ctime"]);
				echo "<tr><td>$putpic</td><td><a target=\"_blank\" title=\"$row[file_name]\" href=\"$path_ftp$url_file\">$row[file_name]</a></td><td>$size</td><td>$time</td>
				</tr>";
	}
?>
</table>
</div>
</body>
</html>