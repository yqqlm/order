<?php
include_once 'conn.php';
ini_set("display_errors","On");
error_reporting(E_ALL);
if(!isset($_SESSION)){
    session_start();
}
$table=new Tables();
class Tables {
    
    var $daysInMonth=array();
    var $tableCheckList=array();
    var $tableSearchAliasList=array();
    var $tableSearchList=array();
    var $tableKey=array();
    var $tableKeyType=array();
    var $arrXiaoShouDanDescribe = array(
        array("name"=>"id","title"=>"订单编号","type"=>"readonlystring"),
        array("name"=>"addtime","title"=>"订单创建日期","type"=>"readonlystring","width"=>"120","isDetailOnly"=>true),
        array("name"=>"dingdandate","title"=>"下单日期","type"=>"date","width"=>"120","default"=>"getCurrentDate"),
        array("name"=>"kehumingcheng","title"=>"客户名称","type"=>"select","fromtable"=>"kehuxinxi","fromfield"=>"kehumingcheng","noid"=>true),
        array("name"=>"needfapiao","title"=>"是否已开发票","type"=>"select","options"=>array('否','是'),"isDetailOnly"=>true),
        array("name"=>"shouhuodizhi","title"=>"收货地址","type"=>"","isDetailOnly"=>true),
        array("name"=>"shouhuoren","title"=>"收货人","type"=>"","isDetailOnly"=>true),
        array("name"=>"shouhuorenshouji","title"=>"收货人手机","type"=>"","isDetailOnly"=>true),
        array("name"=>"shouhuorenzuoji","title"=>"收货人座机","type"=>"","isDetailOnly"=>true),
        array("name"=>"yaoqiudaohuoshijian","title"=>"要求到货时间","type"=>"date","isDetailOnly"=>true),
        array("name"=>"shifouxiehuo","title"=>"是否卸货","type"=>"select","options"=>array('否','是'),"isDetailOnly"=>true),
        array("name"=>"fahuozhuangtai","title"=>"发货状态","type"=>"select","options"=>array('否','是'),"isDetailOnly"=>false),
        array("name"=>"shouhuozhuangtai","title"=>"收货状态","type"=>"select","options"=>array('否','是'),"isDetailOnly"=>true),
        array("name"=>"shouhuopingju","title"=>"收货凭据","type"=>"file","isDetailOnly"=>true),
        array("name"=>"yunfei","title"=>"运费","type"=>"number","isDetailOnly"=>false), 
        array("name"=>"fukuanshijian","title"=>"付款时间","type"=>"date","isDetailOnly"=>false),
        array("name"=>"fukuanfangshi","title"=>"付款方式","type"=>"","isDetailOnly"=>true),
        array("name"=>"fukuanzhuangtai","title"=>"付款状态","type"=>"select","options"=>array('否','是'),"isDetailOnly"=>false,"role"=>array("系统管理员","营业录入员")),
        array("name"=>"fukuanpingju","title"=>"付款凭据","type"=>"file","isDetailOnly"=>true),
        array("name"=>"cydw","title"=>"承运单位","type"=>"","isDetailOnly"=>true),
        array("name"=>"cyr","title"=>"承运人","type"=>"","isDetailOnly"=>true),
        array("name"=>"cyrdh","title"=>"承运人联系电话","type"=>"","isDetailOnly"=>true),
        array("name"=>"xiaoshouyuan","title"=>"销售经理","type"=>"","default"=>"getDefaultXiaoshouyuan"),
        array("name"=>"tianbiaoren","title"=>"填表人","type"=>"","isDetailOnly"=>true,"default"=>"getDefaultTianbiaoren"),
        array("name"=>"beizhu","title"=>"备注","type"=>"","isDetailOnly"=>true),
        array("name"=>"ischuku","title"=>"是否出库","type"=>"function","source"=>"isChuKu","subtype"=>"agg"),
        array("name"=>"xiaoshoujine","title"=>"销售金额","type"=>"","source"=>"getXiaoShouJine","subtype"=>"agg"),
        array("name"=>"xiaoshoulirun","title"=>"销售利润","type"=>"","source"=>"getXiaoShouLirun","subtype"=>"agg","role"=>array("系统管理员")),
        array("name"=>"products","title"=>"产品列表","type"=>"Navigation","NavTable"=>"xiaoshoudanproducts","FKey"=>"xiaoshoudanid")
    );
    var $arrXiaoshoudanProductsDescribe = array(
        array("name"=>"id","title"=>"产品编号","type"=>"readonlystring"),
        array("name"=>"shangpinmingcheng","title"=>"商品名称","type"=>"select"),
        array("name"=>"shangpinbianhao","title"=>"商品型号","type"=>"select"),
        array("name"=>"guige","title"=>"规格","type"=>"select"),
        array("name"=>"shuliang","title"=>"数量(公斤)","type"=>"number"),
        array("name"=>"danjia","title"=>"单价(每公斤)","type"=>"number"),
        array("name"=>"xiaoshoudanid","title"=>"订单编号","type"=>"readonlystring"),
        array("name"=>"beizhu","title"=>"备注:","type"=>""),
        array("name"=>"jinjia","title"=>"进价(每公斤)","type"=>"number","nullable"=>true,"role"=>array("系统管理员"))
    );
    var $arrXiaoshoudanProducts2Describe = array(
        array("name"=>"id","title"=>"产品编号","type"=>"readonlystring"),
        array("name"=>"zhizhaoshang","title"=>"制造商","type"=>"readonlystring"),
        array("name"=>"shangpinleibie","title"=>"商品类别","type"=>"readonlystring"),
        array("name"=>"shangpinmingcheng","title"=>"商品名称","type"=>"select"),
        array("name"=>"shangpinbianhao","title"=>"商品型号","type"=>"select"),
        array("name"=>"guige","title"=>"规格","type"=>"select"),
        array("name"=>"shuliang","title"=>"数量(公斤)","type"=>"number"),
        array("name"=>"danjia","title"=>"单价(每公斤)","type"=>"number"),
        array("name"=>"xiaoshoudanid","title"=>"订单编号","type"=>"Navigation","NavTable"=>"xiaoshoudan","useValAsTitle"=>""),
        array("name"=>"beizhu","title"=>"备注:","type"=>""),
        array("name"=>"jinjia","title"=>"进价(每公斤)","type"=>"number","nullable"=>true,"role"=>array("系统管理员"))
    );
    var $arrNameManageDescribe = array(
        
        array("name"=>"shangpinmingcheng2","title"=>"商品名称","type"=>""),
        array("name"=>"shangpinbianhao2","title"=>"商品型号","type"=>""),
        array("name"=>"guige2","title"=>"规格","type"=>""),
        array("type"=>"newline"),
        array("name"=>"shangpinmingcheng","title"=>"新商品名称","type"=>"select"),
        array("name"=>"shangpinbianhao","title"=>"新商品型号","type"=>"select"),
        array("name"=>"guige","title"=>"新规格","type"=>"select"),

    );
    var $arrKucunDescribe = array(
        array("name"=>"id","title"=>"编号:","type"=>"readonlystring"),
        array("name"=>"shangpinleibie","title"=>"商品类别","type"=>"select","fromtable"=>"splb","fromfield"=>"name"),
        array("name"=>"shangpinmingcheng","title"=>"商品名称","type"=>"string"),
        array("name"=>"shangpinbianhao","title"=>"商品型号","type"=>"string"),
        array("name"=>"guige","title"=>"包装规格","type"=>"string"),
        array("name"=>"zhizhaoshang","title"=>"制造商","type"=>"select","fromtable"=>"zhizhaoshang","fromfield"=>"name","noid"=>true),
        array("name"=>"shuliang","title"=>"数量(公斤)","type"=>"number"),
        array("name"=>"danjia","title"=>"单价(每公斤)","type"=>"number","role"=>array("系统管理员")),
        array("name"=>"monthin","title"=>"本月入库","type"=>"function","source"=>"getMonthIn"),
        array("name"=>"monthout","title"=>"本月出库","type"=>"function","source"=>"getMonthOut"),
        array("name"=>"monthinout","title"=>"本月库存变化","type"=>"function","source"=>"getMonthInOut"),
        array("name"=>"lastKucun","title"=>"getTitle","type"=>"function","source"=>"getLastPandian"),
        array("name"=>"beizhu","title"=>"备注","type"=>"")
    );
    var $arrKucunHistoryDescribe = array(
        array("name"=>"id","title"=>"编号","type"=>"readonlystring","display"=>false),
        array("name"=>"shangpinleibie","title"=>"商品类别","type"=>"select","display"=>false),
        array("name"=>"shangpinmingcheng","title"=>"商品名:","type"=>"select"),
        array("name"=>"shangpinbianhao","title"=>"商品型号","type"=>"select"),
        array("name"=>"guige","title"=>"包装规格","type"=>"select"),
        array("name"=>"kehumingcheng","title"=>"制造商","type"=>"","display"=>false),
        array("name"=>"shuliang","title"=>"数量(公斤)","type"=>"number"),
        array("name"=>"danjia","title"=>"单价(每公斤)","type"=>"number"),
        array("name"=>"addtime","title"=>"修改时间","type"=>"readonlystring","width"=>"120","display"=>false),
        array("name"=>"beizhu","title"=>"备注","type"=>"")
    );
    var $arrCaiGouDanDescribe = array(
        array("name"=>"id","title"=>"采购单编号:","type"=>"readonlystring"),
        array("name"=>"addtime","title"=>"下单日期:","type"=>"date","width"=>"120","default"=>"getCurrentDate"),
        array("name"=>"gongyingshang","title"=>"供应商:","type"=>"string"),
        array("name"=>"shouhuodizhi","title"=>"收货地址:","type"=>"","isDetailOnly"=>true),
        array("name"=>"shouhuoren","title"=>"收货人:","type"=>"","isDetailOnly"=>true),
        array("name"=>"shouhuorenshouji","title"=>"收货人手机:","type"=>"","isDetailOnly"=>true),
        array("name"=>"yaoqiudaohuoshijian","title"=>"要求到货时间:","type"=>"date","isDetailOnly"=>true),
        array("name"=>"shifouxiehuo","title"=>"是否卸货:","type"=>"select","options"=>array('否','是'),"isDetailOnly"=>true),
        
        array("name"=>"yunfei","title"=>"运费:","type"=>"number"), 
        array("name"=>"fukuanshijian","title"=>"付款时间:","type"=>"date","isDetailOnly"=>true),
        array("name"=>"fukuanfangshi","title"=>"付款方式:","type"=>"","isDetailOnly"=>true),
        array("name"=>"fukuanzhuangtai","title"=>"付款状态:","type"=>"select","options"=>array('否','是')),
        array("name"=>"fukuanpingju","title"=>"付款凭据:","type"=>"file","isDetailOnly"=>true),
        array("name"=>"isruku","title"=>"是否入库","type"=>"function","source"=>"isRuKu","subtype"=>"agg"),
        array("name"=>"caigouyuan","title"=>"采购员:","type"=>""),
        array("name"=>"tianbiaoren","title"=>"填表人:","type"=>""),
        array("name"=>"beizhu","title"=>"备注:","type"=>"","isDetailOnly"=>true),
        array("name"=>"caigoujine","title"=>"总金额:","type"=>"","source"=>"","subtype"=>"agg"),
        array("name"=>"products","title"=>"产品列表","type"=>"Navigation","NavTable"=>"caigoudanproducts","FKey"=>"caigoudanid")
    );
    var $arrCaiGouDanProductsDescribe = array(
        array("name"=>"id","title"=>"产品编号:","type"=>"readonlystring"),
        array("name"=>"shangpinmingcheng","title"=>"商品名称:","type"=>"select"),
        array("name"=>"shangpinbianhao","title"=>"商品型号:","type"=>"select"),
        array("name"=>"guige","title"=>"规格:","type"=>"select"),
        array("name"=>"shuliang","title"=>"数量(公斤)","type"=>"number"),
        array("name"=>"danjia","title"=>"单价(每公斤)","type"=>"number"),
        array("name"=>"caigoudanid","title"=>"采购单编号:","type"=>"readonlystring"),
        array("name"=>"beizhu","title"=>"备注:","type"=>"")
    );
    var $arrCaiGouDanProductsForJinjiaDescribe = array(
        array("name"=>"id","title"=>"产品编号:","type"=>"readonlystring"),
        array("name"=>"shangpinmingcheng","title"=>"商品名称:","type"=>"select"),
        array("name"=>"shangpinbianhao","title"=>"商品型号:","type"=>"select"),
        array("name"=>"guige","title"=>"规格:","type"=>"select"),
        array("name"=>"shuliang","title"=>"数量(公斤)","type"=>"number"),
        array("name"=>"danjia","title"=>"单价(每公斤)","type"=>"number"),
        array("name"=>"addtime","title"=>"采购时间","type"=>"date"),
        array("name"=>"caigoudanid","title"=>"采购单编号:","type"=>"readonlystring"),
        array("name"=>"beizhu","title"=>"备注:","type"=>"")
    );
    var $arrCaiGouDanProducts2Describe = array(
        array("name"=>"id","title"=>"产品编号:","type"=>"readonlystring"),
        array("name"=>"zhizhaoshang","title"=>"制造商","type"=>"readonlystring"),
        array("name"=>"shangpinleibie","title"=>"商品类别","type"=>"readonlystring"),
        array("name"=>"shangpinmingcheng","title"=>"商品名称:","type"=>"select"),
        array("name"=>"shangpinbianhao","title"=>"商品型号:","type"=>"select"),
        array("name"=>"guige","title"=>"规格:","type"=>"select"),
        array("name"=>"shuliang","title"=>"数量(公斤)","type"=>"number"),
        array("name"=>"danjia","title"=>"单价(每公斤)","type"=>"number"),
        array("name"=>"caigoudanid","title"=>"采购单编号:","type"=>"Navigation","NavTable"=>"caigoudan","useValAsTitle"=>""),
        array("name"=>"beizhu","title"=>"备注:","type"=>"")
    );
    var $arrDuiZhangXiaoShou= array(
        array("name"=>"dingdandate","title"=>"下单日期","type"=>"date"),
        array("name"=>"shangpinmingcheng","title"=>"商品名称","type"=>"string","fromtable"=>"kucun","fromfield"=>"shangpinmingcheng"),
        array("name"=>"shangpinbianhao","title"=>"商品型号","type"=>"string","fromtable"=>"kucun","fromfield"=>"shangpinbianhao"),
        array("name"=>"guige","title"=>"规格","type"=>"string","fromtable"=>"kucun","fromfield"=>"guige"),
        array("name"=>"shuliang","title"=>"数量","type"=>"number"),
        array("name"=>"danjia","title"=>"单价","type"=>"number"),
        array("name"=>"jine","title"=>"金额","type"=>"number")
    );
    var $arrHuiKuanDescribe = array(
        array("name"=>"id","title"=>"编号","type"=>"readonlystring"),
        //array("name"=>"kehumingcheng","title"=>"客户名称","type"=>"string"),
        array("name"=>"kehumingcheng","title"=>"客户名称","type"=>"select","fromtable"=>"kehuxinxi","fromfield"=>"kehumingcheng","noid"=>true),
        array("name"=>"huikuanriqi","title"=>"回款日期","type"=>"date"),
        array("name"=>"huikuanjine","title"=>"回款金额","type"=>"number"),
        array("name"=>"xiaoshoudanid","title"=>"订单编号","type"=>"number"),
        array("name"=>"beizhu","title"=>"备注","type"=>"")
    );
    var $arrFaPiaoDescribe = array(
        array("name"=>"id","title"=>"编号","type"=>"readonlystring"),
        //array("name"=>"kehumingcheng","title"=>"客户名称","type"=>"string"),
        array("name"=>"kehumingcheng","title"=>"客户名称","type"=>"select","fromtable"=>"kehuxinxi","fromfield"=>"kehumingcheng","noid"=>true),
        array("name"=>"kaipiaoriqi","title"=>"开票日期","type"=>"date"),
        array("name"=>"jine","title"=>"金额","type"=>"number"),
        array("name"=>"beizhu","title"=>"备注","type"=>"")
    );
    var $arrUserDescribe = array(
        array("name"=>"username","title"=>"登录名","type"=>"string"),
        array("name"=>"oldpwd","title"=>"原始密码","type"=>"password"),
        array("name"=>"newpwd","title"=>"新密码","type"=>"password"),
        array("name"=>"pwdrepeat","title"=>"密码确认","type"=>"password"),
        array("name"=>"alias","title"=>"昵称","type"=>"string")
    );
    var $arrPeiFangDescribe = array(
        array("name"=>"id","title"=>"编号","type"=>"readonlystring"),
        array("name"=>"title","title"=>"名称","type"=>"string"),
        array("name"=>"peifang_describe","title"=>"描述","type"=>"string"),
        array("name"=>"filename","title"=>"文件","type"=>"file","filetype"=>"pdf")
    );
    var $arrKeHuXinXiDescribe = array(
        array("name"=>"kehumingcheng","title"=>"客户名称","type"=>"","noid"=>true,"fromtable"=>"kehuxinxi","fromfield"=>"kehumingcheng"),
        array("name"=>"shouhuodizhi","title"=>"收货地址","type"=>""),
        array("name"=>"shouhuoren","title"=>"收货人","type"=>""),
        array("name"=>"shouhuorenshouji","title"=>"收货人手机","type"=>""),
        array("name"=>"shouhuorenzuoji","title"=>"收货人座机","type"=>""),
        array("name"=>"beizhu","title"=>"备注","type"=>"")
    );
    var $arrZhiZhaoShangDescribe = array(
        array("name"=>"name","title"=>"名称","type"=>"","noid"=>true,"fromtable"=>"zhizhaoshang","fromfield"=>"name"),
        array("name"=>"dizhi","title"=>"地址","type"=>""),
        array("name"=>"tel","title"=>"联系电话","type"=>""),
        array("name"=>"beizhu","title"=>"备注","type"=>"")
    );
    var $arrKeHuZhangDanDescribe = array(
        array("name"=>"kehumingcheng","title"=>"客户名称","type"=>""),
        array("name"=>"jine","title"=>"货款","type"=>"","source"=>""),
        array("name"=>"huikuan","title"=>"回款","type"=>"","source"=>"getKeHuHuiKuan"),
        array("name"=>"qiankuan","title"=>"欠款","type"=>"","source"=>"getKeHuQianKuan"),
        array("name"=>"dingdan","title"=>"对账单","type"=>"function","source"=>"getDuiZhangDanLink")
    );
    var $arrTables = array();
    var $totals=array();
    function __construct(){
        $this->arrTables["xiaoshoudan"]=$this->arrXiaoShouDanDescribe;
        $this->arrTables["xiaoshoudanproducts"]=$this->arrXiaoshoudanProductsDescribe;
        $this->arrTables["kucun"]=$this->arrKucunDescribe;
        $this->arrTables["kucunhistory"]=$this->arrKucunHistoryDescribe;
        $this->arrTables["caigoudan"]=$this->arrCaiGouDanDescribe;
        $this->arrTables["caigoudanproducts"]=$this->arrCaiGouDanProductsDescribe;
        $this->arrTables["caigoudanproducts_jinjia"]=$this->arrCaiGouDanProductsForJinjiaDescribe;
        $this->arrTables["huikuan"]=$this->arrHuiKuanDescribe;
        $this->arrTables["fapiao"]=$this->arrFaPiaoDescribe;
        $this->arrTables["duizhangxiaoshou"]=$this->arrDuiZhangXiaoShou;
        $this->arrTables["user"]=$this->arrUserDescribe;
        $this->arrTables["peifang"]=$this->arrPeiFangDescribe;
        $this->arrTables["kehuxinxi"]=$this->arrKeHuXinXiDescribe;
        $this->arrTables["kehuzhangdan"]=$this->arrKeHuZhangDanDescribe;
        $this->arrTables["zhizhaoshang"]=$this->arrZhiZhaoShangDescribe;
        $this->arrTables["xiaoshoufenxi"]=array();
        $this->arrTables["caigoufenxi"]=array();
        $this->arrTables["namemanage"]=$this->arrNameManageDescribe;
        $this->tableCheckList["huikuan"]=array("kehumingcheng","huikuanriqi","huikuanjine");
        $this->tableCheckList["fapiao"]=array("kehumingcheng","kapiaoriqi","jine");
        $this->tableCheckList["xiaoshoudanproducts"]=array("shangpinmingcheng","shangpinbianhao","guige","shuliang","danjia");
        $this->tableCheckList["caigoudanproducts"]=array("shangpinmingcheng","shangpinbianhao","guige","shuliang","danjia");

        $this->tableSearchList["huikuan"]=array("kehumingcheng");
        $this->tableSearchAliasList["huikuan"]=array("客户名称");
        $this->tableSearchList["fapiao"]=array("kehumingcheng");
        $this->tableSearchAliasList["fapiao"]=array("客户名称");

        $this->tableSearchList["xiaoshoudanproducts"]=array("shangpinmingcheng","shangpinbianhao","guige","id");
        $this->tableSearchAliasList["xiaoshoudanproducts"]=array("商品名称","商品型号","规格","销售单产品编号");

        $this->tableSearchList["caigoudanproducts"]=array("shangpinmingcheng","shangpinbianhao","guige","id");
        $this->tableSearchAliasList["caigoudanproducts"]=array("商品名称","商品型号","规格","采购单产品编号");

        $this->tableSearchList["kehuxinxi"]=array("kehumingcheng");
        $this->tableSearchAliasList["kehuxinxi"]=array("客户名称");
        $this->tableCheckList["kehuxinxi"]=array("kehumingcheng");
        $this->tableKey["kehuxinxi"]="kehumingcheng";
        $this->tableKeyType["kehuxinxi"]="string";

        $this->tableSearchList["zhizhaoshang"]=array("name");
        $this->tableSearchAliasList["zhizhaoshang"]=array("制造商名称");
        $this->tableCheckList["zhizhaoshang"]=array("name");
        $this->tableKey["zhizhaoshang"]="name";
        $this->tableKeyType["zhizhaoshang"]="string";
        
    }
    function setCurrentRecordWithForm($tableName){

        $oTable=$this->arrTables[$tableName];
        $length=count($oTable);
        for($x=0;$x<$length;$x++){
            $col=$oTable[$x];
            if($col["type"]=="Navigation"){
                
            }else{
                $_SESSION["Record"][$col["name"]]=getPostValue($col["name"]);
            }
        }

    }
    function setCurrentRecordField($field,$val){

        $_SESSION["Record"][$field]=$val;
    }
    function getCurrentRecordField($field){

        return $_SESSION["Record"][$field];
    }
    function pushCurrentRecordArrField($field,$val){
        if(!isset($_SESSION["Record"][$field])){
            $_SESSION["Record"][$field]=array();
            
        }
        if(!isset($_SESSION["Record"][$field."_changed"])){
            $_SESSION["Record"][$field."_changed"]=true;
            
        }
        array_push($_SESSION["Record"][$field],$val);
        
    }
    function removeCurrentRecordArrField($field,$val){
        if(!isset($_SESSION["Record"][$field."_changed"])){
            $_SESSION["Record"][$field."_changed"]=true;
            
        }
        array_splice($_SESSION["Record"][$field],$val,1);
    }
    function setCurrentRecordArrField($field,$index,$val,$tableName){
        if($_SESSION["Record"][$field]!=null){
            $oTable=$this->arrTables[$tableName];
            $length=count($oTable);
            for($x=0;$x<$length;$x++){
                $col=$oTable[$x];
                $colName=$col["name"];
                if(isset($val[$colName]) && $this->isCorrectRole($tableName,$colName,$col)){
                    $_SESSION["Record"][$field][$index][$colName]=$val[$colName];
                    if(!isset($_SESSION["Record"][$field."_changed"])){
                        $_SESSION["Record"][$field."_changed"]=true;
                    }
                }
            }
            //$_SESSION["Record"][$field][$index]=$val;
        }
    }
    function getValsFromForm($tableName){
        $vals=array();
        $oTable=$this->arrTables[$tableName];
        $length=count($oTable);
        for($x=0;$x<$length;$x++){
            $col=$oTable[$x];
            if($col["type"]=="Navigation"){
                
            }else{
                $vals[$col["name"]]=getPostValue($col["name"]);
            }
        }
        return $vals;
    }
    function setValsFromPost($tableName){
        $key=$this->getTableKey($tableName);
        if($key && isset($_SESSION["Record"]) && isset($_SESSION["Record"][$key]) ){
            $_SESSION["Record"]["oldkey"]=$_SESSION["Record"][$key];
        }
        
        $oTable=$this->arrTables[$tableName];
        $length=count($oTable);
        for($x=0;$x<$length;$x++){
            $col=$oTable[$x];
            if($col["type"]=="Navigation"){
                
            }else{
                if(isset($_POST[$col["name"]])){
                    $_SESSION["Record"][$col["name"]]=getPostValue($col["name"]);
                }
            }
        }
    }
    function setValsFromGet($tableName){
        
        $oTable=$this->arrTables[$tableName];
        $length=count($oTable);
        for($x=0;$x<$length;$x++){
            $col=$oTable[$x];
            if($this->isFixCol($col)){//$col["type"]=="Navigation" || $col["name"]=="id"  || ($col["name"]=="addtime" && $col["type"]==="readonlystring") ){
                
            }else{
                if(isset($_GET[$col["name"]])){
                    //echo "set ".$col["name"];
                    $_SESSION["Record"][$col["name"]]=getValue($col["name"]);
                    //echo " ".$col["name"]."=".getValue($col["name"]);
                }
            }
        }
    }
    function setCurrentRecord($record)
    {  
        $_SESSION["Record"]=$record;
    }
    function getCurrentRecord()
    {
        return $_SESSION["Record"];
    }
    function getTableMaxId($tableName){
        global $conn;
        $sql="select max(id) from ".$tableName;
        $query=$conn->query($sql);
        $arr = $query->fetch_all(MYSQLI_BOTH);
        return $arr[0][0];
    }
    function uploadFile($tableName,$colName,$keyValue){
        $err="";
        $key=$this->getTableKey($tableName);
        $keyType=$this->getTableKeyType($tableName);

        if($keyValue===""){
            $keyValue=$this->getTableMaxId($tableName);
        }
        if($keyType==="string"){
            $kval="\"".$keyValue."\"";
        }else{
            $kval=$keyValue;
        }
        if(!isset($_FILES[$colName]) || $_FILES[$colName]["size"]===0 || $_FILES[$colName]["size"]==='0'){
            return "";
        }

        $filename=$this->getUploadedFileFullName($tableName,$colName,$keyValue);

        if ($_FILES[$colName]["error"] > 0)
        {
            $msg= "Error: " . $_FILES[$colName]["error"] . "<br />";
            $err=$err.$msg;
        }
        else
        {
           // $filename=$_FILES["file"]["name"];
            $msg="Upload: " . $_FILES[$colName]["name"] . "<br />";
            $msg= $msg." Size: " . ($_FILES[$colName]["size"] / 1024) . " Kb<br />";
            $msg= $msg." Temp Dir: " . $_FILES[$colName]["tmp_name"];
            $msg=$msg." Stored in: " . $filename;
            $sql="update ".$tableName . " set " . $colName . "=\"". $filename . "\" where ".$key."=" . $kval;
            $msg= $msg . " sql: " . $sql ;
            //return $msg;
            if ( $_FILES[$colName]["size"] < 20000000)
            {
                move_uploaded_file($_FILES[$colName]["tmp_name"],$filename);
        
                global $conn;
                $rtn=$conn->query($sql);
                if($rtn){
                    
                }else{
                    $err=$err. $rtn;
                }
                
            }
            else
            {
                $err=$err. "Invalid file";
            }
            
        }
        if($msg!==""){
            echo  "<script>javascript:alert('".$msg."');</script>";
        }
        

        return $err;
    }
    function uploadFiles($tableName,$keyValue){
        $oTable=$this->arrTables[$tableName];
        $length=count($oTable);
        $err="";
        for($x=0;$x<$length;$x++){
            $col=$oTable[$x];
            if($col["type"]!="file"){
                continue;
            }
            $err=$err.$this->uploadFile($tableName,$col["name"],$keyValue);
        }
        return $err;
    }
    function setRecord($tablename,$record,$returnId=false){
        $key=$this->getTableKey($tablename);
        $keyType=$this->getTableKeyType($tablename);
        $opt=$record;
        $useSessionRecord=false;
        if($record==null || $record==="add" || $record==="update"){
            $useSessionRecord=true;
            $record=$_SESSION["Record"];
        }
        $id=isset($record[$key])?$record[$key]:"";
        if($opt==="update"){
            $sql=$this->getUpdateSql($tablename,$record);
        }else if($opt==="add"){
            $sql=$this->getAddSql($tablename,$record);
        }else{
            if(isset($record[$key]) && $record[$key]!=""){
                //if update
                $sql=$this->getUpdateSql($tablename,$record);
            }else{
                //it is add
                $sql=$this->getAddSql($tablename,$record);
            }
        }
        //echo "sql=".$sql;
        global $conn;
            
        $suc=$conn->query($sql);//add or update a db record
        //return "Error: ".$sql."<br>";;
        if(!$suc){
           echo "Error: ".$sql."<br>".$conn->error;
            return  "Error: ".$sql."<br>".$conn->error;
        }
        $oTable=$this->arrTables[$tablename];
        $length=count($oTable);
        
        for($x=0;$x<$length;$x++){
            $col=$oTable[$x];
            if($col["type"]!="Navigation"){
                continue;
            }
            if($useSessionRecord && (!isset($_SESSION["Record"][$col["name"]."_changed"]) ||
             !$_SESSION["Record"][$col["name"]."_changed"]) ){
                continue;
               
            }
            if($id!=""){
                //delete reference records.
                $sql="delete from ".$col["NavTable"]." where ".$col["FKey"]."=".$id;
                $query=$conn->query($sql);
                
            }else{
                $id=$this->getTableMaxId($tablename);
            }
           
            //add all reference records
            $length2=count($record[$col["name"]]);
           
            
            for($y=0;$y<$length2;$y++){
                $sub=$record[$col["name"]][$y];
                $sub[$col["FKey"]]=$id;
                $sub["id"]="";
                
                $this->setRecord($col["NavTable"],$sub);
                
            }
        }
        if($returnId){
            $record[$key]=$id;
        }
        $err=$this->uploadFiles($tablename,$id);
        if($err!==""){
            echo "Error: ".$err;
            return  "Error: ".$err;
         }
        return "";
    }
    function isBaseCol($col){
        if($col["type"]==="function" || (isset($col["subtype"]) && $col["subtype"]="agg")){
            return false;
        }else{
            return true;
        }
    }
    function getRecordFromArray($tableName,$arr,$id)
    {
        global $conn;
        $newRecord=array();
        $oTable=$this->arrTables[$tableName];
        $length=count($oTable);
        for($x=0;$x<$length;$x++){
            $col=$oTable[$x];
            if(!$this->isBaseCol($col)){
                $newRecord[$col["name"]]="";
            }else if($col["type"]!="Navigation"){
                $newRecord[$col["name"]]="";
                if($id!=""){
                    $newRecord[$col["name"]]=$arr[$col["name"]];
                }
            }else{
                $newRecord[$col["name"]]=array();
                if($id!=""){
                    $sql="select * from ".$col["NavTable"]." where ".$col["FKey"]."=".$id;
                    $query=$conn->query($sql);
                    $rowscount2=$query->num_rows;
                    $arr2 = $query->fetch_all(MYSQLI_BOTH);
                    $length2=count($arr2);
                    for($y=0;$y<$length2;$y++){
                        $rec=$this->getRecordFromArray($col["NavTable"],$arr2[$y],$arr2[$y]["id"]);
                        array_push($newRecord[$col["name"]],$rec);
                    }
                }
            }
        }
        return $newRecord;
    }
    function getTableKey($tableName){
        $key="id";
        if(isset($this->tableKey[$tableName])){
            $key=$this->tableKey[$tableName];
        }
        return $key;
    }
    function getTableKeyType($tableName){
        $type="int";
        if(isset($this->tableKeyType[$tableName])){
            $type=$this->tableKeyType[$tableName];
        }
        return $type;
    }
    function getRecord($tableName,$id)
    {
        $key=$this->getTableKey($tableName);
        $keyType=$this->getTableKeyType($tableName);
        global $conn;
        $arr =null;
        if($id!=""){
            
            //fetch data from db
            $sql="select * from ".$tableName." where ".$key."=";//.$id;
            if($keyType==="string"){
                $sql=$sql."'".$id."'";
            }else{
                $sql=$sql.$id;
            }
            $query=$conn->query($sql);
            $rowscount=$query->num_rows;
            $arr = $query->fetch_all(MYSQLI_BOTH);
        }
        $newRecord=$this->getRecordFromArray($tableName,($arr==null)?null:$arr[0],$id);//array();
       
        return $newRecord;
    }
    function getDetailLink($rec,$tableName,$valcol){
        if($tableName==="xiaoshoufenxi"){
            $link= "xiaoshoudan_detail.php?id=".$rec["xiaoshoudanid"];
        }else if($tableName==="caigoufenxi"){
            $link= "caigoudan_detail.php?id=".$rec["caigoudanid"];
        }else {
            $link= $tableName."_detail.php?id=".$rec[$valcol];
        }
        
        return $link;
    }
    function getNavigationTable($tableName,$colName,$editType){
        
        $arrOpts=array();
        if($editType!=0){
            array_push($arrOpts,"del","update");
        }
        $hasOperation=(count($arrOpts)>0);
        ?>
        <table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse">  
            <tr>
            <td width="25" bgcolor="#CCFFFF">序号</td>
            <?php
                $arrRows=$_SESSION["Record"][$colName];
                $oTable=$this->arrTables[$tableName];
                $length=count($oTable);
                for($x=0;$x<$length;$x++){
                    $col=$oTable[$x];
                    if(!$this->isCorrectRole($tableName,$col["name"],$col)){
                
                        continue;
                    }
                    if($col["type"]=="Navigation"){
                        continue;
                    }
                    if(isset($col["width"])){
                        ?>
                        <td width=<?php echo $col["width"];?> bgcolor="#CCFFFF"><?php echo $col["title"];?></td>
                        <?php
                    }else{
                        ?>
                        <td  bgcolor="#CCFFFF"><?php echo $col["title"];?></td> 
                        <?php
                    }
                }
                if($hasOperation){
                    ?>
                    <td  bgcolor="#CCFFFF">
                    <input type="button" name="addFromHead" onclick="navigateTo('<?php echo $tableName; ?>_add.php?',0,'<?php echo $editType; ?>')" value="添加" />
                   <?php
                }
            ?>
            
            </tr>
            <?php 

                $rowscount=count($arrRows);
                
                //$ze=0;

                for($i=0;$i<$rowscount;$i++)                 
                {

                    $row=$arrRows[$i];
                    //$ze=$ze+floatval($arr[$i]["jine"]);
                    ?>
                    <tr>
                        <td width="25"><?php echo $i+1;?></td>
                        <?php
                        for($x=0;$x<$length;$x++){
                            $col=$oTable[$x];
                            $val=$row[$col["name"]];
                            if(!$this->isCorrectRole($tableName,$col["name"],$col)){
                
                                continue;
                            }
                            if($col["type"]=="Navigation"){
                                continue;
                            }
                            if(!isset($col["width"])){
                                ?>
                                <td><?php echo $val;?></td>
                                <?php
                            }else{
                                ?> 
                                <td width=<?php echo $col["width"];?> align="center"><?php echo $val;?></td>
                                <?php                                   
                            }
                        }
                        if(count($arrOpts)){
                        ?>
                            <td width="90" align="center">
                                <?php
                                for($x=0;$x<count($arrOpts);$x++){
                                    if($arrOpts[$x]=="del"){
                                        ?>
                                        <a href="<?php echo $tableName;?>_del.php?id=<?php echo $i;?>&editType=<?php echo $editType;?>" >删除</a>
                                        <?php
                                    }else if($arrOpts[$x]=="update"){
                                        ?>
                                        <input type="button" name="update" onclick="navigateTo('<?php echo $tableName;?>_updt.php?id=<?php echo $i;?>&',<?php echo $i;?>,'<?php echo $editType;?>')" value="修改" />
                                        <?php
                                    }else if($arrOpts[$x]=="detail"){
                                        $link=$this->getDetailLink($row,$tableName,"id");
                                        ?>

                                        <a href="<?php echo $link;?>" >详细信息</a>
                                    <?php   
                                    }else if($arrOpts[$x]=="add"){
                                        ?>
                                        <input type="button" name="add" onclick="navigateTo('<?php echo $tableName;?>_add.php?',0,'<?php echo $editType;?>')" value="添加" />
                                    <?php  
                                    }

                                }
                                ?>
                            </td>
                        <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                  
            ?>
        </table>
        <p>共有记录<?php
                echo $rowscount;
            ?>条

        <?php
       
    }
    function getTableColValue($tableName,$colName,$keyColName,$keyValue){
        global $conn;
        $sql="select ".$colName." from ".$tableName." where ".$keyColName." =".$keyValue."";
        $query=$conn->query($sql);
		$rowscount=$query->num_rows;
		$arr = $query->fetch_all();
		if($rowscount>0)
		{
            return $arr[0][0];
		}else{
            return "";
        }
    }
    function getDefaultValue($name,$rec,$col){
        if(!isset($col["default"])){
            return "";
        }
        if($col["default"]=="getCurrentDate"){
            $value=date("Y-m-d");
        }
        else if($col["default"]=="getDefaultXiaoshouyuan"){
            if($_SESSION['cx']==="销售经理"){
                $value=$_SESSION['alias']?$_SESSION['alias']:$_SESSION['username'];
            }else{
                $value="";
            }
        }
        else if($col["default"]=="getDefaultTianbiaoren"){
            $value=$_SESSION['alias']?$_SESSION['alias']:$_SESSION['username'];
        }
        else if($col["default"]=="getShouHuoDiZhi" && isset($rec)){
            $value=$this->getTableColValue("kehuxinxi","shouhuodizhi","kehumingcheng",$rec["kehumingcheng"]);
        }else if($col["default"]=="getShouHuoRen" && isset($rec)){
            $value=$this->getTableColValue("kehuxinxi","shouhuoren","kehumingcheng",$rec["kehumingcheng"]);
        }else if($col["default"]=="getShouHuoRenShouJi" && isset($rec)){
            $value=$this->getTableColValue("kehuxinxi","shouhuorenshouji","kehumingcheng",$rec["kehumingcheng"]);
        }else if($col["default"]=="getShouHuoRenZuoJi" && isset($rec)){
            $value=$this->getTableColValue("kehuxinxi","shouhuorenzuoji","kehumingcheng",$rec["kehumingcheng"]);
        }else {
            $value=$col["default"];
        }
        return $value;
    }
    function getEditValue($name,$rec,$col){
        $curRec=$rec;
        if($rec==null){
            $curRec=$_SESSION["Record"];
        }
        $value= $curRec[$name];

        if($value==null && isset($col["default"])){
            $value=$this->getDefaultValue($name,$rec,$col);
        }
        return $value;
    }
    function isWarning($rec){
        $isWarning=false;
        if(isset($rec["fukuanzhuangtai"] ) && $rec["fukuanzhuangtai"]!=="是"){
            
            if(!$rec["fukuanshijian"]){
                
                $isWarning=true;
            }else{
                $date=$rec["fukuanshijian"];
                $value=date("Y-m-d");
                if(strtotime($date)<strtotime($value)){  
                    $isWarning=true; 
                }
            }
        }
        return $isWarning;
    }
    function isNoPay($rec){
       
        if(isset($rec["fukuanzhuangtai"] ) && $rec["fukuanzhuangtai"]=="否"){
            
           return true;
        }
        return false;
    }
    function isQianKuan($rec){
       
        if(isset($rec["qiankuan"] ) && $rec["qiankuan"]>0){
            
           return true;
        }
        return false;
    }
    function getDisplayControl($name,$editType,$col,$rec){

        if($editType==0 || $col["type"]=="readonlystring" || (isset($col["updatereadonly"]) && $editType==2) ){
            //display
            if($col["type"]==="button" ){

            }else if($col["type"]==="file" ){
                $value=$this->getEditValue($name,$rec,$col);
                $strImagePath=$this->getImagePath($value);
                ?>
                
                <input type="button"  onclick="javascript:window.open('<?php echo $strImagePath;?>')" value="显示" /> 
               <?php 
                   
                   /* if($value){
                        echo "文件";
                    }else{
                        echo "空";
                    }*/
                ?>
                
                <?php
            }else{
                $value=$this->getEditValue($name,$rec,$col);
                ?>
                <label readonly="readonly" style="width: 98%; height: 100%"  name='<?php echo $name;?>' type='text' id='<?php echo $name;?>'  >
                <?php echo $this->getEditValue($name,$rec,$col);?>
                </>
                <?php
            }
            

        }else if($editType==1 || $editType==2 ){
            
            //update
            if($col["type"]==="button" ){

            
            }else if($col["type"]==="date" ){
                $value=$this->getEditValue($name,$rec,$col);
                if($value)
                    $value=explode(' ', $value)[0];
     
                if($value==null && isset($col["default"]) && $col["default"]=="getCurrentDate"){
                    $value=date("Y-m-d");
                }
                ?>
                <input  onchange="return grow('<?php echo $name;?>');" style="width: 98%; height: 100%"  name='<?php echo $name;?>' type='date' id='<?php echo $name;?>' value='<?php echo $value;?>' />
                <?php
            }else if($col["type"]==="file" ){
                $value=$this->getEditValue($name,$rec,$col);
                $dis="inline";
                if(!$value){
                    $dis="none";
                }
                ?>
                <input type="file"  value="<?php echo $value;?>" name='<?php echo $name;?>' id='<?php echo $name;?>' /> 
                <input type="button" style="display: <?php echo $dis;?>" onclick="javascript:window.open('<?php echo $value;?>')" value="显示" />  
                <?php
            }else if($col["type"]==="select" ){
                $value=$this->getEditValue($name,$rec,$col);
                ?>
                <select onchange="return grow('<?php echo $name;?>');" style="width: 98%; height: 100%"  name='<?php echo $name;?>' id='<?php echo $name;?>' value='<?php echo $value;?>'><?php getoption($col,$value)?></select>
                
                <?php
                    if(!array_key_exists("options",$col)){
                ?>   
                    <script>$("#<?php echo $name;?>").select2()</script>
                <?php     
                    }
                
            }else{
                $value=$this->getEditValue($name,$rec,$col);
                ?>
                <input onchange="return grow('<?php echo $name;?>');" style="width: 98%; height: 100%"  name='<?php echo $name;?>' type='text' id='<?php echo $name;?>' value='<?php echo $value;?>' />
                
                <?php
            }
        }
    }
    function getHistoryBack(){
        
        $historyBack="";
        $curUrl= (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        
        if(strpos($curUrl,"xiaoshoudan_updt")>0 || strpos($curUrl,"xiaoshoudan_detail")>0 ||
            strpos($curUrl,"caigoudan_updt")>0  || strpos($curUrl,"caigoudan_detail")>0   ){
            $historyBack="javascript:location.href='".$_SESSION['ListUrl']."'";
        }
        if(strpos($curUrl,"kucun_updt")>0  ){
            $historyBack="javascript:location.href='".$_SESSION['ListUrl']."'";
        }
        if(strpos($curUrl,"xiaoshoudanproducts_updt")>0 || strpos($curUrl,"xiaoshoudanproducts_add")>0){
            $editType=getValue("editType");
            if($editType==="1" || $editType===1){
                $historyBack="javascript:location.href='xiaoshoudan_add.php?fromProducts=1'";
            }else{
                $historyBack="javascript:location.href='xiaoshoudan_updt.php?fromProducts=1'";
            }
        }
        if(strpos($curUrl,"caigoudanproducts_updt")>0 || strpos($curUrl,"caigoudandanproducts_add")>0){
            $editType=getValue("editType");
            if($editType==="1" || $editType===1){
                $historyBack="javascript:location.href='caigoudan_add.php?fromProducts=1'";
            }else{
                $historyBack="javascript:location.href='caigoudan_updt.php?fromProducts=1'";
            }
        }
        if(!$historyBack){
            //$historyBack="javascript:location.href='".$_SESSION['ListUrl']."'";
            $historyBack="javascript:history.back();";
        }
        return $historyBack;
    }
    function getDetail($tablename,$editType,$rec){
        $historyBack=$this->getHistoryBack();
        if($editType==1){
            $word="添加";
        }else if($editType==2){
            $word="修改";
        }else{
            $word="返回";
        }
        ?>
        <table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse"> 
        <?php 
        
        $oTable=$this->arrTables[$tablename];
        $length=count($oTable);
        $index=0;
        for($x=0;$x<$length;$x++){
            $col=$oTable[$x];
            if(!$this->isCorrectRole($tablename,$col["name"],$col)){
                
                continue;
            }
            if(!$this->isBaseCol($col)){
                continue;
            }
            if(isset($col["display"]) && !$col["display"]){
                continue;
            }
            $index++;
            if($index%2==1){//奇数
                if($col["type"]=="Navigation" ){
                    $index++;//变偶数
                    ?>   
                    <tr>
                    <td colspan=4 width='90%'><?php $this->getNavigationTable($col["NavTable"],$col["name"],$editType)?></td>
                    </tr>
                    <?php 
                }else{
                    ?>
                    <tr>
                    <td width='11%'><?php echo $col["title"];?></td>
                    <td width='39%'><?php echo $this->getDisplayControl($col["name"],$editType,$col,$rec);?></td>        
                    <?php 
                }
            }else{
                //偶数
                if($col["type"]=="Navigation" ){
                    ?>
                    </tr>
                    <tr>
                    <td colspan=4 width='90%'><?php $this->getNavigationTable($col["NavTable"],$col["name"],$editType)?></td>
                    </tr>
                    <?php 
                }else{
                    ?>
                    <td width='11%'><?php echo $col["title"];?></td>
                    <td width='39%'><?php echo $this->getDisplayControl($col["name"],$editType,$col,$rec);?></td>
                    </tr>
                    <?php 
                }
            }
        }
      
        ?>  
            
        </table>
        <table>
        <tr>
        <td colspan="4" align="center">
            <input type="hidden" name="addnew" value="1" />
            <input type="hidden" name="editType" value="<?php echo $editType;?>" />
            <input type="hidden" name="growfield" value="" />
            <?php
                
                if($historyBack===""){
                    $historyBack="javascript:history.back();";
                }
                if($editType===0){
                    ?>
                    <input type="button" name="Submit1" onclick="<?php echo $historyBack;?>" value="返回" />
                    <input type="button" name="Submit2" onclick="javascript:window.print();" value="打印" />
                    <?php
                }else{
                    ?>
                    <input type="submit" name="Submit" value="<?php echo $word;?>" onclick="return check();" />
                    <input type="reset" name="Submit2" value="重置" />
                    <input type="button" name="Submit3" onclick="<?php echo $historyBack;?>" value="返回" />
                    <?php
                }   
            ?>
        </td>
        </tr>
        </table>
        <?php     
        
    }
    function getKeHuHuoKuan($rec){
        global $conn;
        $val=0;
        if(isset($rec["jine"])){
            $val=$rec["jine"];
        }
        return $val;
    }
    function getKeHuHuiKuan($rec){
        global $conn;
        $val=0;
        $kehu=$rec["kehumingcheng"];
        $date=date("Y");
        $bd=$date."-01-01";
        $ed=$date."-12-31";
        $sqldate=" and huikuanriqi>='".$bd."' and huikuanriqi<='".$ed."'";
        $sql="select kehumingcheng ,sum(huikuanjine) as jine from huikuan where kehumingcheng='".$kehu."'".$sqldate." group by kehumingcheng";
        $query=$conn->query($sql);
        $arr = $query->fetch_all(MYSQLI_BOTH);
        if ($query->num_rows > 0) 
        {
            if(!isset($arr[0][1]) || is_null($arr[0][1])){
                $val=0;
            }else{
                $val=$arr[0][1];
            }
        }
        return $val;
    }
    function getKeHuQianKuan($rec){
        $val=$this->getKeHuHuoKuan($rec)-$this->getKeHuHuiKuan($rec);
        //$val=$rec["jine"]-$rec["huikuan"];
        return $val;
    }
    function getDuiZhangDanLink($rec){

        $kehu=$rec["kehumingcheng"];
        $link="<a href=\"duizhangdan_list.php?kehumingcheng=".$kehu."\" >显示对账单</a>";
        return $link;
    }
    function getMonthInOut($rec){
        global $conn;
        $val=0;
        $cpn=$rec["shangpinmingcheng"];
        $cpx=$rec["shangpinbianhao"];
        $cpg=$rec["guige"];
        $month=date("m");
        $date=date("Y-m");
        
        $bd=$date."-01";
        $ed=$date."-31";
        $sql="select sum(shuliang) from kucunhistory where addtime>='".$bd."' and addtime<='".$ed."'";
        $sql=$sql." and shangpinmingcheng='".$cpn."' and shangpinbianhao='".$cpx."' and guige='".$cpg."'";
        
	    $query=$conn->query($sql);
	    $arr = $query->fetch_all(MYSQLI_BOTH);
        if ($query->num_rows > 0) 
        {
            if(!isset($arr[0][0]) || is_null($arr[0][0])){
                $val=0;
            }else{
                $val=$arr[0][0];
            }
        }
        return $val;
    }
    function getLastPandian($rec){
        global $conn;
        $val=0;
        $cpn=$rec["shangpinmingcheng"];
        $cpx=$rec["shangpinbianhao"];
        $cpg=$rec["guige"];
        $month=date("m");
        $date=date("Y-m");
        
        $bd=$date."-01";
        $ed=$date."-31";
        $sql="select shuliang from kucun_pandian where shangpinmingcheng='".$cpn."' and shangpinbianhao='".$cpx."' and guige='".$cpg."'";
        
	    $query=$conn->query($sql);
	    $arr = $query->fetch_all(MYSQLI_BOTH);
        if ($query->num_rows > 0) 
        {
            if(!isset($arr[0][0]) || is_null($arr[0][0])){
                $val=0;
            }else{
                $val=$arr[0][0];
            }
        }
        return $val;
    }
    function getMonthIn($rec){
        global $conn;
        $val=0;
        $cpn=$rec["shangpinmingcheng"];
        $cpx=$rec["shangpinbianhao"];
        $cpg=$rec["guige"];
        $month=date("m");
        $date=date("Y-m");
        
        $bd=$date."-01";
        $ed=$date."-31";
        $sql="select sum(shuliang) from kucunhistory where shuliang>0 and addtime>='".$bd."' and addtime<='".$ed."'";
        $sql=$sql." and shangpinmingcheng='".$cpn."' and shangpinbianhao='".$cpx."' and guige='".$cpg."'";
        
	    $query=$conn->query($sql);
	    $arr = $query->fetch_all(MYSQLI_BOTH);
        if ($query->num_rows > 0) 
        {
            if(!isset($arr[0][0]) || is_null($arr[0][0])){
                $val=0;
            }else{
                $val=$arr[0][0];
            }
        }
        return $val;
    }
    function getMonthOut($rec){
        global $conn;
        $val=0;
        $cpn=$rec["shangpinmingcheng"];
        $cpx=$rec["shangpinbianhao"];
        $cpg=$rec["guige"];
        $month=date("m");
        $date=date("Y-m");
        
        $bd=$date."-01";
        $ed=$date."-31";
        $sql="select sum(shuliang) from kucunhistory where shuliang<0 and addtime>='".$bd."' and addtime<='".$ed."'";
        $sql=$sql." and shangpinmingcheng='".$cpn."' and shangpinbianhao='".$cpx."' and guige='".$cpg."'";
        
	    $query=$conn->query($sql);
	    $arr = $query->fetch_all(MYSQLI_BOTH);
        if ($query->num_rows > 0) 
        {
            if(!isset($arr[0][0]) || is_null($arr[0][0])){
                $val=0;
            }else{
                $val=$arr[0][0]*(-1);
            }
        }
        return $val; 
    }
    function callFunc($fn,$rec){
        $val="";
        if($fn==="getMonthIn"){
            $val=$this->getMonthIn($rec);
        }else if($fn==="getMonthOut"){
            $val=$this->getMonthOut($rec);
        }else if($fn==="getMonthInOut"){
            $val=$this->getMonthInOut($rec);
        }else if($fn==="getLastPandian"){
            $val=$this->getLastPandian($rec);
        }else if($fn==="getCaiGouJine"){
            $val=$this->getCaiGouJine($rec);
        }else if($fn==="getXiaoShouJine"){
            $val=$this->getXiaoShouJine($rec);
        }else if($fn==="getXiaoShouLirun"){
            $val=$this->getXiaoShouLirun($rec);
        }else if($fn==="getKeHuHuiKuan"){
            $val=$this->getKeHuHuiKuan($rec);
        }else if($fn==="getKeHuQianKuan"){
            $val=$this->getKeHuQianKuan($rec);
        }else if($fn==="getDuiZhangDanLink"){
            $val=$this->getDuiZhangDanLink($rec);
        }else if($fn==="getKeHuHuoKuan"){
            $val=$this->getKeHuHuoKuan($rec);
        }else if($fn==="isChuKu"){
            $val=$this->isChuKu($rec);
        }
        else if($fn==="isRuKu"){
            $val=$this->isRuKu($rec);
        }
        return $val;
    }
    function isChuKu($rec){
        
        if(!isset($rec["id"])){
            return "noid";
        }
        if(isChuKu($rec["id"])==="true"){
            return "是";
        }else{
            return "否";
        }
    }
    function isRuKu($rec){
        
        if(!isset($rec["id"])){
            return "noid";
        }
        if(isRuKu($rec["id"])==="true"){
            return "是";
        }else{
            return "否";
        }
    }
    function getColVal($rec,$col){
        $val=0;
        if($col["type"]==="Navigation" && !isset($col["useValAsTitle"])){
            $val=$rec["id"];
        }else if($col["type"]==="function" ){
            $fn=$col["source"];
            $val=$this->callFunc($fn,$rec);
            $rec[$col["name"]]=$val;
            //echo $col["name"]."=".$val;
        }else if($col["type"]==="progress" ){
            $strCol=$col["progressCol"];
            $val=$rec[$strCol];
            $tVal=$this->totals[$strCol];
            
            if($tVal && is_numeric($val) && is_numeric($tVal)){
                $val=intval(($val/$tVal)*100);
            }else{
                $val=0;
            }
            
        }else{
            $val=$rec[$col["name"]];
        }
        return $val;
    }
    function getCaiGouJine($rec){
        global $conn;
        $val=0;
        $id=$rec["id"];

        $sql="select sum(shuliang*danjia) from caigoudanproducts where caigoudanid=".$id;
        
	    $query=$conn->query($sql);
	    $arr = $query->fetch_all(MYSQLI_BOTH);
        if ($query->num_rows > 0) 
        {
            if(!isset($arr[0][0]) || is_null($arr[0][0])){
                $val=0;
            }else{
                $val=$arr[0][0];
            }
        }
        return $val;

    }
    function getXiaoShouJine($rec){
        global $conn;
        $val=0;
        $id=$rec["id"];

        $sql="select sum(shuliang*danjia) from xiaoshoudanproducts where xiaoshoudanid=".$id;
        
	    $query=$conn->query($sql);
	    $arr = $query->fetch_all(MYSQLI_BOTH);
        if ($query->num_rows > 0) 
        {
            if(!isset($arr[0][0]) || is_null($arr[0][0])){
                $val=0;
            }else{
                $val=$arr[0][0];
            }
        }
        return round($val);

    }
    function getXiaoShouLirun($rec){
        global $conn;
        $val=0;
        $id=$rec["id"];

        $sql="select sum(shuliang*danjia-jinjia*shuliang) from xiaoshoudanproducts where xiaoshoudanid=".$id;
        
	    $query=$conn->query($sql);
	    $arr = $query->fetch_all(MYSQLI_BOTH);
        if ($query->num_rows > 0) 
        {
            if(!isset($arr[0][0]) || is_null($arr[0][0])){
                $val=0;
            }else{
                $val=$arr[0][0];
            }
        }
        return round($val);

    }
    function getLastKucunPandianDate(){
        global $conn;
        $val=Null;

        $sql="select date from kucun_pandian_date order by date desc";
        
	    $query=$conn->query($sql);
	    $arr = $query->fetch_all(MYSQLI_BOTH);
        if ($query->num_rows > 0) 
        {
            $val=$arr[0][0];
        }
        return $val;
    }
    function getTitle($col){
        $title=$col["title"];
        if($title==="getTitle" && $col["name"]==="lastKucun"){
            $date=$this->getLastKucunPandianDate();
            if(isset($date) && !is_null($date)){
                $title="上次库存盘点数据(".$date.")";
            }else{
                $title="上次库存盘点数据";
            }
        }
        return $title;
    }
    function getImagePath($val){
        if(!isset($val) || is_null($val)){
            return "";
        }
        return $val;
     
    }

    function printListHeader($tableName,$hasOperation){
        ?>
        <tr>
        <td width="25" bgcolor="#CCFFFF">序号</td>
        <?php
        
            $oTable=$this->arrTables[$tableName];
            $length=count($oTable);
            for($x=0;$x<$length;$x++){
                $col=$oTable[$x];
                if(!$this->isCorrectRole($tableName,$col["name"],$col)){
                    continue;
                }
                if(array_key_exists("isDetailOnly",$col) && $col["isDetailOnly"]){
                    continue;
                }
                if(isset($col["width"])){
                ?>
                <td width=<?php echo $col["width"];?> bgcolor="#CCFFFF"><?php echo $this->getTitle($col);?></td>
                <?php
                }else{
                    ?>
                    <td  bgcolor="#CCFFFF"><?php echo $this->getTitle($col);?></td> 
                    <?php
                }
            }
            if($hasOperation){
                ?>
                <td  bgcolor="#CCFFFF">操作</td> 
                <?php
            }
        ?>
        
        </tr>
        <?php
    }
    function getListData($tableName,$initSql,$parms){
        $oTable=$this->arrTables[$tableName];
        $length=count($oTable);
        global $conn;
        if(isset($parms["data"])){
            $arr=$parms["data"];
        }else{
            if($initSql){
                $sql=$initSql;
            }else{
                $sql="select * from ".$tableName." where 1=1";
                for($x=0;$x<$length;$x++){
                    $col=$oTable[$x];
                    if ($col["type"]!="Navigation" && getPostValue($col["name"])!=""){
                        $val=getPostValue($col["name"]);
                        $sql=$sql." and ".$col["name"]." like '%$val%'";
                    }
                }
                $sql=$sql." order by id desc ";
            }
            
            //echo $sql;
            $query=$conn->query($sql);
            if(!$query){
                return array("error"=>"Error: ".$sql."<br>".$conn->error) ;
            }
            $arr = $query->fetch_all(MYSQLI_BOTH);
        }
        return $arr;
    }
    function getTotal($arr,$colNamesForTotal,$tableName){
        $oTable=$this->arrTables[$tableName];
        $length=count($oTable);
        $totals=array();
        $rowscount=count($arr);
        $totals["count"]=$rowscount;
        for($x=0;$x<count($colNamesForTotal);$x++){
            $totals[$colNamesForTotal[$x]]=0;   
        }
        
        //get total
        for($i=0;$i<$rowscount;$i++)                 
        {
            for($x=0;$x<$length;$x++){
                $col=$oTable[$x];
                if(in_array($col["name"],$colNamesForTotal)){
                    $val=$this->getColVal($arr[$i],$col); 
                    /*if(!isset($totals[$col["name"]])) {
                        $totals[$col["name"]]=0;
                    }*/
                    $totals[$col["name"]]=$totals[$col["name"]]+$val;
                }    
            }
        } 
        return $totals;
    }
    function getPageInfo($rowscount,$rowsPerPage){
        $pagecurrent=getValue("pagecurrent");
        if($rowscount%$rowsPerPage==0)
        {
            $pagecount=$rowscount/$rowsPerPage;
        }
        else
        {
            $pagecount=intval($rowscount/$rowsPerPage)+1;
        }
        if($pagecurrent=="" || $pagecurrent<=0)
        {
            $pagecurrent=1;
        }
        if($pagecurrent>$pagecount)
        {
            $pagecurrent=$pagecount;
        }
        $ddddd=$pagecurrent*$rowsPerPage;
        if($pagecurrent==$pagecount)
        {
            if($rowscount%$rowsPerPage==0)
            {
            $ddddd=$pagecurrent*$rowsPerPage;
            }
            else
            {
            $ddddd=$pagecurrent*$rowsPerPage-$rowsPerPage+$rowscount%$rowsPerPage;
            }
        }
        return array("rowBegin"=>$pagecurrent*$rowsPerPage-$rowsPerPage,"rowEnd"=>$ddddd,"pagecount"=>$pagecount,"pagecurrent"=>$pagecurrent);
    }
    function printRowCell($arr,$i,$col){
        $val=$this->getColVal($arr[$i],$col);   
                
        if($col["type"]=="Navigation"){
            $title=$col["title"];
            if(isset($col["useValAsTitle"])){
                $title=$val;
            }
            ?>
            <td><a href="<?php echo $col["NavTable"];?>_detail.php?id=<?php echo $val;?>" style="color:blue"><?php echo $title;?></a></td>
            <?php 
        }elseif($col["type"]=="file"){
            $strImagePath=$this->getImagePath($val);
            ?>
            <td><input type="button"  onclick="javascript:window.open('<?php echo $strImagePath;?>')" value="显示" />  </td>
            <?php 
        }elseif($col["type"]=="progress"){
            $content='<div style="width:'.$val.'%;background:red;color:white">'.$val.'%</div>';
            ?>
            <td>
                <div style="width:100%;background:gray;"><?php echo $content;?> </div>
            </td>
            <?php 
        }else{
            if(!isset($col["width"])){
                ?>
                <td><?php echo $val;?></td>
                <?php
            }else{
                ?> 
                <td width=<?php echo $col["width"];?> align="center"><?php echo $val;?></td>
                <?php
            }
        }
    }
    function printOptControl($opt,$arr,$i,$key,$tableName){
        if($opt==="del"){
            ?>
            <a href="del.php?id=<?php echo $arr[$i][$key];?>&tablename=<?php echo $tableName;?>" onclick="return confirm('确定删除吗？')">删除</a> 
            <?php
        }else if($opt==="update"){
            $url=$tableName."_updt.php?";
            if(getValue("tablename")){
                $url="table_updt.php?tablename=".$tableName."&tabletitle=".getValue("tabletitle")."&";
            }
            ?>
            <a href="<?php echo $url;?>id=<?php echo $arr[$i][$key];?>">修改</a>
            <?php
        }else if($opt==="detail"){

            $link=$this->getDetailLink($arr[$i],$tableName,$key);
            
            ?>
            <a href="<?php echo $link;?>" >详细</a>
        <?php   
        }else if($opt==="add"){
            ?>
            <a href="<?php echo $tableName;?>_add.php?" >添加</a>
        <?php  
        }
    }
    function printOptCell($arrOpts,$arr,$i,$key,$tableName){
        if(count($arrOpts)){
            ?>
                <td width="90" align="center">
                    <?php
                    for($x=0;$x<count($arrOpts);$x++){
                        $this->printOptControl($arrOpts[$x],$arr,$i,$key,$tableName);
                    }
                    ?>
                </td>
            <?php
        }
    }
    function printRow($arr,$i,$tableName,$key,$arrOpts){
        $oTable=$this->arrTables[$tableName];
        $length=count($oTable);
        $color="";
        if($this->isWarning($arr[$i])){
            $color="style='background:  #f2b59d;'";
        }else if($this->isNoPay($arr[$i]) || $this->isQianKuan($arr[$i]) ){
            $color="style='background:  #e9f29d;'";
        }
        ?>
        <tr <?php echo $color;?>>
            <td width="25"><?php echo $i+1;?></td>
            <?php
            for($x=0;$x<$length;$x++){
                $col=$oTable[$x];
                if(!$this->isCorrectRole($tableName,$col["name"],$col)){
                    continue;
                }
                if(array_key_exists("isDetailOnly",$col) && $col["isDetailOnly"]){
                    continue;
                }
                $this->printRowCell($arr,$i,$col);
            }
            $this->printOptCell($arrOpts,$arr,$i,$key,$tableName);
            ?>
        </tr>
        <?php
    }
    function printPageInfo($pageInfo){
        
        $pagecount=$pageInfo["pagecount"];
        $pagecurrent=$pageInfo["pagecurrent"];
        
        echo "<p align='center'>";
        echo "<select  name='pagenumber' id='pagenumber'>";
        for($i=1;$i<=$pagecount;$i++){
            if($i===$pagecurrent){
                echo "<option value=".$i." selected> ".$i."</option>";
            }else{
                echo "<option value=".$i."> ".$i."</option>";
            }
        }
        echo "</select>"
        ?>
        <script>
        document.getElementById('pagenumber').value=<?php echo $pagecurrent;?>;
        document.getElementById('pagenumber').onchange=function(){
            document.form1.pagecurrent.value=document.getElementById('pagenumber').value;
            document.form1.submit();
        };
        </script>  
        <a href="#"  onClick="javascript:document.form1.pagecurrent.value=1;document.form1.submit();">首页</a>, 
        <a href="#" onClick="javascript:document.form1.pagecurrent.value=<?php echo $pagecurrent-1;?>;document.form1.submit();">前一页</a> ,
        <a href="#" onClick="javascript:document.form1.pagecurrent.value=<?php echo $pagecurrent+1;?>;document.form1.submit();">后一页</a>, 
        <a href="#" onClick="javascript:document.form1.pagecurrent.value=<?php echo $pagecount;?>;document.form1.submit();">末页</a>, 
        当前第<?php echo $pagecurrent;?>页,
        共有<?php echo $pagecount;?>页 </p>
        <p>&nbsp; </p>
        <?php
    }
    function getListTable($tableName,$initSql,$arrOpts,$colNamesForTotal,$parms){
        $nopage=false;
        $pagelarge=10;
        $key="id";
        if(isset($this->tableKey[$tableName])){
            $key=$this->tableKey[$tableName];
        }
        if($parms && isset($parms["nopage"]) && $parms["nopage"]===true){
            $nopage=true;
            $pagelarge=1000;
        }
        
        $hasOperation=(count($arrOpts)>0);
        $oTable=$this->arrTables[$tableName];
        $length=count($oTable);
        
        ?>
        <table id=test width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse">  
            <?php 
                $this->printListHeader($tableName,$hasOperation);
                $arr=$this->getListData($tableName,$initSql,$parms);
                if(isset($arr["error"])){
                    return $arr["error"] ;
                }
                $rowscount=count($arr);
                $totals=$this->getTotal($arr,$colNamesForTotal,$tableName);
                $this->totals=$totals;
                //echo "rows=".$rowscount;
                if($rowscount==0)
                {
                    $pagecount=0;
                    $pagecurrent=0;
                    $pageInfo=array("rowBegin"=>0,"rowEnd"=>0,"pagecount"=>0,"pagecurrent"=>0);
                }
                else
                {
                    $pageInfo=$this->getPageInfo($rowscount,$pagelarge);   
                    $pagecount=$pageInfo["pagecount"];
                    $pagecurrent=$pageInfo["pagecurrent"];
                    $rowBegin=$pageInfo["rowBegin"];
                    $rowEnd=$pageInfo["rowEnd"];
                    for($i=$rowBegin;$i<$rowEnd;$i++)                 
                    {
                        $this->printRow($arr,$i,$tableName,$key,$arrOpts);
                    }
                }   
            ?>
        </table>
        <p>共有记录<?php echo $rowscount;?>条
        <?php
        if(!$nopage ){
            $this->printPageInfo($pageInfo);
        }
        return $totals;
    }
    function isFixCol($col){
        if($col["type"]=="Navigation" || $col["name"]=="id" || ($col["name"]=="addtime" && $col["type"]==="readonlystring") ){
            return true;
        }else{
            return false;
        }
    }
    function getSqlValue($col,$val,$record){

        if($col["type"]=="string" || $col["type"]=="" || $col["type"]=="select"){
            $val="'".$val."'";
        }else if($col["type"]=="number"){
            if(($val==="" || $val===null || !isset($val)) && isset($col["nullable"]) && $col["nullable"]){
                $val="null";
            }
            else {
                $val=floatval($val);
            }
        }else if($col["type"]=="file"){
            $val="null";
        }else if($col["type"]="date"){
            if(!$val)$val=$this->getDefaultValue($col["name"],$record,$col);
            $val=$val?"'".$val."'":"null";
        }
        return $val;
    }
    function getSqlValueForUpdate($col,$val,$withCompare){

        if($col["type"]=="string" || $col["type"]=="" ||  $col["type"]=="select"){
            $val="'".$val."'";
        }else if($col["type"]=="number"){
            $val=floatval($val);
            if($withCompare){
                if($val<=0.001){
                    $val="null";
                }
            }
        }else if($col["type"]=="file"){
            $val="null";
        }else if($col["type"]=="date"){
            //if(!$val)$val=$this->getDefaultValue($col["name"],$record,$col);
            $val=$val?"'".$val."'":"null";
        }
        return $val;
    }
    function getAddSql($tableName,$record,$isFromGet=false){
        $oTable=$this->arrTables[$tableName];
        $length=count($oTable);
        
        $sql="insert into ".$tableName."(";
        $colList="";
        $valList="";
        for($x=0;$x<$length;$x++){
            $col=$oTable[$x];
            /*if(!$this->isCorrectRole($tableName,$col["name"],$col)){
                continue;
            }*/
            if(!$this->isBaseCol($col)){
                continue;
            }
            if($this->isFixCol($col)){
                continue;
            }
            if($isFromGet){
                if(isset($_GET[$col["name"]])){
                    $val=$_GET[$col["name"]]; 
                }else{
                   continue;
                }
            }else{
                if(isset($record)){
                    $val=isset($record[$col["name"]])?$record[$col["name"]]:"";
                   
                }else{
                    $val=getPostValue($col["name"]);
                }
            }
            $val=$this->getSqlValue($col,$val,$record);
           
            if($colList!=""){
                $colList=$colList.",".$col["name"];
            }else{
                $colList=$colList.$col["name"];
            }
            if($valList!=""){
                $valList=$valList.",".$val;
            }else{
                $valList=$valList.$val;
            }
        }
        $sql=$sql.$colList.") values(".$valList.") ";
        return $sql;
    }
    function getUpdateSql($tableName,$record){
        $key=$this->getTableKey($tableName);
        $keyType=$this->getTableKeyType($tableName);
        if($key!=="id" && isset($record["oldkey"])){
            $kval=$record["oldkey"];
        }else{
            $kval=$record[$key];
        }
        $oTable=$this->arrTables[$tableName];
        $length=count($oTable);
        $sql="update ".$tableName." set ";
        $colList="";
        for($x=0;$x<$length;$x++){
            $col=$oTable[$x];
            if(!$this->isCorrectRole($tableName,$col["name"],$col)){
                continue;
            }
            if(!$this->isBaseCol($col)){
                continue;
            }
            if($this->isFixCol($col)){//$col["type"]=="Navigation" || $col["name"]=="id" || ($col["name"]=="addtime" && $col["type"]==="readonlystring") ){
                continue;
            }
            if(isset($record)){
                $val=isset($record[$col["name"]])?$record[$col["name"]]:"";
                $val=$this->getSqlValueForUpdate($col,$val,false);
            }else{
                $val=getPostValue($col["name"]);
                $val=$this->getSqlValueForUpdate($col,$val,true);
            }
            if($colList!=""){
                $colList=$colList.",".$col["name"]."=".$val;
            }else{
                $colList=$colList.$col["name"]."=".$val;
            }
        }

        $sql=$sql.$colList." where ".$key."=";//.$record["id"];
        if($keyType==="string"){
            $sql=$sql."'".$kval."'";
        }else{
            $sql=$sql.$kval;
        }
        return $sql;
    }
    function getFieldValue($tableName,$sql,$field){
        global $conn;
        $sql="select ".$field." from ".$tableName." where ".$sql;
        $query=$conn->query($sql);
        if(!$query){
            echo "Error: ".$sql."<br>".$conn->error;
            return "0";
        }
        $rowscount=$query->num_rows;
        if($rowscount==0){
            echo "Error:record not exist of ".$sql;
            return "0";
        }
        $arr = $query->fetch_all(MYSQLI_BOTH);
        return $arr[0][$field];
    }
    function isCorrectRole($tableName,$colname,$col){
        if($tableName==="kucun" && $colname==="danjia" && $_SESSION['cx']!=="系统管理员"){
            return false;
        }
        if(isset($col["role"])){
            if(!in_array($_SESSION['cx'], $col["role"])){
                return false;
            }
        }
        return true;
    }
    function getJinJia($shangpinmingcheng,$shangpinbianhao){
        global $conn;
        $sql="select danjia from caigoudanproducts where shangpinmingcheng='".$shangpinmingcheng."' and shangpinbianhao='".$shangpinbianhao."' order by caigoudanid desc";
        $query=$conn->query($sql);
        if(!$query){
            echo "Error: ".$sql."<br>".$conn->error;
            echo "<script>javascript:alert('error=".$conn->error."');</script>";
            return 0;
        }
        $rowscount=$query->num_rows;
        if($rowscount==0){
            
            return 0;
        }else{
            $arr = $query->fetch_all(MYSQLI_BOTH);
            return $arr[0][0];
        }
        
    }
    function getAddSqlFromGet($tableName){
        return $this->getAddSql($tableName,null,true);
    }
    function insertDataToTableFromGet($tableName){
        $sql=$this->getAddSqlFromGet($tableName);
        global $conn;
        $query=$conn->query($sql);
        if(!$query){
            return  "Error: ".$sql."<br>".$conn->error;
        }else{
            return  "";
        }
    }
    function getUploadedFileFolder($tableName,$colName){
        return $tableName."_".$colName."/";
    }
    function getUploadedFileName($colName,$keyValue){
        $strFile=$_FILES[$colName]["name"];
        $strExt=strrchr($strFile,".");
        return $keyValue.$strExt;
    }
    function getUploadedFileFullName($tableName,$colName,$keyValue){
        return $this->getUploadedFileFolder($tableName,$colName).$this->getUploadedFileName($colName,$keyValue);
    }

}
?>