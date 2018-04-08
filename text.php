<!DOCTYPE html>
<?php require_once 'function.php';require_once 'config.php';require_once 'menu.php'; ?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="web.css" >
        <title>Text</title>
<meta http-equiv="Content-Type" content="text/html;"/>
</head>
<body>
	<div id="header">
		<h1>Text</h1>
	 </div>
	    <?php showMenu(); ?>
	<div id="content">
    <table cellpadding="5" class="table2">
    	<tr><th>名称</th><th>大小</th><th>上传日期</th><th>上传者IP</th></tr>
     <?php
$path_ftp=FTP_PATH;
$path_dir=DIR_PATH;
$file_name=scandir(DIR_PATH);
	for($x=2;$x<count($file_name);$x++)
	{
		$url_file=rawurlencode($file_name[$x]);
		$stat=stat(DIR_PATH.$file_name[$x]);
		$size=format_size($stat["size"]);
		$path_dir_file=$path_dir.$file_name[$x];
		$fileType=getFileInfo($path_dir_file);
		$putpic=putPic($fileType);
		$showip=showIP($file_name[$x]);
		$time = date("Y-m-d H:i:s",$stat["ctime"]);
		switch ($fileType) {
			case 'text':
				echo "<tr><td><a target=\"_blank\" title=\"$file_name[$x]\" href=\"$path_ftp$url_file\">$putpic&nbsp&nbsp&nbsp$file_name[$x]</a></td><td>&nbsp&nbsp$size</td><td>&nbsp&nbsp$time</td>
				<td><a target=\"_blank\" title=\"$showip\" href=\"ftp://$showip\">&nbsp&nbsp$showip</a></td></tr>";
				break;
			
			default:
			
				break;
		}			
	}
	?>
    </table>
   </div>
</body>
</html>