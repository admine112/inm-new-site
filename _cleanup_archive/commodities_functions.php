<?php
/**
* OwerCMS
* Функции пользовательской части модуля управления товарами
* @package OwerCMS
* @author Ower
* @version 4.7
* @since engine v.4.7
* @link http://www.ower.com.ua
* @copyright (c) 2010+ by Ower
*/

if(!function_exists("get_comments")) {
    function get_comments($id, $type) {
        return array("count" => 0, "name" => "", "width" => 0);
    }
}

function get_commodity_full($com_id)
{
	global $glb,$carusel;
	$sql="
	SELECT * FROM `shop_commodity`
	WHERE `commodity_ID`='{$com_id}';";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		$glb["canonical"]=$row["alias"]==""?"/pr{$com_id}/":"/pr{$com_id}-{$row["alias"]}/";
		$glb["templates"]->set_tpl('{$com_desc}', $row["com_desc"]);
		$glb["templates"]->set_tpl('{$com_fulldesc}', $row["com_fulldesc"]);
		$glb["templates"]->set_tpl('{$com_name}', $row["com_name"]);
		$glb["super_title"]=$row["title"]!=""?$row["title"]:$row["com_name"];
		$glb["super_description"]=$row["description"]!=""?$row["description"]:reg_text($row["com_name"].". ".$row["com_desc"]);
		$glb["super_keywords"]=$row["keywords"]!=""?$row["keywords"]:$row["com_name"];
		$glb["super_content"]=$row["content"]!=""?$row["content"]:$row["content"];
		$alias=$row["alias"];
		$com_name=$row["com_name"];
		$com_url=$alias!=""?"/pr{$com_id}-{$alias}/":"/pr{$com_id}/";
		$countries.="<option value='{$row['country_id']}'>{$row['country_name_ru']}</option>";
		$src1=$row["commodity_bigphoto"]==1?"/{$row["commodity_ID"]}stitle/{$alias}.jpg":"/templates/{$glb["theme_name"]}/img/nophoto.jpg";
		$src2=$row["commodity_bigphoto"]==1?"/{$row["commodity_ID"]}btitle/{$alias}.jpg":"/templates/{$glb["theme_name"]}/img/nophoto.jpg";
		$an_status=$row['commodity_status'];
		$vendor_id=$row["vendor"];
		$com_ids_line=$row["recomandate"];
		$glb["templates"]->set_tpl('{$com_cod}', $row["cod"]);
		$glb["templates"]->set_tpl('{$com_src}',$src1);
		$glb["templates"]->set_tpl('{$com_src2}',$src2);
		
		
		$status=$glb["cstatus"][$row["commodity_status"]];
		$glb["templates"]->set_tpl('{$com_status}',$status);
		$glb["templates"]->set_tpl('{$com_price_orig}',$row["commodity_price"]);
		$glb["templates"]->set_tpl('{$com_price}',get_true_price2($row['commodity_price'],$row['cur_id'],$_SESSION['user_discount']));
		$row["commodity_old_price"]=$row["commodity_old_price"]==0?$row['commodity_price']:$row["commodity_old_price"];
		$glb["templates"]->set_tpl('{$com_old_price}',get_true_price2($row['commodity_price'],$row['cur_id'],$_SESSION['user_discount'])!=get_true_price2($row['commodity_old_price'],$row['cur_id'],0)?get_true_price($row['commodity_old_price'],$row['cur_id'])." {$glb["cur_show"]}":"");

	}
	
	$sql="SELECT * FROM `shop_commodities-categories` 
	WHERE `commodityID`='{$com_id}' AND `categoryID`<>'0';";
	$row=mysql_fetch_assoc(mysql_query($sql));
	if($row)
	{
		$cat_id=$row["categoryID"];
		$cat_chl_name=$glb["cat_names"];
		$glb["templates"]->set_tpl('{$breadcrumb}',get_shop_breadcrumb($glb["cat_parrents"],$cat_id,$cat_chl_name,$cat_chl_alias,0));
		$cat_url=$glb["cat_aliases"][$cat_id]!=""?"/c{$cat_id}-{$glb["cat_aliases"][$cat_id]}/":"/c{$cat_id}/";
		$glb["templates"]->set_tpl('{$filters}',get_filters_panel($glb["cat_parrents"],$cat_id,'',$cat_url));
	}
	
	$cat_chl_name=$glb["cat_names"];
	$cat_chl_alias=$glb["cat_aliases"];
	//$glb["right_block"]=get_recomendates_commodities($com_ids_line);
	$addstr1="<script>function new_buy(){jQuery('#add_id').attr('value','{$com_id}');jQuery('#add_form').submit();}</script>";
	$text_filters=get_text_filters($com_id);
	get_text_filters2($com_id);
	$basket_btn_name='Купить';
	$basket_btn_event='new_buy()';
	if($an_status>1){
		$basket_btn_name='Нет в наличии';
		$basket_btn_event='return false;';
		$glb["templates"]->set_tpl('////',".cl_booking_button,.cl_price{display:none;}");
		
	}
	$basket_btn="<div class='cl_booking_button' onclick='{$basket_btn_event}'>{$basket_btn_name}</div>";
	$comments=get_comments($com_id,"c");
	$glb["templates"]->set_tpl('{$com_commnets}',$comments["lines"]);
	$glb["templates"]->set_tpl('{$com_commnets_last}',$comments["last"]);
	$glb["templates"]->set_tpl('{$com_commnets_count}',$comments["count"]);
	$glb["templates"]->set_tpl('{$com_commnets_name}',$comments["name"]);
	$glb["templates"]->set_tpl('{$com_commnets_width}',$comments["width"]);
	$glb["super_description"]=strlen($glb["super_description"])<200?reg_text($glb["super_description"]." ".str_replace("</td></tr>",", ",$text_filters)):$glb["super_description"];
	$glb["templates"]->set_tpl('{$text_filters}',$text_filters);
	$glb["templates"]->set_tpl('{$com_id}',$com_id);
	$glb["templates"]->set_tpl('{$basket_btn}',$basket_btn);
	$glb["templates"]->set_tpl('{$additional_photos}',get_addition_photos($com_id,$src1,$src2));
	$glb["templates"]->set_tpl('{$recomentations}',get_recomentations($com_id));
	$glb["templates"]->set_tpl('{$breadcrumb}',get_shop_breadcrumb($glb["cat_parrents"],$cat_id,$cat_chl_name,$cat_chl_alias,0));
	$glb["templates"]->set_tpl('{$right_panel}',$glb["templates"]->get_tpl('shop.commodity.full.right_panel'));
	$ret=$glb["templates"]->get_tpl('shop.commodity.full');		
	$last_view=$_SESSION["last_view"];
	$last_view[$com_id]=$com_id;
	$_SESSION["last_view"]=$last_view;
	$_SESSION["last_page"]="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
	return $ret;
}


function get_category_full($cat_id=0,$page_id=-1,$type="")
{
	global $glb, $urlend, $theme_name,$glbf;

	$glb["templates"]->set_tpl('{$cat_id}',$cat_id);
	
	$parrent_url='';
	$cat_chl_name=$glb["cat_names"];
	$cat_chl_alias=$glb["cat_aliases"];
	//Формируем список вложенных категорий
	if(isset($glb["cat_parrents"]) && is_array($glb["cat_parrents"]) && count($glb["cat_parrents"]))
	foreach($glb["cat_parrents"] as $cat_chl_id=>$parrent)
	{
		$category_children_list.=$parrent==$cat_id?"<li><a href='/c{$cat_chl_id}-{$cat_chl_alias[$cat_chl_id]}/'>{$cat_chl_name[$cat_chl_id]}</a></li>":"";
	}
	$glb["templates"]->set_tpl('{$category_children_list}', $category_children_list);
	
	//формируем строку с id всех вложенных категорий
	$internals=$glb["use_internal_cats"]?get_id_of_internal_cats($glb["cat_parrents"],$cat_id):"";
	
	$sql="SELECT * FROM `shop_categories` 
	WHERE `categories_of_commodities_ID`='{$cat_id}' ";
	$row=mysql_fetch_assoc(mysql_query($sql));
	if($row)
	{
	
	}else
	{
		$glb["teg_robots"]=true;
	}	
	//Выводим все товары данной категории
	if(!stristr($glb["request_url"], ";"))
	{
		if($type==""&&$page_id==-1)
		{
			if($glb["request_url_encode"]=="/c{$cat_id}-{$row["alias"]}/"||($glb["request_url_encode"]=="/c{$cat_id}/"&&$row["alias"]==""))
			{
				$category_desc=$row["cat_desc"];
				$category_name=$row["h1"]!=""?$row["h1"]:$row["cat_name"];
				generate_com_meta(1,$row["title"],$row["description"],$row["cat_name"],$row["cat_desc"],$page_id);
			}else
			{
				$category_name=$row["cat_name"];
				generate_com_meta(2,"","",$row["cat_name"]);
			}
			$glb["canonical"]=$row["alias"]==""?"/c{$cat_id}/":"/c{$cat_id}-{$row["alias"]}/";
		}else
		{
			$category_name=$row["cat_name"];
			generate_com_meta(3,"","",$row["cat_name"]);
			$glb["canonical"]=$page_id==1?$row["alias"]==""?"/c{$cat_id}/":"/c{$cat_id}-{$row["alias"]}/":"/c{$cat_id}-{$page_id}{$row["alias"]}/";
		}
		//Если фильтры не выбраны выводим товары по умолчанию
		$sql = "SELECT `commodityID`,`categoryID` FROM `shop_commodities-categories` WHERE `categoryID`='{$cat_id}' {$internals};";
		$sql2 = "SELECT `commodityID`,`categoryID` FROM `shop_commodities-categories` WHERE `categoryID`='{$cat_id}' {$internals};";
	}else
	{
		$cat_url=$row["alias"]==""?"/c{$cat_id}/":"/c{$cat_id}-{$row["alias"]}/";
		if($page_id!=-1)
		$glb["canonical"]=$cat_url;
		//=========================================================================================================	
		//Если фильтры выбраны - производим дополнительную фильтранию
		$aparse_url_arr = parse_request_filter_url();
		//$glb["teg_robots"]=true;
		$iii=0;
		$count_arrays=is_array($aparse_url_arr) ? count($aparse_url_arr) : 0;
		
		
		if($count_arrays>0)
		foreach($aparse_url_arr as $key=>$value)
		{ 
			if(is_array($value))
			{
				foreach($value as $key2=>$value2)
				{ 
					$rrsql.=$rrsql==""?" `id`='{$value2}' ":" OR `id`='{$value2}' ";
				}
			}else
			{
				$rrsql.=$rrsql==""?" `id`='{$value}' ":" OR `id`='{$value}' ";
			}
		}

		$sql2 = "SELECT DISTINCT `list_name`,`filtr_name` FROM `shop_categories-filters` 
		INNER JOIN `shop_filters-lists` ON `shop_categories-filters`.`filtr_id`=`shop_filters-lists`.`list_filterid`
		WHERE {$rrsql}
		ORDER BY `filtr_id`;";
		$result2 = mysql_query($sql2);
		if($result2)
		{
			while($rowf=mysql_fetch_array($result2))
			{
				$filname=$nameused[$rowf['filtr_name']]==1?"":mb_strtolower($rowf['filtr_name'],'UTF-8');
				$nameused[$rowf['filtr_name']]=1;
				$types.=$types==""?" {$filname} {$rowf['list_name']}":", {$filname} {$rowf['list_name']}";
			}
			 $types=str_replace("производитель","",$types);
			//$types=" ({$types})";
		}
				
		if($count_arrays>0)
		foreach($aparse_url_arr as $key=>$value)
		{   	
			if($iii>0)
			{
				$sql_end = '';
				if(is_array($value))
				{
					if(isset($value['over']) and isset($value['under']))
					{
						$sql_end_temp='';
						//сделать проверку на тип фильтра, чтобы только числовые поля можно было выводить в интервале
						$sql_end_temp .= is_numeric($value['over'])?" AND `ticket_value`>{$value['over']}":'';
						$sql_end_temp .= is_numeric($value['under'])?" AND `ticket_value`<{$value['under']}":'';
						$sql_end_temp = "`ticket_filterid`='{$key}'".$sql_end_temp;
						$sql_end.=!empty($sql_end)?" AND ({$sql_end_temp})":"({$sql_temp1})";
					}else
					{
						$sql_end_temp='';
						if(is_array($value) && count($value))
						foreach($value as $filter_v)
						{
							$sql_end_temp.=!empty($sql_end_temp)?" OR ":'';
							$sql_end_temp.="`ticket_value`='{$filter_v}'";	
						} 	
						$sql_temp1 = "(`ticket_filterid`='{$key}' AND ({$sql_end_temp}))";
						$sql_end.=!empty($sql_end)?" AND {$sql_temp1}":"{$sql_temp1}";
					}
				}else
				{	if($key=="p1"||$key=="p2")
					{
						//$sql_end="1=1";
					}elseif($key!=0)
					{
						$sql_temp2= " (`ticket_filterid`='{$key}' AND `ticket_value`='{$value}') ";
						$sql_end=$sql_temp2;
					}
				}
				$sql_end=$sql_end==""?"1=0":$sql_end;
				$sql_f_art_id = "SELECT DISTINCT `ticket_id`,`ticket_filterid` FROM `shop_filters-values`
				WHERE {$sql_end} {$where2}";
				
				$result_f_art_id = mysql_query($sql_f_art_id);
				$where2="";
				$sql_art_end="";
				if($result_f_art_id)
				{
					while($row_f_art_id=mysql_fetch_array($result_f_art_id))
					{
						$f_art_id[$row_f_art_id['ticket_id']]=$row_f_art_id['ticket_id'];
						$sql_art_end .= " OR `commodityID`='{$row_f_art_id['ticket_id']}'";
						$where2.=",{$row_f_art_id['ticket_id']}";
						
					}
					 $where2=" AND `ticket_id` IN (0{$where2})";
				}

				$where2=$where2!=""?$where2:" AND `ticket_id`='0' ";
			}elseif($count_arrays<2)
			{
				$sql_art_end="OR 1=1";
			}
			$iii++;
		}
		
		$sql = "SELECT `commodityID`,`categoryID` FROM `shop_commodities-categories` WHERE (`categoryID`='{$cat_id}' {$internals}) AND (1=0 {$sql_art_end})";
		$sql2 = "SELECT `commodityID`,`categoryID` FROM `shop_commodities-categories` WHERE (`categoryID`='{$cat_id}' {$internals})";
		$category_name=$cat_chl_name[$cat_id].$types;
		
		$mata4=1;
		generate_com_meta(4,"","",$cat_chl_name[$cat_id],"","",",{$types}");
	}
	
	$glb["super_title"]=$glb["super_title"]==""||$glb["super_title"]==" }-"?"Полный каталог товаров на {$glb["domain"]}":$glb["super_title"];	
	$glb["super_description"]=$glb["super_description"]==""||$glb["super_description"]==" "?"Полный каталог товаров нашего интернет-магазина. Все товары на {$glb["domain"]}":$glb["super_description"];
	
	$page_id=$page_id==-1?1:$page_id;
	//=========================================================================================================
	//=========================================================================================================
	//=========================================================================================================
	$glb["templates"]->set_tpl('{$breadcrumb}',get_shop_breadcrumb($glb["cat_parrents"],$cat_id,$cat_chl_name,$cat_chl_alias,0));
	

	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		$com_id[$row['commodityID']]=$row['commodityID'];
		$sql_com_temp.=" OR `commodity_ID`='{$row['commodityID']}'";
		$hfhhh[$row['commodityID']]=$row['categoryID'];
	}
	
	$res=mysql_query($sql2);
	while($row=mysql_fetch_assoc($res))
	{
		$com_id2[$row['commodityID']]=$row['commodityID'];
	}
	
	$glb["found_ids_arry"]=$com_id2;
	$onpage[9]=1;
	$onpage[18]=1;
	$onpage[27]=1;
	$onpage[36]=1;
		
	$_SESSION["items_on_page"]=is_numeric($_POST["items_on_page"])?$_POST["items_on_page"]:$_SESSION["items_on_page"];
	$items_on_page=is_numeric($_SESSION["items_on_page"])?$_SESSION["items_on_page"]:9;
		
	$sonpage[$items_on_page]="class='cl-selected'";
		
	foreach($onpage as $key=>$value)
	{
		$lines2.="<li><a href='#' onclick='onpage({$key})'>{$key}</a></li>";
	}	
		
	$glb["templates"]->set_tpl('{$pager2}',$lines2);
		
	if($sql_com_temp!="")
	{ 
		$typesel=$type!=""?" AND `commodity_{$type}`='1' ":"";
		$sql = "SELECT
		`commodity_ID`, `cod`, `commodity_old_price`, `commodity_status`,`commodity_price`, `commodity_bigphoto`, `commodity_order`,`cur_id`,
		`commodity_order`,`commodity_new`,`commodity_hit`,`commodity_action`
		FROM `shop_commodity`
		WHERE `commodity_visible`='1' AND (1=0 {$sql_com_temp}) {$typesel}";
		$result_com = mysql_query($sql);
		if(mysql_num_rows($result_com)>0)
		{
			while($row=mysql_fetch_assoc($result_com))
			{
				$ident_array[$row['commodity_ID']] = $row['commodity_order'];
				$com_cod[$row['commodity_ID']]=$row['cod'];
				$com_first_price[$row['commodity_ID']]=get_true_price($row['commodity_old_price']>0?$row['commodity_old_price']:$row['commodity_price'],$row['cur_id']);
				$com_price[$row['commodity_ID']]=get_true_price($row['commodity_price'],$row['cur_id'],$_SESSION['user_discount']);
				$com_max_price=max($com_max_price,$com_price[$row['commodity_ID']]);
				$com_bphoto[$row['commodity_ID']]=$row['commodity_bigphoto'];
				$commodity_new[$row['commodity_ID']]=$row["commodity_new"];
				$commodity_hit[$row['commodity_ID']]=$row["commodity_hit"];
				$commodity_action[$row['commodity_ID']]=$row["commodity_action"];
				$commodity_discount[$row['commodity_ID']]=$row["commodity_new"];
				$an_status[$row['commodity_ID']]=$row["commodity_status"];
			}
		}
	
		
		$sql_com_temp2=str_replace("commodity_ID","com_id",$sql_com_temp);
		$sql = "SELECT *
		FROM `shop_images`
		WHERE  (1=0 {$sql_com_temp2})
		ORDER BY `order`";
		$result_com = mysql_query($sql);
		if(mysql_num_rows($result_com)>0)
		{
			while($row=mysql_fetch_assoc($result_com))
			{
				$com_imgs[$row['com_id']].="/images/commodities/{$row['com_id']}/s_{$row['img_id']}.jpg;";
				$com_imgs2[$row['com_id']].="/images/commodities/{$row['com_id']}/{$row['img_id']}.jpg;";
			}
		}
		
		$sql_com_desc = "SELECT `commodity_ID`, `alias`, `com_name`, `com_desc`,`com_fulldesc` FROM `shop_commodity` WHERE 1=0 {$sql_com_temp}";
		$result_com_desc = mysql_query($sql_com_desc);
		if(mysql_num_rows($result_com_desc)>0){
			while($row=mysql_fetch_assoc($result_com_desc)){
				$com_alias[$row['commodity_ID']]=$row['alias'];
				$com_name[$row['commodity_ID']]=$row['com_name'];
				$com_desc[$row['commodity_ID']]=$row['com_desc']!=""?$row['com_desc']:reg_text($row['com_fulldesc'],600);
			}
		}
		
		//Тут будут прописаны сортировки
		$glb["sort"]=1;
		$sort_desc=false;
		$glb["teg_robots"]=true;
		if(!(strpos($glb["request_url"],";sort=price1")===false))
		{
			//Если соритровка по цене
			$sort_array=$com_price;
			$group=1;
			$meta_end.=" - сортировка по цене";
			
		}elseif(!(strpos($glb["request_url"],";sort=price2")===false))
		{
			//Если соритровка по цене убывание
			$sort_array=$com_price;
			$sort_desc=true;
			$group=1;
			$meta_end.=" - сортировка по цене по убыванию";
		}elseif(!(strpos($glb["request_url"],";sort=name1")===false))
		{
			//Если соритровка по цене
			$sort_array=$com_name;
			$group=2;
			$meta_end.=" - сортировка по имени";
		}elseif(!(strpos($glb["request_url"],";sort=name2")===false))
		{
			//Если соритровка по цене убывание
			$sort_array=$com_name;
			$sort_desc=true;
			$group=2;
			$meta_end.=" - сортировка по имени по убыванию";
		}elseif(!(strpos($glb["request_url"],";sort=order1")===false))
		{
			//Если соритровка по цене
			$sort_array=$ident_array;
			$group=3;
			$meta_end.=" - сортировка по рейтингу";
		}elseif(!(strpos($glb["request_url"],";sort=order2")===false))
		{
			//Если соритровка по цене убывание
			$group=3;
			$sort_array=$ident_array;
			$sort_desc=true;
			$meta_end.=" - сортировка по рейтингу по убыванию";
		}else
		{
			//Сортировка по указаной в админке (по умолчанию)
			$group=3;
			$sort_array=$ident_array;
			$glb["teg_robots"]=false;
		}

		//Конец сортировок
		
		if(is_array($sort_array) && count($sort_array))
		{
			if(!$sort_desc)
			{
				//Сортировка масива по возрастанию
				asort($sort_array);
			}else
			{
				//Сортировка масива по убыванию
				arsort($sort_array);
			}
		}
		
		//=========================
		
		$request_url2=substr($glb["request_url"], 0, strlen($glb["request_url"])-1);
		if(strpos($request_url2,";sort=")===false)
		{
			$request_url2.=";sort=|||||";	
		}else
		{
			$response="{$request_url2};";
			$match_expression = "/sort=(.*);/US";
			preg_match($match_expression,$response,$matches);
			if($matches[1]!="")
			{
				$request_url2=str_replace(";sort={$matches[1]}",";sort=|||||",$request_url2);
			}else
			{
				$request_url2.=";sort=|||||";		
			}
		}
		$request_url2.="/";
		
		$link1=str_replace("|||||","price1",$request_url2);
		$link2=str_replace("|||||","price2",$request_url2);
		$link3=str_replace("|||||","name1",$request_url2);
		$link4=str_replace("|||||","name2",$request_url2);
		$link5=str_replace("|||||","order1",$request_url2);
		$link6=str_replace("|||||","order2",$request_url2);
		
		$get_new_url_for_sort.=$sort_desc?"<li><a href='#{$link1}' style='font-weight:bold;'>от дешевых к дорогим</a></li> <li><b>от дорогих к дешевым</b></li>":
		"<li><b>от дешевых к дорогим</b></li> <li><a href='#{$link2}' style='font-weight:bold;'>от дорогих к дешевым</a></li>";
		
		$get_new_url_for_sort=$get_new_url_for_sort!=""?"<li class='bold_type'>Выводить:</li>{$get_new_url_for_sort}":"<li>Нет в наличии</li>";
		$glb["templates"]->set_tpl('{$sort_links}',$get_new_url_for_sort);
		//=========================
		$glb["filters_panel"]=get_filters_panel($glb["cat_parrents"],$cat_id,$cat_url,"",$found_ids);//формируем строку с id всех вложенных категорий
		$glb["filters_panel"]=$com_max_price>0?str_replace("99809",$com_max_price,$glb["filters_panel"]):$glb["filters_panel"];
		if($glb["p1"]!=""||$glb["p2"]!="")
		$glb["canonical"]=$cat_url;
		
		$liders=0;
		$p_counter=0;
		$c_page=1;
		if(is_array($sort_array) && count($sort_array))
		{
			if(is_array($sort_array) && count($sort_array))
			foreach($sort_array as $c_id=>$key)
			{ 
				$show_by_price=true;
				$glb["minval"]++;

				if(is_numeric($glb["p1"])&&$com_price[$c_id]<$glb["p1"]){$show_by_price=false;} 
				if(is_numeric($glb["p2"])&&$com_price[$c_id]>$glb["p2"]&&$glb["p2"]!=99809){$show_by_price=false;}
				if($show_by_price)
				{
					if($p_counter==$items_on_page){$p_counter=0;$c_page++;}
					$p_counter++;
					if($c_page==$page_id||$page_id==0)
					{ 
						
						//на этом этапе мы реализируем вывод товаров только нужной нам страницы
						$com_url=$com_alias[$c_id]!=""?"/pr{$c_id}-".$com_alias[$c_id]."/":"/pr{$c_id}/";
						$com_src=($com_bphoto[$c_id]!=0)?"/{$c_id}stitle/{$com_alias[$c_id]}.jpg":"/templates/{$theme_name}/img/nophoto.jpg";
$comments=get_comments($c_id,"c");
						$glb["templates"]->set_tpl('{$com_commnets_count}',$comments["count"]);
						$glb["templates"]->set_tpl('{$com_commnets_name}',$comments["name"]);
						$glb["templates"]->set_tpl('{$com_commnets_width}',$comments["width"]);
						$glb["templates"]->set_tpl('{$com_src}',$com_src);
						$glb["templates"]->set_tpl('{$com_src2}',$com_imgs[$c_id],$com_src.";");
						$glb["templates"]->set_tpl('{$c_name}',$com_name[$c_id]);
						$glb["templates"]->set_tpl('{$com_cod}',$com_cod[$c_id]);
					
					
					
					
						$glb["templates"]->set_tpl('{$com_old_price}',$com_first_price[$c_id]!=$com_price[$c_id]?$com_first_price[$c_id]." {$glb["cur_show"]}":"");
						$glb["templates"]->set_tpl('{$com_price}',$com_price[$c_id]);
						$glb["templates"]->set_tpl('{$c_shorttext}',$com_desc[$c_id]);
						$glb["templates"]->set_tpl('{$com_url}',$com_url);
						$glb["templates"]->set_tpl('<!--{$catt---tname}-->',$description[$hfhhh[$c_id]]);
						$glb["templates"]->set_tpl('{$com_id}',$c_id);
						$glb["templates"]->set_tpl('{$com_new}',$com_first_price[$c_id]!=$com_price[$c_id]&&$com_first_price[$c_id]>0?"<div class='cl_com_discount'>-".round(($com_first_price[$c_id]-$com_price[$c_id])/($com_first_price[$c_id]/100))."%</div>":"");
						$glb["templates"]->set_tpl('{$com_discount}',$commodity_new[$c_id]==1?"<div class='cl_com_new'>New</div>":"");
						$glb["templates"]->set_tpl('{$com_action}',$commodity_action[$c_id]==1?"<span class='red_price'>супер цена</span>":"");
						$glb["templates"]->set_tpl('{$com_hit}',$commodity_hit[$c_id]==1?"<span class='good_price'>хит продаж</span>":"");
						$commodity_all_lines.=$glb["templates"]->get_tpl("shop.commodity.short");	
					}
				}
			}
		}
	}
	
	
	
	if($c_page>1)
	{
		$a_url=str_replace("c{$cat_id}-{$page_id}","c{$cat_id}-|||||",$glb["request_url"]);
		$a_url=str_replace("c{$cat_id}-","c{$cat_id}-|||||",$a_url);
		$a_url=$a_url=="/shop/"?"/c0-|||||/":$a_url;
		$a_url=$a_url=="/new/"?"/nc0-|||||/":$a_url;
		$a_url=$a_url=="/actions/"?"/ac0-|||||/":$a_url;
		$meta_end.=$page_id!=1?" - страница {$page_id}":"";
		for($i=1;$i<=$c_page;$i++)
		{
			$b_url=$i>1?str_replace("|||||",$i,str_replace("||||||||||",$i,$a_url)):str_replace("|||||","",str_replace("||||||||||","",$a_url));
			$rel="";
			$glb["pagination_prev"]=$i==($page_id-1)?$b_url:$glb["pagination_prev"];
			$glb["pagination_next"]=$i==($page_id+1)?$b_url:$glb["pagination_next"];
			$rel=$i==1?" rel='first' ":$rel;
			$rel=$i==$c_page?" rel='last' ":$rel;
			
			$pager.="<li><a href='{$b_url}'>{$i}</a></li>";
		}
		$b_url=str_replace("-".$i,"-0",$b_url);
		//if($i>1)$pager.="<li><a href='{$b_url}'>Все</a></li>";
		$pager="<ul class='cl_pager list_bottom_nav clearfix ld'>{$pager}</ul>";
	}
	if($commodity_all_lines!="")
	{
		$glb["templates"]->set_tpl('{$commodity_all_lines}',$commodity_all_lines);
		$commodities=$glb["templates"]->get_tpl("shop.all_commodities");
	}
	$liders=0;
	if(is_array($commodity_hit) && count($commodity_hit))
	foreach($commodity_hit as $c_id=>$value)
	{
	//на этом этапе мы реализируем вывод товаров только нужной нам страницы
		$com_url=$com_alias[$c_id]!=""?"/pr{$c_id}-".$com_alias[$c_id]."/":"/pr{$c_id}/";
		$com_src=($com_bphoto[$c_id]!=0)?"/{$c_id}stitle/{$com_alias[$c_id]}.jpg":"/templates/{$theme_name}/img/nophoto.jpg";
				
						
					
		$glb["templates"]->set_tpl('{$com_src}',$com_src);
		$glb["templates"]->set_tpl('{$com_src2}',$com_imgs[$c_id],$com_src.";");
		$glb["templates"]->set_tpl('{$c_name}',$com_name[$c_id]);
		$glb["templates"]->set_tpl('{$com_cod}',$com_cod[$c_id]);
		$glb["templates"]->set_tpl('{$com_old_price}',$com_first_price[$c_id]!=$com_price[$c_id]?$com_first_price[$c_id]:"");
		$glb["templates"]->set_tpl('{$com_price}',$com_price[$c_id]);
		$glb["templates"]->set_tpl('{$c_shorttext}',$com_desc[$c_id]);
		$glb["templates"]->set_tpl('{$com_url}',$com_url);	
		$glb["templates"]->set_tpl('{$com_id}',$c_id);
		$glb["templates"]->set_tpl('{$com_new}',$com_first_price[$c_id]!=$com_price[$c_id]&&$com_first_price[$c_id]>0?"<div class='cl_com_discount'>-".round(($com_first_price[$c_id]-$com_price[$c_id])/($com_first_price[$c_id]/100))."%</div>":"");
		$glb["templates"]->set_tpl('{$com_discount}',$commodity_new[$c_id]==1?"<div class='cl_com_new'>New</div>":"");
		$glb["templates"]->set_tpl('{$com_discount}',$commodity_new[$c_id]==1?"<div class='cl_com_new'>New</div>":"");
		$glb["templates"]->set_tpl('{$com_action}',$commodity_action[$c_id]==1?"<span class='red_price'>супер цена</span>":"");
		$glb["templates"]->set_tpl('{$com_hit}',$commodity_hit[$c_id]==1?"<span class='good_price'>хит продаж</span>":"");
		
		
		if($liders<3)
		{	
			$liders++;
			$glb["templates"]->set_tpl('{$lidersid}',$liders);
			$lidery_lines.=$glb["templates"]->get_tpl("shop.commodity.lider");
			
		}
						
		$commodity_all_lines.=$glb["templates"]->get_tpl("shop.commodity.short");
	}
	$glb["super_title"].=$meta_end;
	$glb["super_description"].=$meta_end;
	$glb["super_keywords"].=$meta_end;
	$glb["super_content"].=$meta_end;
	
	$glb["templates"]->set_tpl('{$pager}',$pager);
	$glb["templates"]->set_tpl('{$lidery_lines}',$lidery_lines);
	$glb["templates"]->set_tpl('{$filters}',$glb["filters_panel"]);
	$glb["templates"]->set_tpl('{$category_name}',$category_name);
	$glb["templates"]->set_tpl('{$category_desc}',$category_desc);
	$glb["templates"]->set_tpl('{$commodities}',$commodities);
	$glb["templates"]->set_tpl('{$right_panel}',$glb["templates"]->get_tpl('shop.category.full.right_panel'));
	$ret=$glb["templates"]->get_tpl("shop.category.full");
	return $ret;
}

function generate_com_meta($type,$title,$description,$name1="",$desc1="",$page_id="",$name2="",$desc2="")
{
	global $glb;
	if($type==1)
	{
		//основная страница категории
		$glb["super_title"]=$title!=""?$title:"Цены на {$name1} в Киеве";
		$glb["super_description"]=$description!=""?$description:reg_text($desc1,200);
	}elseif($type==2)
	{
		//не правильный URL
		$glb["super_title"]="Продукция раздела {$name1} на {$glb["domain"]}{$name2}";
		$glb["super_description"]="Все товары раздела {$name1} на нашем сайте {$glb["domain"]}{$name2}";
	}elseif($type==3)
	{
		//следующая страница категории
		$glb["super_title"]="Продукция раздела {$name1} на {$glb["domain"]} страница {$page_id}";
		$glb["super_description"]="Продукция раздела {$name1} на {$glb["domain"]} страница {$page_id}";
	}elseif($type==4)
	{
		//Подбор по фильтрам
		$glb["super_title"]="Цены на {$name1}{$name2} в Киеве";
		$glb["super_description"]=reg_text("Купить {$name1}{$name2}. Все товары раздела {$name1} ",200);
	}
}

function get_recomentations($com_id)
{
	global $glb;
	$sql="
	SELECT * FROM `shop_recommendation`
	INNER JOIN `shop_commodity` ON `shop_commodity`.`commodity_ID`=`shop_recommendation`.`rec_other_com_id`
	WHERE `rec_com_id`='{$com_id}'
	ORDER BY `rec_order`
	LIMIT 0,4;";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		$glb["templates"]->set_tpl('{$rec_name}',$row["com_name"]);
		$glb["templates"]->set_tpl('{$rec_comid}',$row["commodity_ID"]);
		$glb["templates"]->set_tpl('{$rec_url}',$row["alias"]!=""?"/pr{$row["commodity_ID"]}-{$row["alias"]}/":"/pr{$row["commodity_ID"]}/");
		$glb["templates"]->set_tpl('{$rec_img}',$row["commodity_bigphoto"]!=""?"<img src='/{$row["commodity_ID"]}stitle/{$row["alias"]}.jpg'>":"");
		$glb["templates"]->set_tpl('{$rec_price}',get_true_price($row['commodity_price'],$row['cur_id']));
		$lines.=$glb["templates"]->get_tpl("shop.commodity.recs.line");
	}
	$glb["templates"]->set_tpl('{$rec_lines}',$lines);
	$ret=$lines!=""?$glb["templates"]->get_tpl("shop.commodity.recs"):"";
	return $ret;
}

function get_category_action($cat_id=0,$page_id=1)
{
	global $glb;
	
	$glb["teg_robots"]=true;
	return str_replace("/c","/ac",get_category_full($cat_id,$page_id,"action"));
}
function get_category_new($cat_id=0,$page_id=1)
{
	global $glb;
	
	$glb["teg_robots"]=true;
	return str_replace("/c","/nc",get_category_full($cat_id,$page_id,"new"));
}

function get_search($page_id=1)
{
	global $glb, $request_url, $templates, $urlend, $theme_name,$glbf;

	$cat_chl_name=$glb["cat_names"];
	$cat_chl_alias=$glb["cat_aliases"];
	$_SESSION["search"]=isset($_POST["search"])?$_POST["search"]:$_SESSION["search"];
	if($_SESSION["search"]=="")return "";
	$search=antihacktext($_SESSION["search"]);
	$category_name="Поиск по фразе \"{$search}\"";
	
	$glb["super_title"]=$category_name;
	$glb["super_description"]=$category_name;
	$glb["super_keywords"]=$category_name;
	$glb["super_content"]=$category_name;
		
	$parrent_url='';
	
	
	
	//=========================================================================================================
	//=========================================================================================================
	//=========================================================================================================
	$glb["templates"]->set_tpl('value="Поиск по сайту"',"value='{$search}'");
	$glb["templates"]->set_tpl('{$breadcrumb}',get_shop_breadcrumb($glb["cat_parrents"],$cat_id,$cat_chl_name,$cat_chl_alias,0));
	$glb["templates"]->set_tpl('{$sort_links}',"");

	
	if($search!="")
	{
		$add1=$glb["p1"]==""?"":" AND `commodity_price`>='{$glb["p1"]}' ";
		
		$add1.=$glb["p2"]==""?"":" AND `commodity_price`<='{$glb["p2"]}' ";
		
		
		$pieces = explode(" ", $search);
		if(is_array($pieces) && count($pieces))
		{
			foreach($pieces as $key=>$value)
			{
				$value=str_replace(" ","",$value);
				$str.=" AND `com_name` LIKE '%{$value}%'";
			}
		}
		$sql = "SELECT *
		FROM `shop_commodity`
		WHERE `commodity_visible`='1' AND ((`com_name` LIKE '%{$search}%' OR `com_desc` LIKE '%{$search}%' OR `com_fulldesc` LIKE '%{$search}%' OR `cod` LIKE '%{$_SESSION["search"]}%') OR (1=1 {$str}))";
		$result_com = mysql_query($sql);
		if(mysql_num_rows($result_com)>0)
		{
			while($row=mysql_fetch_assoc($result_com))
			{
				$com_id[$row['commodity_ID']]=$row['commodity_ID'];
				$ident_array[$row['commodity_ID']] = $row['commodity_order'];
				$com_cod[$row['commodity_ID']]=$row['cod'];
				$com_first_price[$row['commodity_ID']]=get_true_price($row['commodity_old_price']>0?$row['commodity_old_price']:$row['commodity_price'],$row['cur_id']);
				$com_price[$row['commodity_ID']]=get_true_price($row['commodity_price'],$row['cur_id'],$_SESSION['user_discount']);
				
				$com_max_price=max($com_max_pric,$com_price[$row['commodity_ID']]);
				$com_bphoto[$row['commodity_ID']]=$row['commodity_bigphoto'];
				$commodity_new[$row['commodity_ID']]=$row["commodity_new"];
				$commodity_hit[$row['commodity_ID']]=$row["commodity_hit"];
				$commodity_action[$row['commodity_ID']]=$row["commodity_action"];
				$commodity_discount[$row['commodity_ID']]=$row["commodity_new"];
				$com_imgs[$row['commodity_ID']].="/images/commodities/{$row['commodity_ID']}/s_{$row['img_id']}.jpg;";
				$com_imgs2[$row['commodity_ID']].="/images/commodities/{$row['commodity_ID']}/{$row['img_id']}.jpg;";
				$com_alias[$row['commodity_ID']]=$row['alias'];
				$com_name[$row['commodity_ID']]=$row['com_name'];
				$com_desc[$row['commodity_ID']]=$row['com_desc']!=""?$row['com_desc']:reg_text($row['com_fulldesc'],600);
			}
		}
		$glb["filters_panel"]=str_replace('{$com_max_price}',$com_max_price,$glb["filters_panel"]);
		
	
		//Тут будут прописаны сортировки
		$glb["sort"]=1;
		$sort_desc=false;
		
		if(!(strpos($request_url,";sort=price1")===false))
		{
			//Если соритровка по цене
			$sort_array=$com_price;
			$group=1;
			$meta_end.=" - сортировка по цене";
		}elseif(!(strpos($request_url,";sort=price2")===false))
		{
			//Если соритровка по цене убывание
			$sort_array=$com_price;
			$sort_desc=true;
			$group=1;
			$meta_end.=" - сортировка по цене по убыванию";
		}elseif(!(strpos($request_url,";sort=name1")===false))
		{
			//Если соритровка по цене
			$sort_array=$com_name;
			$group=2;
			$meta_end.=" - сортировка по имени";
		}elseif(!(strpos($request_url,";sort=name2")===false))
		{
			//Если соритровка по цене убывание
			$sort_array=$com_name;
			$sort_desc=true;
			$group=2;
			$meta_end.=" - сортировка по имени по убыванию";
		}elseif(!(strpos($request_url,";sort=order1")===false))
		{
			//Если соритровка по цене
			$sort_array=$ident_array;
			$group=3;
			$meta_end.=" - сортировка по рейтингу";
		}elseif(!(strpos($request_url,";sort=order2")===false))
		{
			//Если соритровка по цене убывание
			$group=3;
			$sort_array=$ident_array;
			$sort_desc=true;
			$meta_end.=" - сортировка по рейтингу по убыванию";
		}else
		{
			//Сортировка по указаной в админке (по умолчанию)
			$group=3;
			$sort_array=$ident_array;
		}

		//Конец сортировок
		
		if(is_array($sort_array) && count($sort_array))
		{
			if(!$sort_desc)
			{
				//Сортировка масива по возрастанию
				asort($sort_array);
			}else
			{
				//Сортировка масива по убыванию
				arsort($sort_array);
			}
		}
		
		//=========================
	
		//=========================
		
		$items_on_page=9;
		$p_counter=0;
		$c_page=1;
		if(is_array($sort_array) && count($sort_array))
		{
			if(is_array($sort_array) && count($sort_array))
			foreach($sort_array as $c_id=>$key)
			{ 
				$show_by_price=true;
				if(is_numeric($glb["p1"])&&$com_price[$c_id]<$glb["p1"]){$show_by_price=false;}
				if(is_numeric($glb["p2"])&&$com_price[$c_id]>$glb["p2"]){$show_by_price=false;}
				if($show_by_price)
				{
					if($p_counter==$items_on_page){$p_counter=0;$c_page++;}
					$p_counter++;
					if($c_page==$page_id)
					{ 
						//на этом этапе мы реализируем вывод товаров только нужной нам страницы
						$com_url=$com_alias[$c_id]!=""?"/pr{$c_id}-".$com_alias[$c_id]."/":"/pr{$c_id}/";
						$com_src=($com_bphoto[$c_id]!=0)?"/{$c_id}stitle/{$com_alias[$c_id]}.jpg":"/templates/{$theme_name}/img/nophoto.jpg";
$comments=get_comments($com_id,"c");
						$glb["templates"]->set_tpl('{$com_commnets}',$comments["lines"]);
						$glb["templates"]->set_tpl('{$com_commnets_last}',$comments["last"]);
						$glb["templates"]->set_tpl('{$com_commnets_count}',$comments["count"]);
						$glb["templates"]->set_tpl('{$com_commnets_name}',$comments["name"]);
						$glb["templates"]->set_tpl('{$com_commnets_width}',$comments["width"]);
						
						$glb["templates"]->set_tpl('{$com_src}',$com_src);
						$glb["templates"]->set_tpl('{$com_src2}',$com_imgs[$c_id],$com_src.";");
						
						$glb["templates"]->set_tpl('{$c_name}',$com_name[$c_id]);
						$glb["templates"]->set_tpl('{$com_cod}',$com_cod[$c_id]);
						
						
						$glb["templates"]->set_tpl('{$com_old_price}',$com_first_price[$c_id]!=$com_price[$c_id]?$com_first_price[$c_id]." {$glb["cur_show"]}":"");
						$glb["templates"]->set_tpl('{$com_price}',$com_price[$c_id]);
						
						$glb["templates"]->set_tpl('{$c_shorttext}',$com_desc[$c_id]);
						$glb["templates"]->set_tpl('{$com_url}',$com_url);
						$glb["templates"]->set_tpl('{$com_id}',$c_id);
						$glb["templates"]->set_tpl('{$com_new}',$com_first_price[$c_id]!=$com_price[$c_id]&&$com_first_price[$c_id]>0?"<div class='cl_com_discount'>-".round(($com_first_price[$c_id]-$com_price[$c_id])/($com_first_price[$c_id]/100))."%</div>":"");
						$glb["templates"]->set_tpl('{$com_discount}',$commodity_new[$c_id]==1?"<div class='cl_com_new'>Новинка</div>":"");
						$commodity_all_lines.=$glb["templates"]->get_tpl("shop.commodity.short");
					}
				}
			}
		}
	}
	
	if($c_page>1)
	{
		
		$meta_end.=" - страница {$page_id}";
		for($i=1;$i<=$c_page;$i++)
		{
			$pager.="<li><a href='/search{$i}/'>{$i}</a><li>";
		}
		$pager="<ul class='cl_pager list_bottom_nav clearfix ld'>{$pager}</ul>";
	}
	if($commodity_all_lines!="")
	{
		$glb["templates"]->set_tpl('{$commodity_all_lines}',$commodity_all_lines);
		$commodities=$glb["templates"]->get_tpl("shop.all_commodities");
	}
	$glb["super_title"].=$meta_end;
	$glb["super_description"].=$meta_end;
	$glb["super_keywords"].=$meta_end;
	$glb["super_content"].=$meta_end;
	$glb["templates"]->set_tpl('{$sort_links}',$get_new_url_for_sort);
	$glb["templates"]->set_tpl('{$pager}',$pager);
	$glb["templates"]->set_tpl('{$filters}',$glb["filters_panel"]);
	$glb["templates"]->set_tpl('{$category_name}',$category_name);
	$glb["templates"]->set_tpl('{$category_desc}',$category_desc);
	
	$glb["templates"]->set_tpl('{$commodities}',$commodities);
	$ret=$glb["templates"]->get_tpl("shop.category.search");
	return $ret;
}

function generate_offer()
{
/**
* generate_offer
* Оформление заказа
* @version 2.12.27
*/

	global $glb,$cur_id,$cur_name,$cur_show,$cur_name,$cur_id;
	$user_id=get_userid_by_email($_SESSION["basket_user_email"]);	
	$date=date("Y-m-d");
	$offer_date=date("Y-m-d H:i:s");
	
	$sql="
	SELECT * FROM `shop_delivery` 
	WHERE `id`='{$_SESSION["delivery_method"]}';";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		$name2=$row["price"]>0?" - ".get_true_price($row["price"])." {$cur_show}":"";
		$name2.=$row["free"]>0?" (бесплатно от ".get_true_price($row["free"])." {$cur_show})":"";
		$sel_sposob_dostavki="{$row["name"]}{$name2}";
	}
	
	$sql="
	SELECT * FROM `shop_payments_methods` 
	WHERE `id`='{$_SESSION["payment_method"]}';";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		$name2=$row["commision"]>0?" -  (коммиссия {$row["commision"]}%)":"";
			
		$sel_sposob_oplaty="{$row["name"]}{$name2}";
	}
		
	$r_ip=$_SERVER['REMOTE_ADDR'];
	$trt=0;
	$sql="SELECT COUNT(*) AS `c` FROM `shop_orders` 
	WHERE `date`>'{$date} 00:00:00' AND `date`<'{$date} 23:59:59'";
	$row=mysql_fetch_assoc(mysql_query($sql));
	if($row)
	{
		$c=$row["c"]+1;
	}
	$cod=date("md")."/{$c}";
	if(isset($_SESSION["basket_items"]) && is_array($_SESSION["basket_items"]) && count($_SESSION["basket_items"]))
	{
		$query2 = "
		INSERT INTO `shop_orders` 
		SET
		`cod`='{$cod}',
		`date`='{$offer_date}',
		`name`='{$_SESSION["basket_user_name"]}',
		`email`='{$_SESSION["basket_user_email"]}',
		`tel`='{$_SESSION["basket_user_tel"]}',
		`city`='{$_SESSION["basket_user_city"]}',
		`address`='{$_SESSION["basket_user_adsress"]}',
		`user_comments`='{$_SESSION["basket_user_comments"]}',
		`user_id`='{$user_id}',
		`payment`='{$_SESSION["payment_method"]}',
		`discount`='{$_SESSION["discount_val"]}',
		`delivery`='{$_SESSION["delivery_method"]}',
		`delivery_price`='{$_SESSION["delivery_price"]}',
		`commission`='{$_SESSION["payment_commission"]}',
		`cur_id`='{$glb["cur_id"]}'
		";
		mysql_query($query2);	
		$order_id=mysql_insert_id();
		foreach ($_SESSION["basket_items"] as $keys=>$value)
		{
			$arr_data = explode(';',$keys);
			$com_id=$arr_data[0];
			$colorid=$arr_data[1];
			$sizeid=$arr_data[2];
			$trt++;
			
			$ii++;
			$sql="SELECT * FROM `shop_commodity`
			WHERE `commodity_ID`='{$com_id}' AND `lng_id`='{$glb["sys_lng"]}'  ";
			$row=mysql_fetch_assoc(mysql_query($sql));
			$price=get_true_price($row['commodity_price'],$row['cur_id']);
			$priceall=$price*$value;
			$basket_total_price1+=$priceall;
			$glb["templates"]->set_tpl('{$basket_com_url}',$row["alias"]!=""?"/pr{$com_id}-{$row["alias"]}/":"/pr{$com_id}/");
			$glb["templates"]->set_tpl('{$basket_com_src}',$row["commodity_bigphoto"]==1?"/{$row["commodity_ID"]}stitle/{$alias}.jpg":"/templates/{$theme_name}/img/nophoto.jpg");
			$glb["templates"]->set_tpl('{$basket_com_price}',$price);
			$glb["templates"]->set_tpl('{$basket_com_count}',$value);
			$glb["templates"]->set_tpl('{$basket_com_name}',$row["com_name"]);
			$glb["templates"]->set_tpl('{$basket_com_cod}',$row["cod"]);
			$glb["templates"]->set_tpl('{$basket_ii}',$ii);
			$glb["templates"]->set_tpl('{$basket_com_id}',"{$com_id};{$arr_data[1]};{$arr_data[2]}");
			$glb["templates"]->set_tpl('{$basket_com_desc}',$desc);
			$glb["templates"]->set_tpl('{$basket_lines}',$basket_lines);
			$basket_lines.=$glb["templates"]->get_tpl('shop.basket.mail.com_line',"../../../");	
			
			$query2 = "
			INSERT INTO `shop_orders_coms` 
			SET
			`offer_id`='{$order_id}',
			`com_id`='{$com_id}',
			`cur_id`='{$glb["cur_id"]}',
			`count`='{$value}',
			`price`='{$price}'
			";
			mysql_query($query2);
		}
	}

	 
				
	$basket_total_price2=round($basket_total_price1-$basket_total_price1*$_SESSION["discount_val"]/100);//Финальная стоимость с учетом скидки
	
	$basket_payment_commission=round($basket_total_price2/100*$_SESSION["payment_commission"]);
	$basket_total_price_final=$basket_total_price2+$_SESSION["delivery_price"]+$basket_payment_commission;//Финальная стоимость с учетом скидки и цены на доставку
	
	$glb["templates"]->set_tpl('{$sel_sposob_dostavki}',$sel_sposob_dostavki);
	$glb["templates"]->set_tpl('{$sel_sposob_oplaty}',$sel_sposob_oplaty);
	$glb["templates"]->set_tpl('{$basket_total_price1}',$basket_total_price1);
	$glb["templates"]->set_tpl('{$basket_lines}',$basket_lines);
	$glb["templates"]->set_tpl('{$basket_discount}',$_SESSION["discount_val"]);
	$glb["templates"]->set_tpl('{$basket_discount_price}',round($basket_total_price1/100*$_SESSION["discount_val"]));
	$glb["templates"]->set_tpl('{$basket_delivery_price}',$_SESSION["delivery_price"]);
	$glb["templates"]->set_tpl('{$basket_total_price_final}',$basket_total_price_final);
	$glb["templates"]->set_tpl('{$basket_commission}',$_SESSION["payment_commission"]);
	$glb["templates"]->set_tpl('{$basket_commission_price}',round($basket_total_price1/100*$_SESSION["payment_commission"]));
	$glb["templates"]->set_tpl('{$offer_date}',$offer_date);
	$glb["templates"]->set_tpl('{$offer_code}',$cod);
	$glb["templates"]->set_tpl('{$r_ip}',$r_ip);
	
	$glb["templates"]->set_tpl('{$basket_user_email}',$_SESSION["basket_user_email"]);
	$glb["templates"]->set_tpl('{$basket_user_name}',$_SESSION["basket_user_name"]);
	$glb["templates"]->set_tpl('{$basket_user_tel}',$_SESSION["basket_user_tel"]);
	$glb["templates"]->set_tpl('{$offer_city}',$_SESSION["basket_user_city"]);
	$glb["templates"]->set_tpl('{$offer_address}',$_SESSION["basket_user_adsress"]);
	$glb["templates"]->set_tpl('{$basket_user_comments}',$_SESSION["basket_user_comments"]);

	$mail_text1=$glb["templates"]->get_tpl('shop.basket.mail.text1',"../../../");
	$mail_text2=$glb["templates"]->get_tpl('shop.basket.mail.text2',"../../../");
	send_mime_mail("CMS","noreply@".$glb["dom_mail"],"Shop Manager",$glb["sys_mail"],"utf-8","utf-8","Новый заказ",$mail_text1);
	send_mime_mail($glb["dom_mail"],$glb["sys_mail"],$_SESSION["basket_user_name"],$_SESSION["basket_user_email"],"utf-8","utf-8","Ваш заказ на сайте {$glb["dom_mail"]}",$mail_text2);
	
	$mail_text1="{$_SESSION["basket_user_name"]} - {$_SESSION["basket_user_tel"]}";
			send_mime_mail("CMS","noreply@".$glb["dom_mail"],"Shop Manager","380963573505@sms.kyivstar.net","utf-8","utf-8","Zakaz:",$mail_text1);
			
	unset($_SESSION["basket_items"]);
}


function get_userid_by_email($email)
{
	$sql="SELECT * FROM `users` 
	WHERE `user_email`='{$email}'";
	$row=mysql_fetch_assoc(mysql_query($sql));
	if($row)
	{
		$user_id=$row["user_id"];
	}else
	{
		$user_id=user_auto_reg($_POST["basket_user_name"],$_POST["basket_user_tel"],$email,$_POST["offer_city"]);
	}
	return $user_id;
}

function get_basket_full()
{
/**
* get_basket_full
* Выводит страницу корзины
* @version 2.12.27
*/

	global $glb;
	//Предварительные настройки
		
	$glb["teg_robots"]=true;
	$glb["super_title"].="Корзина. Здесь вы можете оформить заказ";
	$glb["super_description"].="Корзина. Здесь вы можете оформить заказ";
	$glb["super_keywords"].="Корзина. Здесь вы можете оформить заказ";
	$glb["super_content"].="Корзина. Здесь вы можете оформить заказ";
	$ret=
	"
	        <div class='mainframe'>
            <div class='mfrhld_mn'>
                <div class='dmy mn content_box'>
	<script>
	jQuery(document).ready(function () {
		jQuery('.sidebar').hide();
		getbasketfull();
		
	});</script>
	<div class='cl_basket_full_content'></div>
 </div>
            </div>
        </div>
	";
	
	return $ret;
}
function get_basket_panel()
{
	global $glb;
	
	$change_basket=false;
	if(isset($_POST["commodityID"]))
	{
		$basket_items[$_POST["commodityID"]]=$_POST["commodity_count"];
		//Добавление товара в корзину путем нажатия на кнопку купить
		$change_basket=true;
	}
	if(is_array($_SESSION["basket_items"]) && count($_SESSION["basket_items"])>0)
	foreach($_SESSION["basket_items"] as $key=>$value)
	{
		$basket_items[$key]+=$value;
		//Формирование предварительного списка товаров + суммирование с только что добавленным товаром
	}
	if(isset($_POST["basket_com_id"]))
	{
		$basket_items[$_POST["basket_com_id"]]=$_POST["basket_com_count"];
		//Указание конкретного количества товара в корзине 
		$change_basket=true;
	}
	if(is_numeric($_POST["basket_clean"]))
	{
		unset($basket_items);
		$lines="";
		//Очистка корзины
	}
	if(isset($basket_items) && is_array($basket_items) && count($basket_items)>0)
	foreach($basket_items as $key=>$value)
	{ 
		if($value>0)
		{
			$all_count+=$basket_items[$key];
			$arr_data = explode(';',$key);			
			$com_id=trim($arr_data[0]);
			$lines.=" OR `commodity_ID`='{$com_id}'";
			$check[$com_id]+=$value;
		}else
		{
			unset($basket_items[$key]);
		}
	}
	$sql="
	SELECT * FROM `shop_commodity` 
	WHERE 1=0 {$lines};";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		$all_prices+=get_true_price($row['commodity_price'],$row['cur_id'])*$check[$row["commodity_ID"]];
	}

	$_SESSION["basket_items"]=$basket_items;
	
	$glb["templates"]->set_tpl('{$basket_items_count}',is_numeric($all_count)?$all_count:0);
	$glb["templates"]->set_tpl('{$basket_items_price}',$all_prices=$all_prices!=""?$all_prices:0);
	$ret=$glb["templates"]->get_tpl('shop.basket_panel');
	$ret=str_replace("В корзиее 0 товар(ов) (0  грн.)","Корзина пока пуста",$ret);
	
	if(isset($_POST["commodityID"]))
	{
	$com_id=current(split(";",$_POST["commodityID"]));
	
	
		$glb["templates"]->set_tpl('{$com_price_offer}',get_true_price($row["commodity_price"]));
		$sql="
		SELECT * FROM `shop_commodity`
		WHERE `commodity_ID`='{$com_id}';";
		$res=mysql_query($sql);
		while($row=mysql_fetch_assoc($res))
		{
		$src1=$row["commodity_bigphoto"]==1?"/{$row["commodity_ID"]}stitle/{$alias}.jpg":"/templates/{$theme_name}/img/nophoto.jpg";
		$src2=$row["commodity_bigphoto"]==1?"/{$row["commodity_ID"]}btitle/{$alias}.jpg":"/templates/{$theme_name}/img/nophoto.jpg";
			$glb["templates"]->set_tpl('{$com_name}', $row["com_name"]);
			$glb["templates"]->set_tpl('{$com_price_offer}',get_true_price($row["commodity_price"],$row["cur_id"]));
			$glb["templates"]->set_tpl('{$com_cod}', $row["cod"]);
			$glb["templates"]->set_tpl('{$com_src_offer}',$src1);
			$glb["templates"]->set_tpl('{$com_src2}',$src2);
		}
	
		$new_item=$glb["templates"]->get_tpl('shop.basket_new_item');
		$glb["templates"]->set_tpl('<!--{$new_item}-->',$new_item);
	}
	return $ret;
}

function get_addition_photos($com_id,$src1,$src2)
{
	global $glb;
	//$ret.="<li><a href='{$src2}'  rel='prettyPhoto[gallery3]' ><img src='{$src1}' /></li>";
	$sql="
	SELECT * FROM `shop_images` 
	WHERE `com_id`='{$com_id}'
	ORDER BY `order`;";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		$ret.="<li class=''><a href='#/images/commodities/{$com_id}/{$row["img_id"]}.jpg'  rel='prettyPhoto[gallery2]' onclick='return false;'><img src='/images/commodities/{$com_id}/s_{$row["img_id"]}.jpg' /></a></li>";
	}
	$glb["templates"]->set_tpl('{$addition_photo2}',$ret!=""?str_replace("gallery2","gallery3",$ret):"<style>.no_add_photo{display:none!important}</style>");
	$ret=$ret!=""?"{$ret}":"";
	return $ret;
}

function get_text_filters($com_id)
{
	global $glb;
	$sql="
	SELECT * FROM `shop_filters-values` 
	INNER JOIN `shop_categories-filters` ON `shop_categories-filters`.`filtr_id`=`shop_filters-values`.`ticket_filterid`
	WHERE `ticket_id`='{$com_id}' AND `lng_id`='{$glb["sys_lng"]}' AND `filtr_typeid`='1'
	ORDER BY `filtr_order`;";
	$res=mysql_query($sql);
	$i=1;
	while($row=mysql_fetch_assoc($res))
	{
		$i=-$i;
		$cl=$i>0?"cl_text_filters_tr1":"cl_text_filters_tr2";
		$ret.="<tr class='{$cl}'><td class='cl_text_filters_td1'>{$row['filtr_name']}</td><td class='cl_text_filters_td2'> {$row['ticket_value']}</td></tr>";
		$glb["templates"]->set_tpl('{$itemfilter'.$row["filtr_id"].'}',is_numeric($all_count)?$all_count:0);
	}
	
		$sql="
	SELECT * FROM `shop_filters-values` 
	INNER JOIN `shop_categories-filters` ON `shop_categories-filters`.`filtr_id`=`shop_filters-values`.`ticket_filterid`
	WHERE `ticket_id`='{$com_id}' AND `lng_id`='{$glb["sys_lng"]}' AND `filtr_typeid`='4'
	ORDER BY `filtr_order`;";
	$res=mysql_query($sql);
	$i=1;
	while($row=mysql_fetch_assoc($res))
	{	
		$glb["templates"]->set_tpl('{$itemfilter'.$row["filtr_id"].'}',$row['ticket_value']);
	}
	
	$ret=$ret!=""?"<table class='cl_text_filters'>{$ret}</table>":"";
	return $ret;
}

function get_text_filters2($com_id)
{
	global $glb;
	$sql="
	SELECT * FROM `shop_filters-values` 
	INNER JOIN `shop_categories-filters` ON `shop_categories-filters`.`filtr_id`=`shop_filters-values`.`ticket_filterid`
	WHERE `ticket_id`='{$com_id}' AND `lng_id`='{$glb["sys_lng"]}' AND `filtr_typeid`='4' AND `visible`='1' AND `ticket_value`<>''
	ORDER BY `filtr_order`;";
	
	
	$res=mysql_query($sql);

	while($row=mysql_fetch_assoc($res))
	{
		if($row['ticket_value']!="")
		{
			$text_filters2_lines.="<li>{$row['filtr_name']}</li>";
			$text_filters2_lines2.="<div class='tabs-box'>{$row['ticket_value']}</div>";
		}
		
		
	}
	$glb["templates"]->set_tpl('{$text_filters2_lines}',$text_filters2_lines);
	$glb["templates"]->set_tpl('{$text_filters2_lines2}',$text_filters2_lines2);
	$ret=$ret!=""?"<div class='cl_text_filters2'>{$ret}</div>":"";
	/*$ret=preg_replace ("!<a.*?href=\"?'?([^ \"'>]+)\"?'?.*?>(.*?)</a>!is", "\\2", $ret);*/

	
	return $ret;
}
function get_id_of_internal_cats($array_categories,$cat_id=0)
{
	if(is_array($array_categories) && count($array_categories)>0)
	foreach($array_categories as $key=>$value)
	{
		if($value==$cat_id)
		$ret.=" OR `categoryID`='{$key}'".get_id_of_internal_cats($array_categories,$key);
	}

	return $ret;
}

function get_shop_breadcrumb($array_categories,$cat_id,$cat_chl_name,$cat_chl_alias,$bstep,$com_url="",$com_name="")
{
	global $glb;
	
	$bstep++;
	$url=$cat_chl_alias[$cat_id]!=""?"/c{$cat_id}-{$cat_chl_alias[$cat_id]}/":"/c{$cat_id}/";
	if($cat_id==0)
	{
		$url="/shop/";
		$cat_chl_name[$cat_id]="Каталог";
	}else
	{
	$ret="<li class='separator'>&#8594;</li><li typeof='v:Breadcrumb'>  <a href='{$url}' title='{$cat_chl_name["$cat_id"]}' rel='v:url' property='v:title'>{$cat_chl_name["$cat_id"]}</a></li>";
	}
	$ret2=$cat_id>0?get_shop_breadcrumb($array_categories,$array_categories[$cat_id],$cat_chl_name,$cat_chl_alias,$bstep):"";
	$glb["filter_string"].=" OR `fitr_catid`='{$cat_id}' ";
	$last=$com_name!=""?"<li class='separator'></li><li typeof='v:Breadcrumb'>  <a href='{$com_url}' title='{$com_name}' rel='v:url' property='v:title'>{$com_name}</a></li>":"";
	return $bstep==1?"<ul class='cl_breadcrumb'><li typeof='v:Breadcrumb'><a href='/' title='{$glb["main_page_title"]}' rel='v:url' property='v:title'>Главная</a></li>{$ret2}{$ret}{$last}</ul>":"{$ret2}{$ret}";
}
function get_filters_panel($array_categories,$cat_id,$cat_url="",$req_url='')
{
	global $glb,$request_url;
	
	$sql2="
	SELECT 
	`filtr_id`, `filtr_order`, 
	`fitr_catid`, `filtr_typeid`, 
	`necessarily`, `add_date`, 
	`filtr_id`, `lng_id`, 
	`filtr_name`, `filtr_desc` 
	FROM `shop_categories-filters`  
	WHERE (`fitr_catid`='{$cat_id}' {$glb["filter_string"]} ) AND `filtr_typeid`='2'
	";
	$result2=mysql_query($sql2);	
	if(mysql_num_rows($result2) > 0){
		while($row2 = mysql_fetch_assoc($result2)){
			$filtr_array[$row2['filtr_id']]=1;
		}	
		$glb["filtr_array"]=$filtr_array;//AAA2
	}
	if(isset($glb["filtr_array"]) && is_array($glb["filtr_array"]) && count($glb["filtr_array"]))
	foreach($glb["filtr_array"] as $key=>$value)
	{
		$found_ids.=$found_ids==""?"{$key}":",{$key}";
	}
	if($found_ids!="")
	{
		$sql="
		SELECT * FROM `shop_filters-values` 
		WHERE `ticket_filterid` IN ($found_ids);";
		$res=mysql_query($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$avafl[$row["ticket_id"]."|".$row["ticket_filterid"]."|".$row["ticket_value"]]=1;
		}
	}
	
	$glb["avafl"]=$avafl;

			
	$result2=mysql_query($sql2);	
	
	if(mysql_num_rows($result2) > 0){
		
		
		while($row = mysql_fetch_assoc($result2)){
			
			$value = !empty($comodityID)?get_filter_values($comodityID, $row['filtr_id']):'';

			switch($row['filtr_typeid']){
				case 1: $final_str .= "{$row['filtr_name']}: <input name='filter[{$row['filtr_id']}]' value='{$value}'> <br />";break;
				case 2: $list = get_parent_filter($row['filtr_id'], (is_numeric($value) or is_array($value))?$value:'',"");
				$final_str .= ($row['list_parentfiltrid']==0)?"<table><tr><td><div class='cl_tr1'><span class='title_lic'>{$row['filtr_name']}:</span>{$list}<div style='clean:both;'></div></div></td></tr></table>":'';break;
				case 3: $final_str .= "{$row['filtr_name']}: <input name='filter[{$row['filtr_id']}]' value='{$value}'><br />";break;
			}		
		}
	
	}else
	{
		return "<style>.for_check{display:none;}</style>";
	}
		$response=str_replace("/",";","{$request_url};");
		$match_expression = "/p1=([0-9]+?);/US";
		preg_match($match_expression,$response,$matches);
		if($matches[1]!="")
		{
			$glb["p1"]=$matches[1];	
		}else
		{
			$glb["p1"]=0;		
		}
		$match_expression = "/p2=([0-9]+?)/US";
		preg_match($match_expression,$response,$matches);
		if($matches[1]!="")
		{
			$glb["p2"]=$matches[1];	
		}else
		{
			$glb["p2"]=99809;		
		}
		
	$ret.="
<div class='block filter'>
	<div class='f-wrapper'>
		<div class='formCost'>
			<label for='minCost'>Цена: от</label> <input type='text' id='minCost' value='{$glb["p1"]}'/>
			<label for='maxCost'>до</label> <input type='text' id='maxCost' value='{$glb["p2"]}'/>
		</div>
		<div class='sliderCont'>
			<div id='slider'></div>
		</div>
	</div>
</div>
<script>
var p1,p2;
var url2=decodeURIComponent(document.location.pathname);

jQuery(document).ready(function(){


/* слайдер цен */


jQuery('#slider').slider({
	min: 0,
	max: 5000,
	values: [{$glb["p1"]},{$glb["p2"]}],
	range: true,
	stop: function(event, ui) {
		jQuery('input#minCost').val(jQuery('#slider').slider('values',0));
		jQuery('input#maxCost').val(jQuery('#slider').slider('values',1));
		search_form();
		
    },
    slide: function(event, ui){
		jQuery('input#minCost').val(jQuery('#slider').slider('values',0));
		jQuery('input#maxCost').val(jQuery('#slider').slider('values',1));
    }
});

jQuery('input#minCost').change(function(){

	var value1=jQuery('input#minCost').val();
	var value2=jQuery('input#maxCost').val();

    if(parseInt(value1) > parseInt(value2)){
		value1 = value2;
		jQuery('input#minCost').val(value1);
	}
	jQuery('#slider').slider('values',0,value1);	
});

	
jQuery('input#maxCost').change(function(){
		
	var value1=jQuery('input#minCost').val();
	var value2=jQuery('input#maxCost').val();
	
	

	if(parseInt(value1) > parseInt(value2)){
		value2 = value1;
		jQuery('input#maxCost').val(value2);
	}
	jQuery('#slider').slider('values',1,value2);
});






});

</script>
<style>
.cl_hhhide
{
	display:block;
}
</style>
	";
	$ret.="<div class='list_check clearfix'>".$final_str."</div><div style='clean:both;'></div>";
	$ret.=$cat_url!=""?"
	
	<input type='submit' class='button_check bat' value='Сбросить фильтр' onclick=\"location.href='{$cat_url}';\" />	
	
	":"";
	return $ret;
}


function parse_request_filter_url(){
	global $request_url,$glbf,$glbu;
	//парсер $request_url
	$filters = explode(";", $request_url);
	if(is_array($filters) and count($filters)>0){
	
		foreach($filters as $key=>$value){
		
			$v_and_k = explode("=", $value);
			if(stristr($v_and_k[1], ","))
			{
				$value_arr = explode(",", $v_and_k[1]);
				foreach($value_arr as $val)
				{
					$final_arr[intval($v_and_k[0])][]=intval($val);
					$glbf[intval($val)]=intval($v_and_k[0]);
				}
			}elseif(stristr($v_and_k[1], "-"))
			{
				$value_arr=explode("-", $v_and_k[1]);
				$final_arr[intval($v_and_k[0])]["over"]=$value_arr[0];
				$final_arr[intval($v_and_k[0])]["under"]=$value_arr[1];
			}else	
			{
				$final_arr[intval($v_and_k[0])]=intval($v_and_k[1]);
				$glbf[intval($v_and_k[1])]=intval($v_and_k[0]);
				
			}
		}
	}
	
	return $final_arr;
}
function create_url($first,$second)
{
	global $glbf,$request_url;
	$request_url2=urldecode(str_replace("/","",$request_url));
	if(strpos($request_url2,";{$first}=")===false)
	{
		$new_url=strpos($request_url2,"{$first}={$second}")===false?"{$request_url2};{$first}={$second}":str_replace("{$first}={$second}","",$request_url2);
	}else
	{
		if(strpos($request_url2,";{$first}={$second}")===false)
		{
			$request_url2.=",";
			if(strpos($request_url2,"{$second},")===false)
			{
				
				
				if(strpos($request_url2,"{$second};")===false)
				{
					
					$new_url=str_replace("{$first}=","{$first}={$second},",$request_url2);
				}else
				{
					$new_url=str_replace("{$second};",";",$request_url2);
				}
			}else
			{
				$new_url=str_replace("{$second},","",$request_url2);
			}
			
		}else
		{
			$new_url=str_replace("{$first}={$second}","{$first}=",$request_url2);
		}
		
	}
	
	$new_url.="/";
	$new_url=str_replace("{$first}=;","",$new_url);
	$new_url=str_replace("{$first}=/","",$new_url);
	$new_url=str_replace("/","",$new_url);
	
	
	$new_url="/{$new_url}/";
	$new_url=str_replace(",;",";",$new_url);
	$new_url=str_replace(";;",";",$new_url);
	$new_url=str_replace(";/","/",$new_url);
	$new_url=str_replace(",/","/",$new_url);
	$new_url=str_replace("=,","=",$new_url);
	return $new_url;
}
function get_filtr_par_count($list_parentfiltrid,$id,$checked)
{
	global $glb;
	$avafl=$glb["avafl"];
	
	$found_ids_arry=$glb["found_ids_arry"];

	if(is_array($found_ids_arry) && count($found_ids_arry))
	foreach($found_ids_arry as $key2=>$value2)
	{
		$ret+=$avafl["{$key2}|{$list_parentfiltrid}|{$id}"];	
	}
	$ret=$checked==""?$ret:min($glb["minval"],$ret);
	
	return is_numeric($ret)?$ret:0;
}
function get_parent_filter($list_parentfiltrid, $value='', $sel_name='list_parentid')
{	
	global $glbf,$request_url,$glb;
	$ret = "";
	$sql = "SELECT * FROM `shop_filters-lists` WHERE `list_filterid`='{$list_parentfiltrid}'  ORDER BY `list_order`";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) > 0) {
		while($row = mysql_fetch_assoc($result)){
			$id[0] = $row['id'];
			$checked=$glbf[$row['id']]!=""?"checked":"";
			$new_url=create_url($row['list_filterid'],$row['id']);
			$vval=get_filtr_par_count($list_parentfiltrid,$row['id'],$checked);
			$disabled=$vval==0?"disabled":"";
			$new_url=$vval==0?"#":$new_url;
			$new_url2=$vval==0?"":"onClick=\"location.href='{$new_url}'\"";
			$new_url3=$vval==0?"onClick=\"return false\"":"";
			$ret .= $row["list_parentid"]==0?"<li class='clearfix'><div class='cl_filter_checkbox_div'><input type='checkbox' value='{$row['id']}' {$checked} {$disabled} {$new_url2}> <a href='{$new_url}' class='{$disabled}' {$new_url3}>{$row['list_name']} ({$vval})</a></div></li>":"";
			$options2=$row["list_parentid"]>0?$row["list_parentid"]:$options2;

			$options3=$row["list_parentfiltrid"];
		}
	}
	
	return $ret;

}

//=========================================================================
function ss_catalogue($cat_id,$st)
{
	global $sys_lng,$description,$aliases,$parents,$orders,$orders2,$upprices;
	$st++; 
	if(is_array($orders2) && count($orders2))
	foreach($orders2 as $keys=>$values)
	{
		if($parents[$keys]==$cat_id)
		{
			$r_category_id=$keys;
			$r_category_name=$description[$keys]!=""?$description[$keys]:"нет описания";
			$alias=$aliases[$keys];
			$order=$orders[$keys];
			$url=$alias!=""?"/c{$r_category_id}-{$alias}/":"/c{$r_category_id}/";
			$inner=ss_catalogue($r_category_id,$st);
			$inner2=$inner!=""?" class='parent' ":"";
			$all_lines.="<li {$inner2}><a href='{$url}' class='класс-{$r_category_name}'>{$r_category_name}</a>{$inner}</li>";	
		}
	}
	$ret=$all_lines!=""&&$st>1?"<ul>".$all_lines."</ul>":$all_lines;
	return $ret;
}

function get_catalogue($fcatid=0)
{
	global $glb,$sys_lng,$description,$aliases,$parents,$orders,$orders2,$upprices;
	

	$sql="
	SELECT * FROM `shop_categories` ORDER BY `categories_of_commodities_order`;";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		$parents[$row["categories_of_commodities_ID"]]=$row["categories_of_commodities_parrent"];
		$orders[$row["categories_of_commodities_ID"]]=$row["categories_of_commodities_order"];
		$orders2[$row["categories_of_commodities_ID"]]=$row["categories_of_commodities_order"];
		$description[$row["categories_of_commodities_ID"]]=$row["cat_name"];
		$aliases[$row["categories_of_commodities_ID"]]=$row["alias"];
	}
	$glb["cat_names"]=$description;
	$glb["cat_aliases"]=$aliases;
	$glb["cat_parrents"]=$parents;
	$all_lines=ss_catalogue($fcatid,0);
	
	return $all_lines;
}


function get_all_cat_on_one_page()
{
	global $glb,$sys_lng,$description,$aliases,$parents,$orders,$orders2,$upprices;
	
	$cat_id=0;
	$count_local=0;
	if(is_array($orders2) && count($orders2))
	foreach($orders2 as $keys=>$values)
	{
		if($parents[$keys]==$cat_id)
		{
			$iiner="";
			$r_category_id=$keys;
			$inner_i=0;
			$alias=$aliases[$keys];
			$order=$orders[$keys];
			$url=$alias!=""?"/c{$r_category_id}-{$alias}/":"/c{$r_category_id}/";
			foreach($orders2 as $keys2=>$values2)
			{
				if($parents[$keys2]==$r_category_id)
				{
					$r_category_id2=$keys2;
					$r_category_name2=$description[$keys2]!=""?$description[$keys2]:"нет описания";
					$alias2=$aliases[$keys2];
					$order2=$orders[$keys2];
					$url2=$alias!=""?"/c{$r_category_id2}-{$alias2}/":"/c{$r_category_id2}/";
					
					$inner_i++;
					$iiner.="<a href='{$url2}'>{$r_category_name2}</a> ";
					
				}
			}
			
			$r_category_name=$description[$keys]!=""?$description[$keys]:"нет описания";

			
			$count_local++;
			$all_lines.="
			<li class='{$r_category_name}'>
				<a class='cat-h' href='{$url}'>{$r_category_name}</a>
				{$iiner}
			</li>
			";	
		}
	}
	$height="";
	return $all_lines;
	
}
//=========================================================================


function get_commodities_in_main($param='hit',$header_name="")
{
	global $glb,$theme_name;
	$commodity_all_lines='';
	$params=array(
		'hit'=>'commodity_hit',
		'action'=>'commodity_action',
		'new'=>'commodity_new',
	);
	if(empty($params[$param]))
		return '';
	$sql = "SELECT distinct
	`commodity_ID`, `cod`, `commodity_old_price`, `commodity_price`, `com_desc`,`cur_id`, `commodity_bigphoto`, `commodity_order`,`alias`,`com_name`,
	`commodity_order`,`commodity_new`,`commodity_hit`,`commodity_action`
	FROM `shop_commodity`
	
	WHERE `commodity_visible`='1' AND `{$params[$param]}`='1' 

	LIMIT 0,8
	";
	$result_com = mysql_query($sql);
	if(mysql_num_rows($result_com)>0)
	{
		while($row=mysql_fetch_assoc($result_com))
		{
			$ident_array[$row['commodity_ID']] = $row['commodity_order'];
			$com_cod[$row['commodity_ID']]=$row['cod'];
			$com_first_price[$row['commodity_ID']]=get_true_price($row['commodity_old_price'],$row['cur_id']);
			$com_price[$row['commodity_ID']]=get_true_price($row['commodity_price'],$row['cur_id']);
			$com_bphoto[$row['commodity_ID']]=$row['commodity_bigphoto'];
			$commodity_new[$row['commodity_ID']]=$row["commodity_new"];
			$commodity_hit[$row['commodity_ID']]=$row["commodity_hit"];
			$commodity_action[$row['commodity_ID']]=$row["commodity_action"];
			$commodity_discount[$row['commodity_ID']]=$row["commodity_new"];
			$sql_com_desc_end.=" OR `com_id`='{$row['commodity_ID']}' ";
			$com_alias[$row['commodity_ID']]=$row['alias'];
			$com_name[$row['commodity_ID']]=$row['com_name'];
			$com_desc[$row['commodity_ID']]=$row['com_desc'];
			$arr_data2[$row['commodity_ID']]=$row['commodity_ID'];
		}
	}

	if(is_array($arr_data2) && count($arr_data2)>0)
	foreach($arr_data2 as $key=>$value)
	{ 
		$c_id=trim($value);
		if(is_numeric($c_id))
		{
			//на этом этапе мы реализируем вывод товаров только нужной нам страницы
			$com_url=$com_alias[$c_id]!=""?"/pr{$c_id}-".$com_alias[$c_id]."/":"/pr{$c_id}/";
			$com_src=($com_bphoto[$c_id]!=0)?"/{$c_id}stitle/{$com_alias[$c_id]}.jpg":"/templates/{$theme_name}/img/nophoto.jpg";
					
					
			$glb["templates"]->set_tpl('{$com_src}',$com_src);
			
					
			$glb["templates"]->set_tpl('{$com_id}',$c_id);
			$glb["templates"]->set_tpl('{$c_name}',$com_name[$c_id]);
			$glb["templates"]->set_tpl('{$com_cod}',$com_cod[$c_id]);
		
			$glb["templates"]->set_tpl('{$com_old_price}',$com_first_price[$c_id]!=$com_price[$c_id]?$com_first_price[$c_id]:"");
			$glb["templates"]->set_tpl('{$com_price}',$com_price[$c_id]);
			$glb["templates"]->set_tpl('{$c_shorttext}',reg_text($com_desc[$c_id],600));
			$glb["templates"]->set_tpl('{$com_url}',$com_url);
			$glb["templates"]->set_tpl('{$com_new}',$com_first_price[$c_id]!=$com_price[$c_id]&&$com_first_price[$c_id]>0?"<div class='cl_com_discount'>-".round(($com_first_price[$c_id]-$com_price[$c_id])/($com_first_price[$c_id]/100))."%</div>":"");
			$glb["templates"]->set_tpl('{$com_discount}',$commodity_new[$c_id]==1?"<div class='cl_com_new'>Новинка</div>":"");
			$commodity_all_lines.=$glb["templates"]->get_tpl('shop.commodity.special');

			$commodity_all_lines2.="<img src='{$com_src}' onclick=\"location.href='{$com_url}';\" />";
		}
	}
	
	return $commodity_all_lines;
}

function get_commodities_in_block($param='hit',$header_name)
{
	global $glb,$theme_name;
	
	$commodity_all_lines='';
	$params=array(
		'hit'=>'commodity_hit',
		'action'=>'commodity_action',
		'new'=>'commodity_new',
	);
	if(empty($params[$param]))
		return '';
	$sql = "SELECT
	`commodity_ID`, `cod`, `commodity_old_price`, `commodity_price`, `cur_id`, `com_name`, `commodity_bigphoto`, `commodity_order`,
	`commodity_order`,`commodity_new`,`commodity_hit`,`commodity_action`,`categoryID`
	FROM `shop_commodity`
	INNER JOIN `shop_commodities-categories` ON `shop_commodity`.`commodity_ID`=`shop_commodities-categories`.`commodityID`
	WHERE `commodity_visible`='1' AND `{$params[$param]}`='1'
	ORDER BY RAND()
	LIMIT 0,4
	";
	$result_com = mysql_query($sql);
	if(mysql_num_rows($result_com)>0)
	{
		while($row=mysql_fetch_assoc($result_com))
		{
			$ident_array[$row['commodity_ID']] = $row['commodity_order'];
			$com_cod[$row['commodity_ID']]=$row['cod'];
			$com_first_price[$row['commodity_ID']]=get_true_price($row['commodity_old_price'],$row['cur_id']);
			$com_price[$row['commodity_ID']]=get_true_price($row['commodity_price'],$row['cur_id']);
			$com_bphoto[$row['commodity_ID']]=$row['commodity_bigphoto'];
			$commodity_new[$row['commodity_ID']]=$row["commodity_new"];
			$commodity_hit[$row['commodity_ID']]=$row["commodity_hit"];
			$commodity_action[$row['commodity_ID']]=$row["commodity_action"];
			$commodity_discount[$row['commodity_ID']]=$row["commodity_new"];
			$com_alias[$row['commodity_ID']]=$row['alias'];
			$com_name[$row['commodity_ID']]=$row['com_name'];
			$com_desc[$row['commodity_ID']]=$row['com_desc'];
			$sql_com_desc_end.=" OR `com_id`='{$row['commodity_ID']}' ";
			
			$arr_data2[]=$row['commodity_ID'];
		}
	}

			

	$sql = "SELECT *
	FROM `shop_images`
	WHERE  (1=0 {$sql_com_desc_end})
	ORDER BY `order`";
	$result_com = mysql_query($sql);
	if(mysql_num_rows($result_com)>0)
	{
		while($row=mysql_fetch_assoc($result_com))
		{
			$com_imgs[$row['com_id']].="/images/commodities/{$row['com_id']}/s_{$row['img_id']}.jpg;";
			$com_imgs2[$row['com_id']].="/images/commodities/{$row['com_id']}/{$row['img_id']}.jpg;";
		}
	}	

	if(is_array($arr_data2) && count($arr_data2)>0)
	foreach($arr_data2 as $key=>$value)
	{ 
		$c_id=trim($value);
		if(is_numeric($c_id))
		{
			//на этом этапе мы реализируем вывод товаров только нужной нам страницы
			$com_url=$com_alias[$c_id]!=""?"/pr{$c_id}-".$com_alias[$c_id]."/":"/pr{$c_id}/";
			$com_src=($com_bphoto[$c_id]!=0)?"/{$c_id}stitle/{$com_alias[$c_id]}.jpg":"/templates/{$theme_name}/img/nophoto.jpg";
					
					
			$glb["templates"]->set_tpl('{$com_src}',$com_src);
			$glb["templates"]->set_tpl('{$com_src2}',$com_imgs[$c_id],$com_src.";");
					
			$glb["templates"]->set_tpl('{$com_id}',$c_id);
			$glb["templates"]->set_tpl('{$c_name}',$com_name[$c_id]);
			$glb["templates"]->set_tpl('{$com_cod}',$com_cod[$c_id]);
		
			$glb["templates"]->set_tpl('{$com_old_price}',$com_first_price[$c_id]!=$com_price[$c_id]?$com_first_price[$c_id]:"");
			$glb["templates"]->set_tpl('{$com_price}',$com_price[$c_id]);
			$glb["templates"]->set_tpl('{$c_shorttext}',reg_text($com_desc[$c_id],100));
			$glb["templates"]->set_tpl('{$com_url}',$com_url);
			$glb["templates"]->set_tpl('{$com_new}',$com_first_price[$c_id]!=$com_price[$c_id]&&$com_first_price[$c_id]>0?"<div class='cl_com_discount'>-".round(($com_first_price[$c_id]-$com_price[$c_id])/($com_first_price[$c_id]/100))."%</div>":"");
			
				$glb["templates"]->set_tpl('{$com_discount}',$commodity_new[$c_id]==1?"<div class='cl_com_new'>New</div>":"");
						$glb["templates"]->set_tpl('{$com_action}',$commodity_action[$c_id]==1?"<span class='red_price'>супер цена</span>":"");
						$glb["templates"]->set_tpl('{$com_hit}',$commodity_hit[$c_id]==1?"<span class='good_price'>хит продаж</span>":"");
			$commodity_all_lines.=$glb["templates"]->get_tpl('shop.commodity.block.line');

			$commodity_all_lines2.="<img src='{$com_src}' onclick=\"location.href='{$com_url}';\" />";
		}
	}
	$glb["templates"]->set_tpl('{$header_name}',$header_name);
	$glb["templates"]->set_tpl('{$lines}',$commodity_all_lines);
	$center=$glb["templates"]->get_tpl("shop.commodity.block");
	return $center;
}

function get_discount_val($user_id=0)
{
	global $dostavka_defcur;
	return 0;
$res=0;
$user_id=$user_id==0?$_SESSION['user_id']:$user_id;
if(is_numeric($user_id)&&($user_id>0))
{
	if($dostavka_defcur==1)
	{
		$query = "
SELECT sum(`offer_price2`*`cur_val`*`offer_count`) AS `count_price` FROM `office_offers`
INNER JOIN `office_statuses` ON `office_statuses`.`status_id`=`office_offers`.`offer_statusid`
WHERE `status_id`<3
AND `offer_userid`='{$user_id}';
";
	}else
	{
		$query = "
SELECT sum(`offer_price2`*`offer_count`) AS `count_price` FROM `office_offers`
INNER JOIN `office_statuses` ON `office_statuses`.`status_id`=`office_offers`.`offer_statusid`
WHERE `status_id`<3
AND `offer_userid`='{$user_id}';
";
	}
	$result = mysql_query($query);
	if (mysql_num_rows($result) > 0)
	{
		$row = mysql_fetch_object($result);
		$count_price=$row->count_price;

		$query="
SELECT * FROM `shop_discount2`
WHERE `dis_val1`<'{$count_price}'
ORDER BY `dis_val1` DESC
;
";
		$result=mysql_query($query);
		if (mysql_num_rows($result) > 0)
		{
			$row = mysql_fetch_object($result);
			$res=$row->dis_val2;
		}else
		{
			$res=0;
		}

	}else
	{
		$res=0;
	}

}else
{
	$res=0;
}

	//$res=$res<10&&($user_id>0&&$user_id<21)?10:$res;
	return $res;
}
function get_discount_val2()
{
	global $dostavka_defcur,$cur,${$cur};


	if(isset($_SESSION["arr"]) && is_array($_SESSION["arr"]) && count($_SESSION["arr"])>0&&$_SESSION["arr"]!="")
	{
		if(is_array($_SESSION["arr"]) && count($_SESSION["arr"]))
		foreach ($_SESSION["arr"] as $keys=>$values)
		{
			$query = "
SELECT * FROM `shop_commodity` 
WHERE `commodity_ID`='{$keys}';
";
			$result = mysql_query($query);
			if (mysql_num_rows($result) > 0) 
			{
				$row = mysql_fetch_object($result);	
				$c_price=$row->commodity_price;
			
				$c_price+=$dostavka_defcur==0?($c_price/100)*$prices["nadbavka"]:0;
				$c_price=$dostavka_defcur==1?$c_price*${$cur}:$c_price;
				$c_price*=$values;
				$count_price+=$c_price;
			}
		}

$count_price=round($count_price);
	
		$query="
SELECT * FROM `shop_discount`
WHERE `dis_val1`<'{$count_price}'
ORDER BY `dis_val1` DESC
;
";
		$result=mysql_query($query);
		if (mysql_num_rows($result) > 0) 
		{
			$row = mysql_fetch_object($result);
			$res=$row->dis_val2;
		}else
		{
			$res=0;
		}

	}else
	{
		$res=0;
	}
	

	return $res;
}
function get_discount_val3()
{
	if(is_numeric($_SESSION["user_id"]))
	{
		$sql="SELECT * FROM `users` 
		WHERE `user_id`='{$_SESSION["user_id"]}'";
		$row=mysql_fetch_assoc(mysql_query($sql));
		if($row)
		{
			$ret=$row["user_discount"];
		}
	}else
	{
		$ret=0;
	}
	return $ret;
}


function get_recomendates_commodities($com_ids_line)
{
	global $glb,$theme_name;
	
	$arr_data = explode(',',$com_ids_line);
	if(is_array($arr_data) && count($arr_data)>0)
	foreach($arr_data as $key=>$value)
	{
		$com_id=trim($value);
		$lines.=" OR `cod`='{$com_id}'";
		
	}
	
	$sql = "SELECT
	`commodity_ID`, `cod`, `commodity_old_price`, `commodity_price`, `cur_id`, `commodity_bigphoto`, `commodity_order`,
	`commodity_order`,`commodity_new`,`commodity_hit`,`commodity_action`
	FROM `shop_commodity`
	WHERE `commodity_visible`='1' AND (1=0 {$lines}) {$add1}";
	$result_com = mysql_query($sql);
	if(mysql_num_rows($result_com)>0)
	{
		while($row=mysql_fetch_assoc($result_com))
		{
			$ident_array[$row['commodity_ID']] = $row['commodity_order'];
			$com_cod[$row['commodity_ID']]=$row['cod'];
			$com_first_price[$row['commodity_ID']]=get_true_price($row['commodity_old_price'],$row['cur_id']);
			$com_price[$row['commodity_ID']]=get_true_price($row['commodity_price'],$row['cur_id']);
			$com_bphoto[$row['commodity_ID']]=$row['commodity_bigphoto'];
			$commodity_new[$row['commodity_ID']]=$row["commodity_new"];
			$commodity_hit[$row['commodity_ID']]=$row["commodity_hit"];
			$commodity_action[$row['commodity_ID']]=$row["commodity_action"];
			$commodity_discount[$row['commodity_ID']]=$row["commodity_new"];
			$sql_com_desc_end.=" OR `com_id`='{$row['commodity_ID']}' ";
			$arr_data2[]=$row['commodity_ID'];
		}
	}
	

			
	
	$sql_com_desc = "SELECT `com_id`, `alias`, `com_name`, `com_desc` FROM `shop_commodity_description` WHERE 1=0 {$sql_com_desc_end}";
	$result_com_desc = mysql_query($sql_com_desc);
	if(mysql_num_rows($result_com_desc)>0){
		while($row=mysql_fetch_assoc($result_com_desc)){
			$com_alias[$row['com_id']]=$row['alias'];
			$com_name[$row['com_id']]=$row['com_name'];
			$com_desc[$row['com_id']]=$row['com_desc'];
		}
	}
		

	if(is_array($arr_data2) && count($arr_data2)>0)
	foreach($arr_data2 as $key=>$value)
	{ 
		$c_id=trim($value);
		if(is_numeric($c_id))
		{
			//на этом этапе мы реализируем вывод товаров только нужной нам страницы
			$com_url=$com_alias[$c_id]!=""?"/pr{$c_id}-".$com_alias[$c_id]."/":"/pr{$c_id}/";
			$com_src=($com_bphoto[$c_id]!=0)?"/{$c_id}stitle/{$com_alias[$c_id]}.jpg":"/templates/{$theme_name}/img/nophoto.jpg";
					
					
			$glb["templates"]->set_tpl('{$rec_com_src}',$com_src);
			$glb["templates"]->set_tpl('{$rec_com_src2}',$com_imgs[$c_id],$com_src.";");			
			$glb["templates"]->set_tpl('{$rec_c_name}',$com_name[$c_id]);
			$glb["templates"]->set_tpl('{$rec_com_cod}',$com_cod[$c_id]);
			$glb["templates"]->set_tpl('{$rec_c_shorttext}',$com_desc[$c_id]);
			$glb["templates"]->set_tpl('{$rec_com_old_price}',$com_first_price[$c_id]!=$com_price[$c_id]?$com_first_price[$c_id]:"");
			$glb["templates"]->set_tpl('{$rec_com_price}',$com_price[$c_id]);
			$glb["templates"]->set_tpl('{$rec_c_shorttext}',$com_desc[$c_id]);
			$glb["templates"]->set_tpl('{$rec_com_url}',$com_url);
			$glb["templates"]->set_tpl('{$rec_com_new}',$com_first_price[$c_id]!=$com_price[$c_id]&&$com_first_price[$c_id]>0?"<div class='cl_com_discount'>-".round(($com_first_price[$c_id]-$com_price[$c_id])/($com_first_price[$c_id]/100))."%</div>":"");
			$glb["templates"]->set_tpl('{$rec_com_discount}',$commodity_new[$c_id]==1?"<div class='cl_com_new'>Новинка</div>":"");
			$commodity_all_lines.=$glb["templates"]->get_tpl("shop.commodity.full.recomandate");
		}
	}
	$ret=$commodity_all_lines!=""?"<span class='cl_recomendate'>В комплект к покупке:</span>".$commodity_all_lines:"";
	return $ret;
}

function get_hit_carusel()
{
	global $glb,$theme_name;
	
		$sql = "SELECT
	`commodity_ID`, `cod`, `commodity_old_price`, `commodity_price`, `cur_id`, `commodity_bigphoto`, `commodity_order`,
	`commodity_order`,`commodity_new`,`commodity_hit`,`commodity_action`
	FROM `shop_commodity`
	WHERE `commodity_visible`='1' AND `commodity_hit`='1'
	ORDER BY RAND()
	";
	$result_com = mysql_query($sql);
	if(mysql_num_rows($result_com)>0)
	{
		while($row=mysql_fetch_assoc($result_com))
		{
			$ident_array[$row['commodity_ID']] = $row['commodity_order'];
			$com_cod[$row['commodity_ID']]=$row['cod'];
			$com_first_price[$row['commodity_ID']]=get_true_price($row['commodity_old_price'],$row['cur_id']);
			$com_price[$row['commodity_ID']]=get_true_price($row['commodity_price'],$row['cur_id']);
			$com_bphoto[$row['commodity_ID']]=$row['commodity_bigphoto'];
			$commodity_new[$row['commodity_ID']]=$row["commodity_new"];
			$commodity_hit[$row['commodity_ID']]=$row["commodity_hit"];
			$commodity_action[$row['commodity_ID']]=$row["commodity_action"];
			$commodity_discount[$row['commodity_ID']]=$row["commodity_new"];
			$sql_com_desc_end.=" OR `com_id`='{$row['commodity_ID']}' ";
			$arr_data2[]=$row['commodity_ID'];
		}
	}
	

			
	
	$sql_com_desc = "SELECT `com_id`, `alias`, `com_name`, `com_desc` FROM `shop_commodity_description` WHERE 1=0 {$sql_com_desc_end}";
	$result_com_desc = mysql_query($sql_com_desc);
	if(mysql_num_rows($result_com_desc)>0){
		while($row=mysql_fetch_assoc($result_com_desc)){
			$com_alias[$row['com_id']]=$row['alias'];
			$com_name[$row['com_id']]=$row['com_name'];
			$com_desc[$row['com_id']]=$row['com_desc'];
		}
	}
		

	if(is_array($arr_data2) && count($arr_data2)>0)
	foreach($arr_data2 as $key=>$value)
	{ 
		$c_id=trim($value);
		if(is_numeric($c_id))
		{
			//на этом этапе мы реализируем вывод товаров только нужной нам страницы
			$com_url=$com_alias[$c_id]!=""?"/pr{$c_id}-".$com_alias[$c_id]."/":"/pr{$c_id}/";
			$com_src=($com_bphoto[$c_id]!=0)?"/{$c_id}stitle/{$com_alias[$c_id]}.jpg":"/templates/{$theme_name}/img/nophoto.jpg";
					
					
			$glb["templates"]->set_tpl('{$com_src}',$com_src);
			$glb["templates"]->set_tpl('{$com_src2}',$com_imgs[$c_id],$com_src.";");
					
			$glb["templates"]->set_tpl('{$c_name}',$com_name[$c_id]);
			$glb["templates"]->set_tpl('{$com_cod}',$com_cod[$c_id]);
			$glb["templates"]->set_tpl('{$c_shorttext}',$com_desc[$c_id]);
			$glb["templates"]->set_tpl('{$com_old_price}',$com_first_price[$c_id]!=$com_price[$c_id]?$com_first_price[$c_id]:"");
			$glb["templates"]->set_tpl('{$com_price}',$com_price[$c_id]);
			$glb["templates"]->set_tpl('{$c_shorttext}',$com_desc[$c_id]);
			$glb["templates"]->set_tpl('{$com_url}',$com_url);
			$glb["templates"]->set_tpl('{$com_new}',$com_first_price[$c_id]!=$com_price[$c_id]&&$com_first_price[$c_id]>0?"<div class='cl_com_discount'>-".round(($com_first_price[$c_id]-$com_price[$c_id])/($com_first_price[$c_id]/100))."%</div>":"");
			$glb["templates"]->set_tpl('{$com_discount}',$commodity_new[$c_id]==1?"<div class='cl_com_new'>Новинка</div>":"");
			$commodity_all_lines.=$glb["templates"]->get_tpl('shop.commodity.short');
			
			$commodity_all_lines2.="<img src='{$com_src}' onclick=\"location.href='{$com_url}';\" />";
		}
	}
	$ret=$commodity_all_lines;
	
	return $ret;
}


function get_last_view()
{
	global $glb,$theme_name;
	
	
	$last_view=$_SESSION["last_view"];

	if(is_array($last_view) && count($last_view)>1)
	{
		foreach($last_view as $key=>$value)
		{
			$str.=" OR `commodity_ID`='{$value}' ";
		}
	}else
	{
		return "";
	} 
		$sql = "SELECT
	`commodity_ID`, `cod`, `commodity_old_price`, `commodity_price`, `cur_id`, `commodity_bigphoto`, `commodity_order`,
	`commodity_order`,`commodity_new`,`commodity_hit`,`commodity_action`
	FROM `shop_commodity`
	WHERE `commodity_visible`='1' AND (1=0 {$str})
	ORDER BY RAND()
	";
	$result_com = mysql_query($sql);
	if(mysql_num_rows($result_com)>0)
	{
		while($row=mysql_fetch_assoc($result_com))
		{
			$ident_array[$row['commodity_ID']] = $row['commodity_order'];
			$com_cod[$row['commodity_ID']]=$row['cod'];
			$com_first_price[$row['commodity_ID']]=get_true_price($row['commodity_old_price'],$row['cur_id']);
			$com_price[$row['commodity_ID']]=get_true_price($row['commodity_price'],$row['cur_id']);
			$com_bphoto[$row['commodity_ID']]=$row['commodity_bigphoto'];
			$commodity_new[$row['commodity_ID']]=$row["commodity_new"];
			$commodity_hit[$row['commodity_ID']]=$row["commodity_hit"];
			
			$commodity_action[$row['commodity_ID']]=$row["commodity_action"];
			$commodity_discount[$row['commodity_ID']]=$row["commodity_new"];
			$sql_com_desc_end.=" OR `com_id`='{$row['commodity_ID']}' ";
			$arr_data2[]=$row['commodity_ID'];
		}
	}
	

			
	
	$sql_com_desc = "SELECT `com_id`, `alias`, `com_name`, `com_desc` FROM `shop_commodity_description` WHERE 1=0 {$sql_com_desc_end}";
	$result_com_desc = mysql_query($sql_com_desc);
	if(mysql_num_rows($result_com_desc)>0){
		while($row=mysql_fetch_assoc($result_com_desc)){
			$com_alias[$row['com_id']]=$row['alias'];
			$com_name[$row['com_id']]=$row['com_name'];
			$com_desc[$row['com_id']]=$row['com_desc'];
		}
	}
		

	if(is_array($arr_data2) && count($arr_data2)>0)
	foreach($arr_data2 as $key=>$value)
	{ 
		$c_id=trim($value);
		if(is_numeric($c_id))
		{
			//на этом этапе мы реализируем вывод товаров только нужной нам страницы
			$com_url=$com_alias[$c_id]!=""?"/pr{$c_id}-".$com_alias[$c_id]."/":"/pr{$c_id}/";
			$com_src=($com_bphoto[$c_id]!=0)?"/{$c_id}stitle/{$com_alias[$c_id]}.jpg":"/templates/{$theme_name}/img/nophoto.jpg";
					
					
			$glb["templates"]->set_tpl('{$com_src}',$com_src);
			$glb["templates"]->set_tpl('{$com_src2}',$com_imgs[$c_id],$com_src.";");
					
			$glb["templates"]->set_tpl('{$c_name}',$com_name[$c_id]);
			$glb["templates"]->set_tpl('{$com_cod}',$com_cod[$c_id]);
			$glb["templates"]->set_tpl('{$c_shorttext}',$com_desc[$c_id]);
			$glb["templates"]->set_tpl('{$com_old_price}',$com_first_price[$c_id]!=$com_price[$c_id]?$com_first_price[$c_id]:"");
			$glb["templates"]->set_tpl('{$com_price}',$com_price[$c_id]);
			$glb["templates"]->set_tpl('{$c_shorttext}',$com_desc[$c_id]);
			$glb["templates"]->set_tpl('{$com_url}',$com_url);
			$glb["templates"]->set_tpl('{$com_new}',$com_first_price[$c_id]!=$com_price[$c_id]&&$com_first_price[$c_id]>0?"<div class='cl_com_discount'>-".round(($com_first_price[$c_id]-$com_price[$c_id])/($com_first_price[$c_id]/100))."%</div>":"");
			$glb["templates"]->set_tpl('{$com_discount}',$commodity_new[$c_id]==1?"<div class='cl_com_new'>Новинка</div>":"");
			$commodity_all_lines.=$glb["templates"]->get_tpl('shop.commodity.short');
			
			$commodity_all_lines2.="<img src='{$com_src}' onclick=\"location.href='{$com_url}';\" />";
		}
	}
	$ret="<h1>Товары, которые вы смотрели</h1><div class='for_last_look clearfix'>{$commodity_all_lines}</div>";
	
	return $ret;
}

function get_personal_cab()
{
	global $glb,$offer_status,$cur_show;
	$glb["teg_robots"]=true;
	$glb["super_title"].="Личный кабинет";
	$glb["super_description"].="Личный кабинет";
	$glb["super_keywords"].="Личный кабинет";
	$glb["super_content"].="Личный кабинет";
	if(!is_numeric($_SESSION["user_id"])) return false;

	$sql="
	SELECT * FROM `shop_payments_methods` 
	ORDER BY `order`;";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		$opl[$row["id"]]=$row['name'];
	}

	$sql="
	SELECT * FROM `shop_delivery` 
	ORDER BY `order`;";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		$del[$row["id"]]=$row['name'];
	}
	
	$sql="SELECT * FROM `users` 
	WHERE `user_id`='{$_SESSION["user_id"]}'";
	$row=mysql_fetch_assoc(mysql_query($sql));
	if($row)
	{
		$glb["templates"]->set_tpl('{$user_city}',$row["user_city"]);
		$glb["templates"]->set_tpl('{$user_realname}',$row["user_realname"]);
		$glb["templates"]->set_tpl('{$user_tel}',$row["user_tel"]);
		$glb["templates"]->set_tpl('{$user_email}',$row["user_email"]);
		$glb["templates"]->set_tpl('{$user_adr}',$row["user_adr"]);
	}

	$sql="
	SELECT * FROM `shop_orders` 
	WHERE `user_id`='{$_SESSION["user_id"]}'
	ORDER BY `date` DESC;";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		foreach($row as $key=>$value)
		$glb["templates"]->set_tpl('{$'.$key.'}',$value);
		$glb["templates"]->set_tpl('{$del}',$del[$row["delivery"]]);
		$glb["templates"]->set_tpl('{$opl}',$opl[$row["payment"]]);
		$glb["templates"]->set_tpl('{$delivery_price}',get_true_price($row["delivery_price"],$row["cur_id"]));
		$glb["templates"]->set_tpl('{$status}',$offer_status[$row["status"]]);
		$glb["templates"]->set_tpl('{$status_class}',$row["status"]);
		$glb["templates"]->set_tpl('{$cancel_button}',$row["status"]==1?"<img src='/templates/{$glb["theme_name"]}/img/cancel.png' id='id_cancel' rel='{$row["id"]}'>":"");
		$sql2="
		SELECT *, `shop_orders_coms`.`cur_id` AS `cur_id2` FROM `shop_orders_coms`
		LEFT JOIN `shop_commodity` ON `shop_commodity`.`commodity_ID`=`shop_orders_coms`.`com_id`
		WHERE `offer_id`='{$row["id"]}';";
		$res2=mysql_query($sql2);
		$lines="";
		$addlines="";
		$full_prices=0;
		while($row2=mysql_fetch_assoc($res2))
		{
			$glb["templates"]->set_tpl('{$count}',$row2["count"]);
			$glb["templates"]->set_tpl('{$com_name}',$row2["com_name"]);
			$glb["templates"]->set_tpl('{$com_cod}',$row2["cod"]);
			$glb["templates"]->set_tpl('{$price}',$row2["price"]);
			$glb["templates"]->set_tpl('{$com_img}',$row2["commodity_bigphoto"]==1?"/{$row2["commodity_ID"]}stitle/{$row2["alias"]}.jpg":"/templates/{$glb["theme_name"]}/img/nophoto.jpg");
			$glb["templates"]->set_tpl('{$alias}',$row2["alias"]!=""?"/pr{$row2["com_id"]}_{$row2["alias"]}/":"/pr{$row2["com_id"]}/");
			$glb["templates"]->set_tpl('{$fullprice}',$row2["count"]*$row2["cur_id2"]);
			$lines.=$glb["templates"]->get_tpl('shop.cabinet.com.line');
			$full_prices+=$row2["count"]*$row2["price"];
		}
		$lines.=$row["delivery"]>1?$glb["templates"]->get_tpl('shop.cabinet.delivery.line'):"";
		
		$discount_price=round($full_prices/100*$row["discount"]);
		$addlines.=$row["discount"]>0?"<div class='note'>Скидка:</div><h3 class='order-title'>{$row["discount"]}% (-{$discount_price} {$cur_show})</h3>":"";
		$commission_price=round(($full_prices-$discount_price)/100*$row["commission"]);
		$addlines.=$row["commission"]>0?"<div class='note'>Коммиссия:</div><h3 class='order-title'>{$row["commission"]}% (+{$commission_price} {$cur_show})</h3>":"";		
		$glb["templates"]->set_tpl('{$lines}',$lines);
		$glb["templates"]->set_tpl('{$addlines}',$addlines);
		$glb["templates"]->set_tpl('{$offer_full_price}',$row["delivery_price"]+$full_prices+$commission_price-$discount_price);
		$orders_lines.=$glb["templates"]->get_tpl('shop.cabinet.order.line');
	}	
	$glb["templates"]->set_tpl('{$orders_lines}',$orders_lines);
	return	$glb["templates"]->get_tpl('shop.cabinet');	
}
?>