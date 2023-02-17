<?php
include_once 'conn.php';
function getKehuxinxiSql(){
    return "select kehumingcheng,shouhuodizhi,shouhuoren,shouhuorenshouji,shouhuorenzuoji from kehuxinxi";
}
function getCanpinxinxiSql(){
    return "select shangpinleibie,shangpinmingcheng, shangpinbianhao, guige from kucun group by shangpinleibie,shangpinmingcheng ,shangpinbianhao, guige";
}
function getXiaoshoudanSql($condition){
    $sql="select xiaoshoudan.* ,round(sum(xiaoshoudanproducts.shuliang*xiaoshoudanproducts.danjia),2) as xiaoshoujine ,round(sum(xiaoshoudanproducts.shuliang*xiaoshoudanproducts.danjia-xiaoshoudanproducts.shuliang*xiaoshoudanproducts.jinjia)-xiaoshoudan.yunfei,2) as xiaoshoulirun from xiaoshoudan left join xiaoshoudanproducts on xiaoshoudan.id=xiaoshoudanproducts.xiaoshoudanid where 1=1";
    return $sql;
}
function getCommonScript(){
    global $conn;
    $sql=getKehuxinxiSql();
    $query=$conn->query($sql);
    $rowscount=$query->num_rows;
    $arr = $query->fetch_all(MYSQLI_BOTH);
    $sql2=getCanpinxinxiSql();
    $query2=$conn->query($sql2);
    $rowscount2=$query2->num_rows;
    $arr2 = $query2->fetch_all(MYSQLI_BOTH);
    ?>
<script src="https://cdn.staticfile.org/jquery/3.1.1/jquery.min.js"></script>
<link href="select2.css" rel="stylesheet" />
<script src="select2.js"></script>
<script src="https://cdn.bootcss.com/select2/4.0.6-rc.1/js/i18n/zh-CN.js"></script>


<script language="javascript">
    var arrKehuxinxi={};
    var arrCanpinxinxi=[];
    <?php
    		if($rowscount>0)
            {
                for ($fi=0;$fi<$rowscount;$fi++)
                {
                    $name=$arr[$fi]['kehumingcheng'];
                     
                    echo "arrKehuxinxi['".$name."']={};\r\n";
                    echo "arrKehuxinxi['".$name."']['shouhuodizhi']='".$arr[$fi]['shouhuodizhi']."';\r\n";
                    echo "arrKehuxinxi['".$name."']['shouhuoren']='".$arr[$fi]['shouhuoren']."';\r\n";
                    echo "arrKehuxinxi['".$name."']['shouhuorenshouji']='".$arr[$fi]['shouhuorenshouji']."';\r\n";
                    echo "arrKehuxinxi['".$name."']['shouhuorenzuoji']='".$arr[$fi]['shouhuorenzuoji']."';\r\n";
                }
            }
            if($rowscount2>0)
            {
                echo "var oProc;\r\n";
                for ($fi=0;$fi<$rowscount2;$fi++)
                {      
                     
                    $name=$arr2[$fi]['shangpinmingcheng'];
                    $biaohao=$arr2[$fi]['shangpinbianhao'];
                    $guige=$arr2[$fi]['guige'];
                    echo "oProc={'shangpinmingcheng':'$name','shangpinbianhao':'$biaohao','guige':'$guige'};\r\n";
                    echo "arrCanpinxinxi.push(oProc);\r\n";
                    //echo "if(!arrCanpinxinxi['$name']) arrCanpinxinxi['$name']={};\r\n";
                    //echo "if(!arrCanpinxinxi['$name']['$biaohao']) arrCanpinxinxi['$name']['$biaohao']={};\r\n";
                    //echo "if(!arrCanpinxinxi['$name']['$biaohao']['$guige']) arrCanpinxinxi['$name']['$biaohao']['$guige']={};\r\n";
                }
            }
    ?>
    function grow(name)
    {  
        var sGrow=document.form1.growfield.value;
        var aVal=sGrow.split("&");
        var oVal={};
        for(var i=0;i<aVal.length;i++){
            if(!aVal[i])continue;
            aPair=aVal[i].split('=');
            oVal[aPair[0].trim()]=aPair[1].trim();
        }
        var val=document.form1[name].value;
        oVal[name]=val;
        if(name==="kehumingcheng" && arrKehuxinxi[val]){
            document.form1["shouhuodizhi"].value=arrKehuxinxi[val]["shouhuodizhi"];  
            document.form1["shouhuoren"].value=arrKehuxinxi[val]["shouhuoren"];
            document.form1["shouhuorenshouji"].value=arrKehuxinxi[val]["shouhuorenshouji"];
            document.form1["shouhuorenzuoji"].value=arrKehuxinxi[val]["shouhuorenzuoji"];
            oVal["shouhuodizhi"]=arrKehuxinxi[val]["shouhuodizhi"];
            oVal["shouhuoren"]=arrKehuxinxi[val]["shouhuoren"];
            oVal["shouhuorenshouji"]=arrKehuxinxi[val]["shouhuorenshouji"];
            oVal["shouhuorenzuoji"]=arrKehuxinxi[val]["shouhuorenzuoji"];
        }
        document.form1.growfield.value="";
        for (var key in oVal) {
            if(document.form1.growfield.value){
                document.form1.growfield.value+="&"+key+"="+oVal[key];
            }else{
                document.form1.growfield.value+=key+"="+oVal[key];
            }
        }

    }
    function navigateTo(toUrl,id,editType)
    {
        var val =document.form1.growfield.value;
        var url=toUrl+"editType="+editType+"&"+val;
        location.href=url;
    }
    function printControl(id,header,footer){
        //var oldstr = document.body.innerHTML;
			var headstr = "<html><head><title>"+header+"</title><link rel='stylesheet' href='css.css' type='text/css'></head><body>";
			var footstr = "</body></html>";
			//执行隐藏打印区域不需要打印的内容
			//document.getElementById("otherpho").style.display="none";
			var printData = document.getElementById(id).innerHTML; //获得 div 里的所有 html 数据
			var wind = window.open("", "newwin",
					"toolbar=no,scrollbars=yes,menubar=no");
			wind.document.body.innerHTML = headstr + printData + footstr;
			wind.print();
			//打印结束后，放开隐藏内容
			//document.getElementById("otherpho").style.display="block";
			//wind.close();
			//window.document.body.innerHTML = oldstr;
    }
	function OpenScript(url,width,height)
    {
        var win = window.open(url,"SelectToSort",'width=' + width + ',height=' + height + ',resizable=1,scrollbars=yes,menubar=no,status=yes' );
    }
    function OpenImageFile(field,width,height)
    {
        var sFile=document.getElementById("shouhuopingju").files[0];
        var src = window.URL.createObjectURL(sFile);
        var oImg=document.getElementById('previewImage')
        oImg["src"]=src; 
        openModal();
        
    }
    function OpenDialog(sURL, iWidth, iHeight)
    {
        var oDialog = window.open(sURL, "_EditorDialog", "width=" + iWidth.toString() + ",height=" + iHeight.toString() + ",resizable=no,left=0,top=0,scrollbars=no,status=no,titlebar=no,toolbar=no,menubar=no,location=no");
        oDialog.focus();
    }
    function openModal() {
        document.getElementById('myModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('myModal').style.display = "none";
    }
    function getShangPinMingChengList(sShangPinBianHao){
        var arrRes={};
        for(var i=0;i<arrCanpinxinxi.length;i++){
            if(!sShangPinBianHao || arrCanpinxinxi[i].shangpinbianhao===sShangPinBianHao ){
                arrRes[arrCanpinxinxi[i].shangpinmingcheng]="";
            }
        }
        return [""].concat(Object.keys(arrRes));
       //var arrNames= Object.keys(arrCanpinxinxi);
       //return arrNames;
    }
    function getShangPinBianHaoList(sShangPinMingCheng){
        var arrRes={};
        for(var i=0;i<arrCanpinxinxi.length;i++){
            if(!sShangPinMingCheng || arrCanpinxinxi[i].shangpinmingcheng===sShangPinMingCheng ){
                arrRes[arrCanpinxinxi[i].shangpinbianhao]="";
            }
        }
        return [""].concat(Object.keys(arrRes));
        /*if(arrCanpinxinxi[sShangPinMingCheng]){
            return Object.keys(arrCanpinxinxi[sShangPinMingCheng]);
        }else{
            return [];
        }*/
    }
    function getShangPinGuigeList(sShangPinMingCheng,sShangPinBianHao){
        
        if(sShangPinMingCheng && sShangPinBianHao){
            var aGuige={};
            for(var i=0;i<arrCanpinxinxi.length;i++){
                if(arrCanpinxinxi[i].shangpinmingcheng===sShangPinMingCheng && arrCanpinxinxi[i].shangpinbianhao===sShangPinBianHao){
                    aGuige[arrCanpinxinxi[i].guige]="";
                }
            }
            return [""].concat(Object.keys(aGuige));
        }else{
            return [""];
        }
    }
    function onCanPinXinXiChange(){
        var sShangPinMingCheng=document.getElementById('shangpinmingcheng').value;
        var sShangPinBianHao=document.getElementById('shangpinbianhao').value;
        var sGuige=document.getElementById('guige').value;
        initCanPinXinXi(sShangPinMingCheng,sShangPinBianHao,sGuige,true);
    }
    function checkProduct(){
        if(document.form1.danjia.value===""){
            alert("单价不能为空");
            document.form1.danjia.focus();
            return false;
        }
        if(document.form1.shuliang.value===""){
            alert("数量不能为空");
            document.form1.shuliang.focus();
            return false;
        }
        
        if(document.form1.shangpinmingcheng.value===""){
            alert("商品名称不能为空");
            document.form1.shangpinmingcheng.focus();
            return false;
            /*if(!confirm('确定要输入空的商品名称？')){
                document.form1.shangpinmingcheng.focus();
                return false;
            }*/
        }
        if(document.form1.shangpinbianhao.value==""){
            alert("商品型号不能为空");
            document.form1.shangpinbianhao.focus();
            return false;
            /*if(!confirm('确定要输入空的商品型号吗？')){
                document.form1.shangpinbianhao.focus();
                return false;
            }*/
        }
        if(document.form1.guige.value==""){
            alert("包装规格不能为空");
            document.form1.guige.focus();
            return false;
            /*if(!confirm('确定要输入空的商品型号吗？')){
                document.form1.guige.focus();
                return false;
            }*/
        }
        return true;
    }
    function initCanPinXinXi(sShangPinMingCheng,sShangPinBianHao,sGuige,fromChange){
        var fChange=function(){
            onCanPinXinXiChange();
        };
        
        if(!fromChange){
            var inList=false;
            //this is the initial value
            for(var i=0;i<arrCanpinxinxi.length;i++){
                if(arrCanpinxinxi[i].shangpinmingcheng===sShangPinMingCheng && arrCanpinxinxi[i].shangpinbianhao===sShangPinBianHao
                    && arrCanpinxinxi[i].guige===sGuige ){
                    inList=true;
                    break;
                }
            }
            if(!inList){
                var oProd={"shangpinmingcheng":sShangPinMingCheng,"shangpinbianhao":sShangPinBianHao,"guige":sGuige}
                arrCanpinxinxi.push(oProd);
            }
        }
        jQuery("#shangpinmingcheng").empty();
        document.getElementById('shangpinmingcheng').onchange=fChange;
        var arrCanPin=getShangPinMingChengList(sShangPinBianHao);
        arrCanPin.sort();
        arrCanPin.forEach(function(sName){
            var disp=sName;
            if(!disp)disp="空";
            var oOption=new Option(disp,sName);
            if(sName===sShangPinMingCheng){
                oOption.selected=true;
            }
            document.getElementById('shangpinmingcheng').options.add(oOption);
        });
        //document.getElementById('shangpinbianhao').options=[];
        jQuery("#shangpinbianhao").empty();
        document.getElementById('shangpinbianhao').onchange=fChange;
        var arrBiaoHao=getShangPinBianHaoList(sShangPinMingCheng);
        arrBiaoHao.sort();
        arrBiaoHao.forEach(function(sName){
            var disp=sName;
            if(!disp)disp="空";
            var oOption=new Option(disp,sName);
            if(sName===sShangPinBianHao){
                oOption.selected=true;
            }
            document.getElementById('shangpinbianhao').options.add(oOption);
        });
        //document.getElementById('guige').options=[];
        jQuery("#guige").empty();
        document.getElementById('guige').onchange=fChange;
        var arrGuige=getShangPinGuigeList(sShangPinMingCheng,sShangPinBianHao);
        arrGuige.sort();
        arrGuige.forEach(function(sName){
            var disp=sName;
            if(!disp)disp="空";
            var oOption=new Option(disp,sName);
            if(sName===sGuige){
                oOption.selected=true;
            }
            document.getElementById('guige').options.add(oOption);
        });
        document.getElementById('shangpinmingcheng').value=sShangPinMingCheng;
        document.getElementById('shangpinbianhao').value=sShangPinBianHao;
        document.getElementById('guige').value=sGuige;
    }
</script>
    <?php
}
?>