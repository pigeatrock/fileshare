<?php 
session_start(); 
?> 
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="/favicon.ico"/>
<link rel="bookmark" href="/favicon.ico"/>
<title>极享</title>
<?php require_once 'config.php'; require_once 'function.php'; require_once 'menu.php'; ?>
<link rel="stylesheet" type="text/css" href="web.css" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<style type="text/css">
</style>
<script type="text/javascript" src="jquery-2.1.1.min.js"></script>
<script type="text/javascript">
var submitOK="true";
function validate()
{
	var filename=document.getElementById("file").value;
	filename=filename.substr(filename.lastIndexOf('\\')+1);
	var param={};
	param['file_name']=filename;
	if(filename.length>35)
	{
		alert("文件名应该小于35，请修改后上传！");
	}
	else{
    $.get('file_exist.php',param,function(data){
       switch(data)
       {case "1":
           alert("文件已存在！请重新选择。");
              break;
         case "2":
         document.getElementById('submit').click();break;
        }
         });
        }
}
</script>
</head>
<body>	
<div id="container">

	<div id="header">
		<h1>极享</h1>
	</div>
	
	<?php showMenu(); ?>
    <div id="content">
    <table cellpadding="5" class="table1">
    	<tr><th>类型</th><th>文件名称</th><th>大小</th><th>上传日期</th><th>上传者IP</th></tr>
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
				echo "<tr><td>$putpic</td><td><a target=\"_blank\" title=\"$file_name[$x]\" href=\"$path_ftp$url_file\">$file_name[$x]</a></td><td>$size</td><td>$time</td>
				<td><a target=\"_blank\" title=\"$showip\" href=\"ftp://$showip\">$showip</a></td></tr>";
	}
	?>
    </table>
  
    <div id="progress" class="progress" style="margin:15px;display:none">
        <div class="bar" style="width:0%;"></div>
        <div class="label">0%</div>
    </div>
    <div id="filebut">
    <form id="upload-from" action="http_upload.php" method="post" enctype="multipart/form-data" style="margin:15px 0" target="hidden_iframe">
    <input type='text' name='textfield' id='textfield' class='txt'/>  
    <input type='button' class='btn' value='浏览...' onclick="document.getElementById('file').click();"/>
    <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="test" />
    <input type="file" name="file" class="file" id="file" onchange="document.getElementById('textfield').value=this.value" />
    <input type="button"  class="btn1" value="上传" onclick="validate()"/>
    <input type="submit"  name="submit" id="submit" style="display:none"/>
    </form>
    </div>
        <iframe id="hidden_iframe" name="hidden_iframe" src="about:blank" style="display:none;"></iframe>
    </div>
    <script type="text/javascript">
    function fetch_progress(){
        $.get('progress.php',{ '<?php echo ini_get("session.upload_progress.name"); ?>' : 'test'},function(data){
                var progress = parseInt(data);
		$('#progress .label').html(data + '%');
		$('#progress .bar').css('width', progress + '%');
		if(progress < 100){
			setTimeout('fetch_progress()', 1000);
		}else{
			$('#progress .label').html('完成!');
			location.reload(true);
		}
	     }, 'html');
    }
    $('#upload-from').submit(function(){
        $('#progress').show();
        setTimeout('fetch_progress()', 1000);
    });
    </script>
</div>
</body>
</html>