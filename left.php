<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>无标题文档</title><script src="js/menu.js"></script>
<?php
        if(!isset($_SESSION)){
          session_start();
      }
      $menus=array();
      $Users=array(
        array("title"=>"系统用户管理","url"=>"yhzhgl.php","role"=>array("系统管理员")),
        array("title"=>"修改用户信息","url"=>"user_updt.php","role"=>array("系统管理员","营业录入员","销售经理","销售总监"))
        
      );
      $Kucun=array(
        array("title"=>"出入库管理","url"=>"kucunhistory_add.php","role"=>array("系统管理员","营业录入员")),
        array("title"=>"库存信息查询","url"=>"kucun_list.php","role"=>array("系统管理员","营业录入员","销售经理","销售总监")),
        array("title"=>"商品类别管理","url"=>"splxgl.php","role"=>array("系统管理员","营业录入员")),
        array("title"=>"出入库明细","url"=>"kucunhistory_list.php","role"=>array("系统管理员","营业录入员"))
      );
      $Xiaoshoudingdan=array(
        array("title"=>"销售订单添加","url"=>"xiaoshoudan_add.php","role"=>array("系统管理员","营业录入员","销售经理","销售总监")),
        array("title"=>"销售订单查询","url"=>"xiaoshoudan_list.php","role"=>array("系统管理员","营业录入员","销售经理","销售总监")),
        array("title"=>"产品销售管理","url"=>"table_list.php?tablename=xiaoshoudanproducts&tabletitle=产品销售订单","role"=>array("系统管理员","营业录入员")),
        array("title"=>"订单产品名称管理","url"=>"xiaoshoudanproducts_name_manage.php?tablename=xiaoshoudanproducts","role"=>array("系统管理员"))
      );
      $Caigoudan=array(
        array("title"=>"采购单添加","url"=>"caigoudan_add.php","role"=>array("系统管理员","营业录入员")),
        array("title"=>"采购单查询","url"=>"caigoudan_list.php","role"=>array("系统管理员","营业录入员","销售总监")),
        array("title"=>"产品采购管理","url"=>"table_list.php?tablename=caigoudanproducts&tabletitle=产品采购订单","role"=>array("系统管理员","营业录入员")),
        array("title"=>"采购产品名称管理","url"=>"xiaoshoudanproducts_name_manage.php?tablename=caigoudanproducts","role"=>array("系统管理员"))
      );
      $Huikuan=array(
        array("title"=>"回款添加","url"=>"table_add.php?tablename=huikuan&tabletitle=回款","role"=>array("系统管理员","营业录入员")),
        array("title"=>"回款查询","url"=>"table_list.php?tablename=huikuan&tabletitle=回款","role"=>array("系统管理员","营业录入员","销售总监","销售经理"))
      );
      $Fapiao=array(
        array("title"=>"发票添加","url"=>"table_add.php?tablename=fapiao&tabletitle=发票","role"=>array("系统管理员","营业录入员")),
        array("title"=>"发票查询","url"=>"table_list.php?tablename=fapiao&tabletitle=发票","role"=>array("系统管理员","营业录入员","销售总监","销售经理"))
      );
      $Duizhang=array(
        array("title"=>"对账单查询","url"=>"duizhangdan_list.php","role"=>array("系统管理员","营业录入员","销售总监","销售经理")),
        array("title"=>"客户账单汇总","url"=>"kehuzhangdan_list.php","role"=>array("系统管理员","营业录入员","销售总监","销售经理"))
      );
      $PeiFang=array(
        array("title"=>"配方查询","url"=>"peifang_list.php","role"=>array("系统管理员","技术经理","技术工程师")),
        array("title"=>"添加配方","url"=>"peifang_add.php","role"=>array("系统管理员","技术经理","技术工程师"))
      );
      $Product=array(
        array("title"=>"产品进价管理","url"=>"product_jinjia.php","role"=>array("系统管理员"))
      );
      $Kehuxinxi=array(
        array("title"=>"添加新客户","url"=>"table_add.php?tablename=kehuxinxi&tabletitle=客户信息","role"=>array("系统管理员","营业录入员","销售总监","销售经理")),
        array("title"=>"客户列表","url"=>"table_list.php?tablename=kehuxinxi&tabletitle=客户信息","role"=>array("系统管理员","营业录入员"))
      );
      $Zhizhaoshang=array(
        array("title"=>"添加制造商","url"=>"table_add.php?tablename=zhizhaoshang&tabletitle=制造商信息","role"=>array("系统管理员","营业录入员")),
        array("title"=>"制造商列表","url"=>"table_list.php?tablename=zhizhaoshang&tabletitle=制造商信息","role"=>array("系统管理员","营业录入员"))
      );
      $Xiaoshoufenxi=array(
        array("title"=>"产品销售分析","url"=>"xiaoshoufenxi.php","role"=>array("系统管理员")),
        array("title"=>"产品采购分析","url"=>"caigoufenxi.php","role"=>array("系统管理员"))
      );
      $menus=array(
        array("title"=>"系统用户管理","menus"=>$Users,"role"=>array("系统管理员","营业录入员","销售经理","销售总监")),
        array("title"=>"库存管理","menus"=>$Kucun,"role"=>array("系统管理员","营业录入员","销售经理","销售总监")),
        array("title"=>"销售订单管理","menus"=>$Xiaoshoudingdan,"role"=>array("系统管理员","营业录入员","销售经理","销售总监")),
        array("title"=>"采购单管理","menus"=>$Caigoudan,"role"=>array("系统管理员","营业录入员","销售总监")),
        array("title"=>"产品分析","menus"=>$Xiaoshoufenxi,"role"=>array("系统管理员")),
        array("title"=>"回款管理","menus"=>$Huikuan,"role"=>array("系统管理员","营业录入员","销售总监")),
        array("title"=>"发票管理","menus"=>$Fapiao,"role"=>array("系统管理员","营业录入员","销售总监")),
        array("title"=>"对账单","menus"=>$Duizhang,"role"=>array("系统管理员","营业录入员","销售总监","销售经理")),
        array("title"=>"配方管理","menus"=>$PeiFang,"role"=>array("系统管理员","技术经理","技术工程师")),
        array("title"=>"客户信息管理","menus"=>$Kehuxinxi,"role"=>array("系统管理员","营业录入员","销售总监")),
        array("title"=>"制造商信息管理","menus"=>$Zhizhaoshang,"role"=>array("系统管理员","营业录入员"))
      );
     ?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.STYLE1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 12px;
}
.STYLE2 {
	font-size: 12px;
	color: #03515d;
}
a:link {font-size:12px; text-decoration:none; color:#03515d;}
a:visited{font-size:12px; text-decoration:none; color:#03515d;}
.STYLE3 {font-size: 12px}
-->
</style></head>

<body>
<table width="156"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="33" background="images/main_21.gif">&nbsp;</td>
      </tr>
	  
      <?php
        $count=count($menus);
        for($x=0;$x<$count;$x++){
          $menu=$menus[$x];
          $title=$menu["title"];
          $subMenus=$menu["menus"];
          $role=$menu["role"];
          $index=$x+1;
          if(in_array($_SESSION['cx'], $role)){
            ?>
            <tr>
              <td height="20" background="images/main_25.gif" id="td<?php echo $index;?>" onClick="show(<?php echo $index;?>)"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%">&nbsp;</td>
                  <td width="72%" height="20"><div align="center">
                    <table width="100%" height="21" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><div align="center"><img src="images/top_8.gif" width="16" height="16"></div></td>
                        <td valign="middle"><div align="center" class="STYLE1"><?php echo $title;?></div></td>
                      </tr>
                    </table>
                  </div></td>
                  <td width="15%">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr id="show<?php echo $index;?>" style="display:none">
              <td align="center" valign="top"><table width="145" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td><table width="130" border="0" align="center" cellpadding="0" cellspacing="0">
                    <?php
                      for($i=0;$i<count($subMenus);$i++){
                        $subMenu=$subMenus[$i];
                        $mtitle=$subMenu["title"];
                        $murl=$subMenu["url"];
                        $mrole=$subMenu["role"];
                        if(in_array($_SESSION['cx'], $mrole)){
                          ?>
                          <tr>
                            <td width="41" height="35"><div align="center"><img src="images/left_1.gif" width="31" height="31"></div></td>
                            <td width="89" height="35"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td height="23" style="cursor:hand" onMouseOver="this.style.borderStyle='solid';this.style.borderWidth='1';borderColor='#adb9c2'; "onmouseout="this.style.backgroundImage='url()';this.style.borderStyle='none'"><span class="STYLE2">&nbsp;<a href="<?php echo $murl;?>" target="hsgmain"><?php echo $mtitle;?></a></span></td>
                              </tr>
                            </table></td>
                          </tr>
                          <?php
                        }
                      }
                      ?>
                     
                  </table></td>
                </tr>
              </table></td>
            </tr>
            <?php

          }

        }
        
     ?>

    </td>
  </tr>
</table>
</body>
</html>
