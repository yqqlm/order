<?php

include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
checkSessionTimeOut();
$ndate =date("Y-m-d");
$addnew=getPostValue("addnew");
$fromProducts=getPostValue("fromProducts");
$title=getPostValue("title");

$msg="";
$err="";
$sql="";
if ($addnew=="1" )
{
    $title=getPostValue("title");
    $describe=getPostValue("describe");

    if ($_FILES["file"]["error"] > 0)
    {
        $msg= "Error: " . $_FILES["file"]["error"] . "<br />";
    }
    else
    {
        $filename=$_FILES["file"]["name"];
        $msg=$msg."Upload: " . $_FILES["file"]["name"] . "<br />";
        $msg= $msg."Type: " . $_FILES["file"]["type"] . "<br />";
        $msg= $msg."Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
        $msg= $msg."Stored in: " . $_FILES["file"]["tmp_name"];
        $err="";
        if ( $_FILES["file"]["size"] < 20000000)
        {
            
            if (file_exists("peifang/" . $filename))
            {
                $err=$err.$title. " already exists. ";
                $msg=$msg."error=".$err;
            }
            else
            {
                move_uploaded_file($_FILES["file"]["tmp_name"],
                "peifang/" .$filename);
                $msg=$msg."Stored in: " . "peifang/" . $filename;
                
                $sql="insert into peifang (title,peifang_describe,filename) values('".$title."','".$describe."','peifang/".$filename."')";
                global $conn;
                $rtn=$conn->query($sql);
                if($rtn){
                    echo "<script>javascript:alert('添加成功');location.href='peifang_add.php';</script>";
                }else{
                    $err=$err. $rtn;
                }
                
            }
            
        }
        else
        {
            $err=$err. "Invalid file";
        }

    }

}else if($fromProducts!="1"){
	$record=$table->getRecord("peifang","");
	$table->setCurrentRecord($record);
}
if($msg){
    echo $msg;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>添加配方</title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>
<?php echo getCommonScript();?>
<body>
<p>添加配方</p>
<p>今天是： <?php echo "  ".$ndate; ?></p>

<script language="javascript">
function check()
{
	if(document.form.title.value==""){alert("请输入名称");document.form1.title.focus();return false;}
}
function changeTitle()
{
	if(document.form.file.value!==""){
        var a=document.form.file.value.split(".");
        a=a[0].split("\\");
        var v=a[a.length-1];
        document.form.title.value=v;
    }
}

</script>
<form id="form" name="form" method="post" action="peifang_add.php" enctype="multipart/form-data">
<label for="title">标题:</label>
<input name="title" type="text" id="title" value="" />
<label for="describe">描述:</label>
<input name="describe" type="text" id="describe"  value=""/>
<label for="file">文件（pdf）:</label>
<input type="file" name="file" id="file" onchange="return changeTitle();"/> 
<input type="hidden" name="addnew" value="1" />
<input type="submit" name="Submit" value="添加" />
</form>

</body>
</html>

