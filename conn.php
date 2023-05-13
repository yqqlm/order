<?php
$url= (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$isTest=false;
if(strpos($url,"localhost")>0 || strpos($url,"ordertest")>0){
	$isTest=true; 	
}
$host='localhost';
$user='root';
$password='Lucy2rico';
$database=$isTest?"test":'order';
$aProduct=[];
$log_sql=true;
if($database==="test"){
	//echo "Test DB +".$url;
}
ini_set("display_errors","On");

//ini_set('session.gc_maxlifetime', "1800"); // 秒 
//ini_set("session.cookie_lifetime","1800"); // 秒 

error_reporting(E_ALL);
$conn_inner=new mysqli($host,$user,$password,$database);
if ($conn_inner->connect_error) {
	die("数据库连接错误" . $conn->connect_error);
}
$conn=new Connection();
class Connection {
	var $error;
	public function write_log($data){
		global $log_sql;
		if(!$log_sql){
			return;
		}
		//设置目录时间
		$years = date('Y-m');
		$days = date('Y-m-d');
		//设置路径目录信息
		$url  = './public/log/texlog/'.$years.'/'.$days.'_request_log.txt';
		//取出目录路径中目录(不包括后面的文件)
		$dir_name = dirname($url);
		//如果目录不存在就创建
		if(!file_exists($dir_name)) {
		//iconv防止中文乱码
			$res = mkdir(iconv("UTF-8","GBK",$dir_name),0777,true);
		}
		$fp = fopen($url,"a");//打开文件资源通道 不存在则自动创建
		fwrite($fp,$data."\r\n");//写入文件
		fclose($fp);//关闭资源通道
	}
	function query($sql){
		global $conn_inner;
		$suc= $conn_inner->query($sql);
		if(!$suc){
			$error=$conn_inner->error;
			$this->write_log("Failed:".$sql);
			$this->write_log("Error:".$error);
		}else{
			$this->write_log("Suc:".$sql);
		}
		return $suc;
	}
}
//$sql = "set names 'gb2312'";
//$result = $conn->query($sql);
$arrProds= array();
function checkSessionTimeOut(){
	if(isset($_SESSION['expiretime'])) {

		$_SESSION['expiretime'] = time() + 18; // 刷新时间戳
		
	}
}
function checkSessionTimeOut2(){
	if(isset($_SESSION['expiretime'])) {
		if($_SESSION['expiretime'] < time()) {
			unset($_SESSION['expiretime']);
			header('Location: logout.php'); // 登出
			exit(0);
		}
	}
}
/*$timer = new Timer();
//注册 - 3s - 重复触发
$timer->insert(array('expire' => 3, 'repeat' => true, 'action' => function(){
	checkSessionTimeOut2();
}));
$timer->monitor(false);*/
function getMultipleSelect($name,$vals){

	$select_id =$name."_hidden";
	$select_val =getValue($select_id) ;
	echo "<input type='hidden' id='$select_id' name='$select_id' value='$select_val' /> \r\n";
	echo "<select name='$name' id='$name' value=''  multiple='multiple' style='width:350px;height:25px' > \r\n";
	$arr =explode(',',$select_val);
	for($x=0;$x<count($vals);$x++){
	  echo "<option value='$vals[$x]' ";
	  if(in_array($vals[$x], $arr)) echo "selected";
	  echo "> $vals[$x]";
	  echo "</option> \r\n";
	}
	echo "</select> \r\n";
	echo "<script> \r\n";

	echo "$('#$name').select2();\r\n";
	
	echo "var fChange=function(){\r\n" ;
	echo "  var o=document.getElementById('$name').getElementsByTagName('option'); \r\n";
	echo   "var all='';\r\n";
	echo "  for(var i=0;i<o.length;i++){\r\n";
	echo "  if(o[i].selected){\r\n";
	echo "		  all+=o[i].value+','; \r\n";
	echo "  }\r\n";
	echo "  }\r\n";
	echo " all = all.substr(0, all.length - 1);//去掉末尾的逗号\r\n";
	echo "  document.getElementById('$select_id').value=all;\r\n";
	echo "}\r\n";
	
	echo "document.getElementById('$name').onchange=fChange;\r\n";
  echo "</script>";
}
function getoption($col,$value)
{
	
	if(array_key_exists("options",$col)){
		
		$v=$col["options"];
		for($i=0;$i<count($v);$i++)	
		{
			if(isset($value) && $value==$v[$i])
			{
				echo "<option value='".$v[$i]."' selected>".$v[$i]."</option>";
			}else{
				echo "<option value='".$v[$i]."'>".$v[$i]."</option>";
			}
			
		}
	}else if(array_key_exists("fromtable",$col)){
		
		$ntable=$col["fromtable"];
		$nzd=$col["fromfield"];
		
		global $conn;
		$sql="select ".$nzd." from ".$ntable;

		if(isset($col["group"])){
			$sql=$sql."  ".$nzd;
		}
		if(!isset($col["noid"])){
			$sql=$sql." order by id desc";
		}else{
			$sql=$sql." order by ".$nzd;
		}
		
		
		$query=$conn->query($sql);
		$arr = $query->fetch_all(MYSQLI_BOTH);
		$hasNull=false;
		if ($query->num_rows > 0) 
		{
			for($i=0;$i<$query->num_rows;$i++)	
			{
				  $v=$arr[$i];
				  $disp=$v[0];
				  if($v[0]===""){
					$disp="空";
					$hasNull=true;
				  }
				  if(isset($value) && $value==$v[0])
				  {
				  	echo "<option value='".$v[0]."' selected>".$disp."</option>";
				  }else{
					echo "<option value='".$v[0]."'>".$disp."</option>";
				  }
			}
		}else{
			//echo "<option value='ddd'>ddd</option>";
		}
		if(isset($col["null"]) && $col["null"] && !$hasNull){
			if(isset($value) && $value=="")
			{
				echo "<option value='' selected>空</option>";
			}else{
				echo "<option value='' >空</option>";
			}
		}
	}
	
}
function getoption2($ntable,$nzd)
{
	?>
	
	<?php
		global $conn;
		$sql="select ".$nzd." from ".$ntable." order by id desc";
		
		$query=$conn->query($sql);
		$rowscount=$query->num_rows;
		$arr = $query->fetch_all();
		if($rowscount>0)
		{
			//echo "count=".$rowscount;
			for ($fi=0;$fi<$rowscount;$fi++)
			{
				?>
				<option value="<?php echo $arr[$fi][0];?>" <?php 
				
				if(isset($_GET[$nzd]) && $_GET[$nzd]==$arr[$fi][0])
				{
					echo "selected";
				}
				?>><?php echo $arr[$fi][0];?></option>
				<?php
			}
		}
}
function getitem($ntable,$nzd,$tjzd,$ntj)
{
	global $conn;
	if(isset($_GET[$tjzd]) && $_GET[$tjzd]!="")
	{
		$sql="select ".$nzd." from ".$ntable." where ".$tjzd."='".$ntj."'";
		$query=$conn->query($sql);
		$rowscount=$query->num_rows;
		$arr = $query->fetch_all();
		if($rowscount>0)
		{
			echo "value='".$arr[0][0]."'";
		}
	}
}
function getValue($key){
	return isset($_GET[$key])?$_GET[$key]:"";
}
function getPostValue($key){
	return isset($_POST[$key])?$_POST[$key]:"";
}

function getProductList($bClear){
	if($bClear){
		$aProduct.reset();
	}
	?>
	<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse">  
	<tr>
		<td width="25" bgcolor="#CCFFFF">序号</td>
		<td bgcolor='#CCFFFF'>商品型号</td><td bgcolor='#CCFFFF'>商品名称</td><td bgcolor='#CCFFFF'>规格</td><td bgcolor='#CCFFFF'>产地</td><td bgcolor='#CCFFFF'>保质�?</td><td bgcolor='#CCFFFF'>备注</td>
		<td width="120" align="center" bgcolor="#CCFFFF">库存</td>
		<td width="120" align="center" bgcolor="#CCFFFF">添加时间</td>
		<td width="70" align="center" bgcolor="#CCFFFF">操作</td>
	</tr>
	<?php 
	for ($i=0;$fi<sizeof($aProduct);$fi++)
	{
		$v=$aProduct[$i];
		?>
		<tr>
		  <td width="25"><?php echo $i+1;?></td>
		  <td><?php echo $v["shangpinbianhao"];?></td>
		  <td><?php echo $v["shangpinmingcheng"];?></td>
		  <td><?php echo $v["guige"];?></td>
		  <td><?php echo $v["beizhu"];?></td>
		  <td width="120" align="center"><?php echo $v["addtime"]; ?></td>
		  <td width="70" align="center"><a href="del.php?id=<?php echo $v["id"] ?> onclick="return confirm('真的要删除？')">删除</a> </td>
		<tr>
		  <?php 
	}
	?>
	<?php 
}
function getNameList($col,$table){
	

	global $conn;
	$sql="select ".$col." from ".$table." group by ".$col;

	
	$query=$conn->query($sql);
	$arr = $query->fetch_all(MYSQLI_BOTH);
	
	if ($query->num_rows > 0) 
	{
		for($i=0;$i<$query->num_rows;$i++)	
		{
			$v=$arr[$i];
			if(isset($v[0]) && $v[0])
			{
				if($i===0){
					echo "{ value:'".$v[0]."' ,text:'".$v[0]."'}";
				}else{
					echo ",{ value:'".$v[0]."' ,text:'".$v[0]."'}";
				}
			
			}
		}
	}
	
}
function isChuKu($id){
	global $conn;
	$sqltest="select * from kucunhistory where xiaoshoudanid=$id";
	$query=$conn->query($sqltest);         
	if(!$query){
		return "true";
	}else{
		$arr = $query->fetch_all(MYSQLI_BOTH);
		$rowscount=count($arr);
		if($rowscount>0){
			return "true";
		}else{
			return "false";
		}
	}
}
function isRuKu($id){
	global $conn;
	$sqltest="select * from kucunhistory where caigoudanid=$id";
	$query=$conn->query($sqltest);         
	if(!$query){
		return "true";
	}else{
		$arr = $query->fetch_all(MYSQLI_BOTH);
		$rowscount=count($arr);
		if($rowscount>0){
			return "true";
		}else{
			return "false";
		}
	}
}
function getSqlDateByType($type,$col,$begin,$end){
	$sql="";
	if ($type==="本年度" || !$type){
		$date=date("Y");
		$bd=$date."-01-01";
		$ed=$date."-12-31";
		$sql="$col>='".$bd."' and $col<='".$ed."'";
	}else if ($type==="本月"){
		$date=date("Y-m");
		$bd=$date."-01";
		$ed=$date."-31";
		$sql="$col>='".$bd."' and $col<='".$ed."'";
	}else if ($type==="时间段"){	
		$bd=$begin;
		$ed=$end;
		$sql="$col>='".$bd."' and $col<='".$ed."'";
	}else if ($type==="上年度"){	
		$date=date("Y")-1;
		$bd=$date."-01-01";
		$ed=$date."-12-31";
		$sql="$col>='".$bd."' and $col<='".$ed."'";
	}
	return $sql;
}
function getSQLDate($col){
	return getSqlDateByType(getValue("shijiantype"),$col,getValue("qishi"),getValue("zhongzhi"));
}
function getSelect($name,$table,$field,$noid,$width,$hasNull){
	if($width)
		echo "<select name='$name' id='$name' style='width:$width"."px;height:25px'>";
	else 
		echo "<select name='$name' id='$name' >";
	$opts=array();
	$opts["fromtable"]=$table;
	$opts["fromfield"]=$field;
	$opts["noid"]=$noid;
	$opts["null"]=$hasNull;
	getoption($opts,getValue("$name"));
	
  	echo "</select>";
	echo  "<script>$('#$name').select2()</script>";
}
function getOptByVal($val){
	if(strpos($val, "#") === 0){
		$opt=" = ";
	}else{
		$opt=" like ";
	}
	return $opt;
}
function getDateSelect(){
	echo "<select name='shijiantype' id='shijiantype' >\r\n";
	
	if(getValue("shijiantype")==="本年度"  || !getValue("shijiantype")){
	  echo "<option value='本年度' selected>本年度</option>";
	}else{
	  echo "<option value='本年度' >本年度</option>";
	}
	if(getValue("shijiantype")==="本月"){
	  echo "<option value='本月' selected>本月</option>";
	}else{
	  echo "<option value='本月' >本月</option>";
	}
	if(getValue("shijiantype")==="无限制"){
	  echo "<option value='无限制' selected>无限制</option>";
	}else{
	  echo "<option value='无限制' >无限制</option>";
	}
	if(getValue("shijiantype")==="时间段"){
	  echo "<option value='时间段' selected>时间段</option>";
	}else{
	  echo "<option value='时间段' >时间段</option>";
	}
	if(getValue("shijiantype")==="上年度"){
		echo "<option value='上年度' selected>上年度</option>";
	  }else{
		echo "<option value='上年度' >上年度</option>";
	  }
  echo "</select>";
  echo "&nbsp;起始时间：<input name='qishi' id='qishi' type='date' value='";
  if(getValue("qishi")){echo getValue("qishi");} else{echo date('Y-m-d');} ;
  echo "'/>";
  echo "&nbsp;终止时间：<input name='zhongzhi' id='zhongzhi' type='date' value='";
  if(getValue("zhongzhi")){echo getValue("zhongzhi");} else{echo date('Y-m-d');}; 
  echo "'/>";
  echo "&nbsp;";
}
function login($username,$pwd,$cx){

	global $conn;
	if ($username!="" && $pwd!="")
	{
		$sql="select * from allusers where username='$username' and pwd='$pwd' and cx='".$cx."'";
		$query=$conn->query($sql);;
		$rowscount=$query->num_rows;
		if($rowscount>0)
		{
			$_SESSION['username']=$username;
			
			$_SESSION['cx']=$cx;
			$_SESSION['expiretime'] = time() + 18; // 刷新时间戳
			global $conn;
			$sql="select alias from allusers where username='".$username."'";
			$query=$conn->query($sql);
			$arr = $query->fetch_all(MYSQLI_BOTH);
			$_SESSION['alias']= $arr[0][0];
			return true;
		}
		else
		{
			return false;
		}
	}
	
	return false;
}
function getLoginContext($isPost=false){
	if(!$isPost){
		$context=$_GET["LoginContex"];
		
	}else{
		$context=$_POST["LoginContex"];
	}
	$context = json_decode($context,true);
    return $context;
}
function initLoginSession($isPost=false){
	$context = getLoginContext($isPost);
    $suc=login($context["username"], $context["password"], $context["role"]);
    return $suc;
}
function updateKucunDanjiaById($id,$value)
{
	global $conn;
	$sql="UPDATE kucun SET danjia = $value WHERE id=$id";
	$suc=$conn->query($sql);
	if(!$suc){
		return "更新库存单价失败, id=$id,error=$conn->error";
	}else{
		return "";
	}
}
function updateKucunDanjia($type)
{
	global $conn;
	$sql="select id,danjia,shangpinmingcheng, shangpinbianhao,guige from kucun";
	$suc=$conn->query($sql);
	if(!$suc){
		return $conn->error;
	}
	$arr = $suc->fetch_all(MYSQLI_BOTH);
	$length=count($arr);
	for($x=0;$x<$length;$x++){
		$row=$arr[$x];
		$id=$row["id"];
		$mc=$row["shangpinmingcheng"];
		$bh=$row["shangpinbianhao"];
		$gg=$row["guige"];
		if($type==="xiaoshou"){
			$danjia=getDanjiaWithXiaoShou($mc,$bh,$gg);
		}else{
			$danjia=getDanjiaWithCaiGou($mc,$bh,$gg);
		}
		
		$rtn=updateKucunDanjiaById($id,$danjia);
		if($rtn!==""){
			return $rtn;
		}
	}
	return "";
}
function getDanjiaWithXiaoShou($mc,$bh,$gg){
	global $conn;
	$sqlwhere="where xiaoshoudanproducts.shangpinmingcheng='$mc' and ";
	$sqlwhere=$sqlwhere."xiaoshoudanproducts.shangpinbianhao='$bh' and ";
	$sqlwhere=$sqlwhere."xiaoshoudanproducts.guige='$gg' and ";
	$sqlwhere=$sqlwhere."xiaoshoudanproducts.danjia>0 ";
	$sql="SELECT xiaoshoudanproducts.danjia, xiaoshoudan.dingdandate as xsdate FROM xiaoshoudanproducts left JOIN xiaoshoudan on xiaoshoudanproducts.xiaoshoudanid=xiaoshoudan.id $sqlwhere ORDER by xsdate desc LIMIT 1,1";
	//echo "$sql";
	$suc=$conn->query($sql);
	if(!$suc){
		return 0;
	}
	$arr = $suc->fetch_all(MYSQLI_BOTH);
	$length=count($arr);
	if($length!==1){
		return 0;
	}
	return $arr[0]["danjia"];
}
function getDanjiaWithCaiGou($mc,$bh,$gg){
	global $conn;
	$sqlwhere="where caigoudanproducts.shangpinmingcheng='$mc' and ";
	$sqlwhere=$sqlwhere."caigoudanproducts.shangpinbianhao='$bh' and ";
	$sqlwhere=$sqlwhere."caigoudanproducts.guige='$gg' and ";
	$sqlwhere=$sqlwhere."caigoudanproducts.danjia>0 ";
	$sql="SELECT caigoudanproducts.danjia, caigoudan.addtime as xsdate FROM caigoudanproducts left JOIN caigoudan on caigoudanproducts.caigoudanid=caigoudan.id $sqlwhere ORDER by xsdate desc LIMIT 1,1";

	//echo "$sql";
	$suc=$conn->query($sql);
	if(!$suc){
		return 0;
	}
	$arr = $suc->fetch_all(MYSQLI_BOTH);
	$length=count($arr);
	if($length!==1){
		return 0;
	}
	return $arr[0]["danjia"];
}
function addUser($username,$pwd,$cx){
	global $conn;
	$sql="select * from allusers where username='$username' and cx='$cx'";
	$query=$conn->query($sql);
	if(!$query){
		return $conn->error;
	}
	$rowscount=$query->num_rows;
	if($rowscount>0)
	{
		return "用户已经存在";
	}
	else
	{
		$sql="insert into allusers(username,pwd,cx) values('$username','$pwd','$cx')";
		$suc= $conn->query($sql);;
		if(!$suc){
			return $conn->error;
		}	
	}
	return "";
}
	 
?>