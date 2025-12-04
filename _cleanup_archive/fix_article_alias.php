<?php
require_once("settings/conf.php");
require_once("settings/connect.php");
require_once("settings/functions.php");
bd_session_start(); 

$id = 110;
$new_alias = "хотите-жить-дольше-укрепляйте-т-клеточный-иммунитет"; // Removed !

$query = "UPDATE content_articles SET alias='$new_alias' WHERE articleID=$id";
$res = mysql_query($query);

if ($res) {
    echo "Alias updated successfully for ID $id. New alias: $new_alias";
} else {
    echo "Update failed: " . mysql_error();
}
?>
