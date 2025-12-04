<?
/**
* OwerCMS
* Функции пользовательской части модуля управления контентом
* @package OwerCMS
* @author Ower
* @version 4.7
* @since engine v.4.7
* @link http://www.ower.com.ua
* @copyright (c) 2010+ by Ower
*/

function show_article_full($articleID,$page_id=1)
{
	global $glb,$glb_pages;

	$sql="SELECT * FROM `content_articles`
	WHERE `articleID`='{$articleID}' AND `lng_id`='{$glb["sys_lng"]}' AND `visible`='1';";
	$row=mysql_fetch_assoc(mysql_query($sql));
	if($row)
	{
		$type_id=$row["type_id"];
		$main_alias=$row["alias"];
		$glb["templates"]->set_tpl('{$center_name}',$row["h1"]!=""?$row["h1"]:$row["name"]);
		$glb["templates"]->set_tpl('{$date}',date("d.m.Y",strtotime($row["add_date"])));
		if($page_id==1)
		{
			$glb["super_title"]=$row["title"]!=""?$row["title"]:$row["name"];
			$glb["super_description"]=$row["description"]!=""?$row["description"]:reg_text($row["name"].". ".$row["text"]);
			$glb["super_keywords"]=$row["keywords"]!=""?$row["keywords"]:$row["name"];
			$glb["super_content"]=$row["content"]!=""?$row["content"]:$row["content"];
			$glb["templates"]->set_tpl('{$image}',$row["image"]==1?"<img src='/{$articleID}simg/{$row["alias"]}.jpg' class='cl_page_img_full' />":"");
			
			$glb["templates"]->set_tpl('{$center_text}',$row["text"]);
		}else
		{
			$page_name=$page_id==0?" все страницы":" страница {$page_id}";
			$glb["super_title"]=$row["name"].$page_name;
			$glb["super_description"]=reg_text($page_name." - ".$row["text"]);
			$glb["super_keywords"]=$row["keywords"]!=""?$row["keywords"].$page_name:$row["name"].$page_name;
			$glb["super_content"]=$row["content"]!=""?$row["content"].$page_name:$row["content"].$page_name;
			$glb["templates"]->set_tpl('{$image}',"");
			$glb["templates"]->set_tpl('{$center_text}',"");
		}
		show_articles_fields($articleID);
		$glb["templates"]->set_tpl('{$breadcrumb}',get_page_breadcrumb($glb["page_parrents"],$articleID,$glb_pages["pages_name"],$glb_pages["pages_alias"],0));
		$sql="
		SELECT * FROM `content_images`
		WHERE `img_artid`='{$articleID}';";
		$res=mysql_query($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$imgs.="<div class='cl_article_div'><a class='cl_article_img' href='/images/articles/{$articleID}/{$row["img_id"]}.jpg' class='pirobox_gall' rel='prettyPhoto[gallery2]'><img src='/images/articles/{$articleID}/s_{$row["img_id"]}.jpg' alt='{$row["name"]}' ></a></div>";
		}
		
		$sql="SELECT * FROM `content_types` 
		WHERE `type_id`='{$type_id}'";
		$row=mysql_fetch_assoc(mysql_query($sql));
		if($row)
		{
			$art_on_page=$row["count"];
		}
		$glb["templates"]->set_tpl('{$imgs}',$imgs!=""?"<div class='gallery_id'>{$imgs}</div>":"");
		
		
		
		$sql="SELECT count(*) as `count` FROM `content_articles` 
		WHERE `parent`='{$articleID}' AND `lng_id`='{$glb["sys_lng"]}' AND `visible`='1'";
		$row=mysql_fetch_assoc(mysql_query($sql));
		if($row)
		{
			
			$page_count=ceil($row["count"]/$art_on_page);
			$page_num=$page_id*$art_on_page-$art_on_page;
			$sel_page="LIMIT {$page_num}, {$art_on_page}";
			$sel_page=$page_id==0?"":$sel_page;
			if($page_count>1)
			for($i=1;$i<=$page_count;$i++)
			{
				$pages_url=$i==1?"/{$main_alias}":"/p{$articleID}-{$i}";
				$pages_links.="<li><a href='{$pages_url}'>{$i}</a></li>";
			}
			$pager=$pages_links!=""?"<nav class='pagination'><ul class='cl_pager'>{$pages_links}</ul></nav>":"";
			$sql="
			SELECT * FROM `content_articles` 
			WHERE `parent`='{$articleID}' AND `lng_id`='{$glb["sys_lng"]}' AND `visible`='1'
			ORDER BY `order` DESC
			{$sel_page};";
			$res=mysql_query($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$short_type_id=$row["type_id"];
				show_articles_fields($row["articleID"]);
				$glb["templates"]->set_tpl('{$short_name}',$row["name"]);
				$glb["templates"]->set_tpl('{$short_text}',reg_text($row["text"],500)." <a href='".($row["alias"]!=""?"/{$row["alias"]}":"/p{$row["articleID"]}")."' class='read_more_btn'>Подробнее...</a>");
				$glb["templates"]->set_tpl('{$short_text_full}',$row["text"]);
				$glb["templates"]->set_tpl('{$short_date}',date("d.m.Y",strtotime($row["add_date"])));
				$glb["templates"]->set_tpl('{$short_url}',$row["alias"]!=""?"/{$row["alias"]}":"/p{$row["articleID"]}");
				$glb["templates"]->set_tpl('{$short_image}',$row["image"]==1?"<img src='/{$row["articleID"]}simg/{$row["alias"]}.jpg' class='cl_page_img_short' />":"");
				$lines.=$glb["templates"]->get_tpl("content.short_page.{$short_type_id}");
			}
			
		}
		$ret=$articleID==25?get_callback_page():"";
		$glb["templates"]->set_tpl('<!--{$111}-->',$ret);
		
		$glb["templates"]->set_tpl('{$lines}',$lines);
		$glb["templates"]->set_tpl('{$pager}',$pager);
		return $glb["templates"]->get_tpl("content.full_page.{$type_id}");
	}else
	{
		return "";
	}
}

function get_cat_block_by_id($id)
{
	global $glb;
	$sql="
	SELECT * FROM `content_articles` 
	WHERE `parent`='{$id}' AND `lng_id`='{$glb["sys_lng"]}' AND `visible`='1'
	ORDER BY `order` DESC
	;";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		show_articles_fields($row["articleID"]);
		$short_type_id=$row["type_id"];
		$glb["templates"]->set_tpl('{$short_name}',$row["name"]);
		$glb["templates"]->set_tpl('{$short_text}',reg_text($row["text"],300));
		$glb["templates"]->set_tpl('{$short_url}',$row["alias"]!=""?"/{$row["alias"]}":"/p{$row["articleID"]}");
		$glb["templates"]->set_tpl('{$short_image}',$row["image"]==1?"<img src='/{$row["articleID"]}simg/{$row["alias"]}.jpg' class='cl_page_img_short' />":"");
		$lines.=$glb["templates"]->get_tpl("content.sideblock.line");
	}
	$glb["templates"]->set_tpl('{$lines}',$lines);
	return $glb["templates"]->get_tpl("content.sideblock");;
}

function get_cat_block_by_id2($id)
{
	global $glb;
	$sql="
	SELECT * FROM `content_articles` 
	WHERE `articleID`='{$id}' AND `lng_id`='{$glb["sys_lng"]}' AND `visible`='1'
	;";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		show_articles_fields($row["articleID"]);
		$short_type_id=$row["type_id"];
		$glb["templates"]->set_tpl('{$short_name}',$row["name"]);
		$glb["templates"]->set_tpl('{$short_text}',reg_text($row["text"],500)." <a href='".($row["alias"]!=""?"/{$row["alias"]}":"/p{$row["articleID"]}")."' class='read_more_btn'>Подробнее...</a>");
		$glb["templates"]->set_tpl('{$short_url}',$row["alias"]!=""?"/{$row["alias"]}":"/p{$row["articleID"]}");
		$glb["templates"]->set_tpl('{$short_image}',$row["image"]==1?"<img src='/{$row["articleID"]}simg/{$row["alias"]}.jpg' class='cl_page_img_short' />":"");
		$lines.=$glb["templates"]->get_tpl("content.sideblock.line2");
	}
	return $lines;
}

function get_cat_block_by_id3($id)
{
	global $glb;
	$sql="
	SELECT * FROM `content_articles` 
	WHERE `parent`='{$id}' AND `lng_id`='{$glb["sys_lng"]}' AND `visible`='1'
	ORDER BY `order` DESC
	LIMIT 0,3
	;";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		show_articles_fields($row["articleID"]);
		$short_type_id=$row["type_id"];
		$glb["templates"]->set_tpl('{$short_name}',$row["name"]);
		$glb["templates"]->set_tpl('{$short_text}',reg_text($row["text"],500)." <a href='".($row["alias"]!=""?"/{$row["alias"]}":"/p{$row["articleID"]}")."' class='read_more_btn'>Подробнее...</a>");
		$glb["templates"]->set_tpl('{$short_url}',$row["alias"]!=""?"/{$row["alias"]}":"/p{$row["articleID"]}");
		$glb["templates"]->set_tpl('{$short_image}',$row["image"]==1?"<img src='/{$row["articleID"]}simg/{$row["alias"]}.jpg' class='cl_page_img_short' />":"");
		$lines.=$glb["templates"]->get_tpl("content.sideblock.line3");
	}
	return $lines;
}


function get_cat_block_all()
{
	global $glb;
	$sql="
	SELECT * FROM `content_articles` 
	WHERE `block`='1' AND `lng_id`='{$glb["sys_lng"]}' AND `visible`='1'
	ORDER BY `order` DESC
	;";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		$glb["templates"]->set_tpl('{$line}',get_cat_block_by_id($row["articleID"]));
		$glb["templates"]->set_tpl('{$block_name}',$row["name"]);
		$glb["templates"]->set_tpl('{$block_url}',$row["alias"]!=""?"/{$row["alias"]}":"/p{$row["articleID"]}");
		$lines.=$glb["templates"]->get_tpl("content.sideblock");
		
	}
	return $lines;
}
function get_page_breadcrumb($array1,$cat_id,$cat_chl_name,$cat_chl_alias,$bstep,$com_url="",$com_name="")
{
	global $glb;
	$bstep++;
	$url=$cat_chl_alias[$cat_id]!=""?"/{$cat_chl_alias[$cat_id]}/":"/p{$cat_id}/";
	if($cat_id==0)
	{
		$url="/shop/";
		$cat_chl_name[$cat_id]="";
	}
	$ret=$cat_chl_name[$cat_id]!=""?"<li typeof='v:Breadcrumb'> >> <a href='{$url}' title='{$cat_chl_name["$cat_id"]}' rel='v:url' property='v:title'>{$cat_chl_name["$cat_id"]}</a></li>":"";
	$ret2=$cat_id>0?get_page_breadcrumb($array1,$array1[$cat_id],$cat_chl_name,$cat_chl_alias,$bstep):"";
	$glb["filter_string"].=" OR `fitr_catid`='{$cat_id}' ";
	$last=$com_name!=""?"<li typeof='v:Breadcrumb'> >> <a href='{$com_url}' title='{$com_name}' rel='v:url' property='v:title'>{$com_name}</a></li>":"";
	return $bstep==1?"<ul class='cl_breadcrumb'><li typeof='v:Breadcrumb'><a href='/' title='{$glb["main_page_title"]}' rel='v:url' property='v:title'>Главная</a></li>{$ret2}{$last}</ul>":"{$ret2}{$ret}";
}
function get_pages_tree_for_menu($page_id,$ii,$glb_pages)
{
	$pages_parent=$glb_pages["pages_parent"];
	$pages_alias=$glb_pages["pages_alias"];
	if(count($glb_pages))
	foreach($glb_pages as $keys=>$values)
	{
		$$keys=$values;
	}
	$ii++;
	if(count($pages_parent))
	foreach($pages_parent as $keys=>$values)
	{
		
		if($values==$page_id)
		{
			$inner=get_pages_tree_for_menu($keys,$ii,$glb_pages);
			$class=$inner!=""?"class='deeper parent'":"";
			$class2=$inner!=""?"":"";
			$class3=$inner!=""?"":"";
			$url=$pages_alias[$keys]!=""?$pages_alias[$keys]:"p{$keys}";
			$url=$url=="/"?"/":"/{$url}";
			$all_lines.="
			
				<a href='{$url}'  title='{$pages_name[$keys]}' >
					{$pages_name[$keys]}
				</a>
				
			


			
			";	
		}
	}
	return $page_id==0||$all_lines==""?$all_lines:"<ul>{$all_lines}</ul>";
}
function get_page_tree()
{
	global $glb,$glb_pages;
	$sql="
	SELECT `articleID`,`parent`,`name`,`add_date`,`order`,`visible`,`alias`,`menu`
	FROM `content_articles` 
	WHERE `content_articles`.`lng_id`='{$glb["sys_lng"]}'
	ORDER BY `order` DESC;";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		if($row["menu"]==1)
		{
			
			$pages_parent[$row["articleID"]]=$row["parent"];
			$pages_add_date[$row["articleID"]]=$row["add_date"];
			$pages_order[$row["articleID"]]=$row["order"];
			$pages_visible[$row["articleID"]]=$row["visible"];
		}
		$pages_name[$row["articleID"]]=$row["name"];
		$parents[$row["articleID"]]=$row["parent"];
		$pages_alias[$row["articleID"]]=$row["alias"];
	}
	
	$glb["page_parrents"]=$parents;
	$glb_pages["pages_name"]=$pages_name;	
	$glb_pages["pages_parent"]=$pages_parent;
	$glb_pages["pages_add_date"]=$pages_add_date;	
	$glb_pages["pages_order"]=$pages_order;
	$glb_pages["pages_visible"]=$pages_visible;
	$glb_pages["pages_alias"]=$pages_alias;
	return get_pages_tree_for_menu(0,0,$glb_pages);
	
	
	
	
}

function get_page_tree2($page_id)
{
	global $glb,$glb_pages;
	$sql="
	SELECT `articleID`,`parent`,`name`,`add_date`,`order`,`visible`,`alias`,`menu`
	FROM `content_articles` 
	WHERE `content_articles`.`lng_id`='{$glb["sys_lng"]}'
	ORDER BY `order` DESC;";
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res))
	{
		if($row["menu"]==1)
		{
			
			$pages_parent[$row["articleID"]]=$row["parent"];
			$pages_add_date[$row["articleID"]]=$row["add_date"];
			$pages_order[$row["articleID"]]=$row["order"];
			$pages_visible[$row["articleID"]]=$row["visible"];
		}
		$pages_name[$row["articleID"]]=$row["name"];
		$parents[$row["articleID"]]=$row["parent"];
		$pages_alias[$row["articleID"]]=$row["alias"];
	}
	
	$glb["page_parrents"]=$parents;
	$glb_pages["pages_name"]=$pages_name;	
	$glb_pages["pages_parent"]=$pages_parent;
	$glb_pages["pages_add_date"]=$pages_add_date;	
	$glb_pages["pages_order"]=$pages_order;
	$glb_pages["pages_visible"]=$pages_visible;
	$glb_pages["pages_alias"]=$pages_alias;
	return get_pages_tree_for_menu2($page_id,0,$glb_pages);
	
	
	
	
}

function get_pages_tree_for_menu2($page_id,$ii,$glb_pages)
{
	$pages_parent=$glb_pages["pages_parent"];
	$pages_alias=$glb_pages["pages_alias"];
	if(count($glb_pages))
	foreach($glb_pages as $keys=>$values)
	{
		$$keys=$values;
	}
	$ii++;
	if(count($pages_parent))
	foreach($pages_parent as $keys=>$values)
	{
		
		if($values==$page_id)
		{
			$inner=get_pages_tree_for_menu($keys,$ii,$glb_pages);
			$class=$inner!=""?"":"";
			$class2=$inner!=""?"":"";
			$class3=$inner!=""?"":"";
			$url=$pages_alias[$keys]!=""?$pages_alias[$keys]:"p{$keys}";
			$url=$url=="/"?"/":"/{$url}";
			$all_lines.="
			<option value='{$pages_name[$keys]}'>{$pages_name[$keys]}</option>{$inner}
			";	
		}
	}
	return $page_id==0||$all_lines==""?$all_lines:"<ul>{$all_lines}</ul>";
}

//=====================================
function show_articles_fields($articleID){
	global $templates, $headtitle, $theme_name, $sys_lng;
	
	$sql = "
	SELECT 	`f`.`field_name`, `f`.`field_kind`, `f`.`field_typeid`, 
	`v`.`val_id`, `v`.`article_id`, `v`.`field_id`, `v`.`value1`, `v`.`value2`, `v`.`value3`, `v`.`value4` 
	FROM `content_fields_values` `v` 
	INNER JOIN `content_types_fields` `f` 
	ON `f`.`fileld_id`=`v`.`field_id` 
	WHERE `v`.`article_id`='{$articleID}';
	";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) > 0){
		while($row = mysql_fetch_assoc($result)){			
			$templates->set_tpl('{$field'.$row['field_id'].'}', $row["value".$row['field_kind']]);
			$templates->set_tpl('{$field_name'.$row['field_id'].'}', $row['field_name']);
			$ret = $row['field_typeid'];
		}
	}else{
		return '';
	}
	return $ret;
}

function func_url_search_content()
{
	global $url, $urlend, $center, $theme_name, $domen_ID, $sys_lng,$headtitle;

	$query="
SELECT * FROM `content_articles`
WHERE `alias`='{$url}' AND `visible`='1'
";
	
		$result=mysql_query($query);
		if (mysql_num_rows($result) > 0) 
		{
			$row = mysql_fetch_object($result);
			$articleID=$row->articleID;
			$lng_id=$row->lng_id;
			$_SESSION['sel_lang']=$lng_id;
			$sys_lng=$lng_id;
			$sel_lang=$lng_id;
			$glb["sys_lng"]=$sys_lng;
			$center=show_article_full($articleID);
			$ret=1;
		}else
		{
			$ret=0;
		}
	
	return $ret;
}
?>