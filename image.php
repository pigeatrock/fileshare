<!DOCTYPE html>
<?php require_once 'function.php';require_once 'config.php';require_once 'menu.php'; ?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="web.css" >
        <title>Image</title>
<meta http-equiv="Content-Type" content="text/html;"/>
<script type="text/javascript" src="jquery-2.1.1.min.js"></script>
<script type="text/javascript">
var xOffset = 10; 
var yOffset = 30; 
function preimg(s){
     var para=document.createElement("img");
     para.src=s.href;
     para.setAttribute('id','imgpre');
     var element=document.getElementById("preview");
     element.appendChild(para);
}
function removeimg(){
     var child=document.getElementById("imgpre");
     var element1=document.getElementById("preview");
     element1.removeChild(child);
} 


/*$("#imglist").find("a").hover(function(e) { 
    $("<img id='imgshow' src=\" + this.href + \" />").appendTo("body"); 
    $("#imgshow") 
        .css("top", (e.pageY - xOffset) + "px") 
     .css("left", (e.pageX + yOffset) + "px") 
        .fadeIn("fast"); 
}, function() { 
    $("#imgshow").remove(); 
});
$("#imglist").find("a").mousemove(function(e) { 
   $("#imgshow") 
       .css("top", (e.pageY - xOffset) + "px") 
       .css("left", (e.pageX + yOffset) + "px") 
});*/
</script>
</head>
<body>
	<div id="header">
		<h1>Image</h1>
	 </div>
	    <?php showMenu(); ?>
	<div id="content">
    <table cellpadding="5" class="table2" id="imglist">
    	<tr><th>图片名称</th><th>大小</th><th>上传日期</th><th>上传者IP</th></tr>
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
			case 'image':
				echo "<tr><td style=><a target=\"_blank\" title=\"$file_name[$x]\" href=\"$path_ftp$url_file\" onmouseover=\"preimg(this)\" onmouseout=\"removeimg()\">$file_name[$x]</a></td><td>$size</td><td>$time</td>
				<td><a target=\"_blank\" title=\"$showip\" href=\"ftp://$showip\">$showip</a></td></tr>";
				break;
			
			default:
			
				break;
		}			
	}
	?>
    </table>
   </div>
<div id="preview" style="text-align:center; margin-top:30px;">

</div>
</body>
</html>