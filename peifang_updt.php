<?php

include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
$ndate =date("Y-m-d");
$addnew=getPostValue("addnew");
$fromProducts=getValue("fromProducts");
$id=getValue("id");
if(!$id){
	$id=getPostValue("id");
}
checkSessionTimeOut();
$msg="";
$err="";
if ($addnew=="1" )
{
	
	echo "id=".$id;

 	$title=getPostValue("title");
    $describe=getPostValue("describe");
    $sql="update peifang set title='".$title."',peifang_describe='".$describe."'";

    if ($_FILES["file"]["error"] > 0)
    {
        $msg= "Error: " . $_FILES["file"]["error"] . "<br />";
    }
    else
    {
        $msg=$msg."Upload: " . $_FILES["file"]["name"] . "<br />";
        $msg= $msg."Type: " . $_FILES["file"]["type"] . "<br />";
        $msg= $msg."Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
        $msg= $msg."Stored in: " . $_FILES["file"]["tmp_name"];
        $err="";
        if ($_FILES["file"]["size"] < 20000000)
        {
            
            if (file_exists("peifang/" . $title))
            {
                $err=$err.$title. " already exists. ";
                $msg=$msg."error=".$err;
            }
            else
            {
                move_uploaded_file($_FILES["file"]["tmp_name"],
                "peifang/" . $title.".pdf");
                $msg=$msg."Stored in: " . "peifang/" . $title.".pdf";
                $sql=$sql.",filename='peifang/".$title.".pdf'";
            }
        }
        else
        {
            $err=$err. "Invalid file";
		}
    }
    $sql=$sql. " where id=".$id;
    global $conn;
    $rtn=$conn->query($sql);
    if($rtn){
        echo "<script>javascript:alert('修改成功');location.href='peifang_updt.php?id=".$id."';</script>";
    }else{
        $err=$err.$conn->error;
    }

}else if($fromProducts!=1){

	$record=$table->getRecord("peifang",$id);
	$table->setCurrentRecord($record);
}else{
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>修改配方</title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>
<?php echo getCommonScript();?>
<body>
<p>修改配方 <?php echo $ndate; ?></p>
<p> <?php 
if($err){
    echo($err);
}; 
?></p>
<script language="javascript">
function check()
{
    if(document.form.title.value==""){alert("请输入标题");document.form.title.focus();return false;}
  	if(document.form.filename.value==""){alert("请选择文件");document.form.filename.focus();return false;}
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
<form id="form" name="form" method="post" action="" enctype="multipart/form-data">

<input name="id" type="hidden" id="id" value="<?php echo $id;?>" />
<label for="title">标题:</label>
<input style="width: 60%; height: 100%" name="title" type="text" id="title" value="<?php echo $record["title"];?>" />
<p></p>
<label for="describe">描述:</label>
<input  style="width: 60%; height: 100%" name="describe" type="text" id="describe"  value="<?php echo $record["peifang_describe"];?>"/>
<p></p>
<label for="file">文件（pdf）:</label>
<input  style="width: 98%; height: 100%" type="file" name="file" id="file" onchange="return changeTitle();"/> 
<p></p>
<input type="hidden" name="addnew" value="1" />
<input type="submit" name="Submit" value="修改" />
</form>
<p>&nbsp;</p>
</body>
</html>

