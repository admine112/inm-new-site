#!/bin/bash
# Update content/main.php to use wrapper function

cat > /tmp/content_main_fixed.php << 'EOF'
<?
global $templates;
if (($_SESSION['status']=="admin")&&(isset($_GET["admin"])))
{
	$url_admin["articles"]="modules/content/admin/all_articles.php";

	$url_admin["all_articles_cats"]="modules/content/admin/all_categories.php";
	$url_admin["edit_articles_cats"]="modules/content/admin/edit_category.php";
	$url_admin["add_articles_category"]="modules/content/admin/add_category.php";
	$url_admin["delete_articles_category"]="modules/content/admin/delete_category.php";

	$url_admin["all_articles"]="modules/content/admin/all_articles.php";

	//тестовая страница дерева категорий
	$url_admin["all_articles_2"]="modules/content/admin/all_articles_2.php";

	$url_admin["main_page_edit"]="modules/content/admin/main_page_edit.php";
	
	//тестовая страница всех типов страниц
	$url_admin["all_content_types"]="modules/content/admin/all_content_types.php";
	$url_admin["edit_types"]="modules/content/admin/edit_types.php";
	$url_admin["delete_fields"]="modules/content/admin/delete_fields.php";
	$url_admin["add_articles"]="modules/content/admin/add_articles.php";
	$url_admin["article_edit"]="modules/content/admin/article_edit.php";
	$url_admin["delete_articles"]="modules/content/admin/delete_articles.php";

	$url_admin["article_photos"]="modules/content/admin/article_photos.php";
	$url_admin["edit_article_photo"]="modules/content/admin/article_photo_edit.php";
	$url_admin["add_article_photo"]="modules/content/admin/article_photo_add.php";
	$url_admin["delete_article_photo"]="modules/content/admin/article_photo_delete.php";


	$url_admin_menu["delete_articles"]="content";
	$url_admin_menu["articles"]="content";
	$url_admin_menu["all_articles"]="content";
	$url_admin_menu["all_content_types"]="content";
	$url_admin_menu["add_articles"]="content";
	$url_admin_menu["article_edit"]="content";
	$url_admin_menu["article_photos"]="content";
	$url_admin_menu["edit_article_photo"]="content";
	$url_admin_menu["add_article_photo"]="content";
	$url_admin_menu["delete_article_photo"]="content";
	
	require_once("modules/content/admin/functions.php");
	//$cat_tree=get_tree_cat_and_articles();
		$templates->set_tpl('{$content_tree}',$url_admin_menu[$_GET["admin"]]=="content"?$cat_tree:"");

	$glb["templates"]->set_tpl('<!--cl_shop-->',".cl_shop{display:none!important;}");
	$lines=get_art_admin_block_all();
	$admin_left_menu.="
	
	<li><div class='cl_menu_div'><div class='icon-32-content cl_left_bt'></div><a href='/?admin=all_articles'>Страницы</a></div>

	<ul>
		<li><a href='/?admin=all_articles'><img src='/templates/{$theme_name}/img/list-remove.png' class='ico'>&nbsp;Все страницы</a></li>
		{$lines}
		<li><a href='/?admin=all_content_types'><img src='/templates/{$theme_name}/img/list-remove.png' class='ico'>&nbsp;Типы страниц</a></li>
		<li><a href='/?admin=main_page_edit'><img src='/templates/{$theme_name}/img/add.png' class='ico'>&nbsp;Главная страница</a> </li>
		
		
		
		
	</ul>
	</li>
";


	

}elseif(!isset($_GET["admin"]))
{
	$url_page["content"]="show_article_full";
	$url_page["contentcategory"]="show_article_com";
	$url_page["feed"]="show_article_com2";
	$url_page["sitemap"]="get_sitemap";
	$url_page["p"]="show_article_by_url";  // CHANGED: use wrapper function
	require_once("modules/content/site/functions.php");
	
	

	$glb["templates"]->set_tpl('{$page_tree}',get_page_tree());
	$glb["templates"]->set_tpl('{$page_tree2}',get_page_tree2(19));
	
}

?>
EOF

sudo cp /tmp/content_main_fixed.php www/www/modules/content/main.php
sudo chmod 644 www/www/modules/content/main.php
echo "✅ Updated content/main.php to use show_article_by_url() wrapper"
