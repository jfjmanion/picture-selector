<?php 
require_once('./config.php');



$images = scandir($dir);

$meta_info = array();
$url = "http://" . $host . $pictureDir;

echo '<form action="">';

//crop them
foreach ($images as $picture) {
	$extension = strtolower(pathinfo($picture, PATHINFO_EXTENSION));
	$allowedExtensions = array("jpg", "gif", "png", "bmp", "jpeg");

	if (in_array($extension, $allowedExtensions)){
		echo "<div>";
		echo "<a href='". $url . $picture . "'><img src='".$picture."'></a>";
		echo "<input type='checkbox' name='picture' value='" . $picture . "'>";
		echo "</div>";
	}
}

echo '</form>';