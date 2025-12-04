function func_url_search_content()
{
	global $url, $urlend, $center, $theme_name, $domen_ID, $sys_lng,$headtitle,$templates;

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
			
			// FIX: Встановити center_name з fallback
			$h1_value = !empty($row->h1) ? $row->h1 : $row->name;
			$templates->set_tpl('{$center_name}', $h1_value);
			
			$center=show_article_full($articleID);
			$ret=1;
		}else
		{
			$ret=0;
		}
	
	return $ret;
}
