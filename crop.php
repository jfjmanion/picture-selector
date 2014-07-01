<?php
ini_set ( "max_execution_time" , 500 );
ini_set ( "memory_limit" , "2000M" );



$dir = "./images/";
$write_dir = './cropped/';
$images = scandir($dir);
$ratio = 0.5;
$thumbnail = null; // set to the square value of the thumbnail

//crop them
foreach ($images as $picture) {
	if (strpos($picture, ".JPG")){

		$image = imagecreatefromjpeg($dir . $picture);
		$filename = $write_dir . $picture;
		if (file_exists($filename) || !is_writable($write_dir)){
			echo $filename . "<br>";
			continue;
		}

		$width = imagesx($image);
		$height = imagesy($image);

		if ($thumbail){
			$thumb_width = $thumbnail;
			$thumb_height = $thumbnail;
		} else {
			$thumb_width = $ratio * $width;
			$thumb_height = $ratio * $height;
		}

		$original_aspect = $width / $height;
		$thumb_aspect = $thumb_width / $thumb_height;

		if ( $original_aspect >= $thumb_aspect )
		{
		   // If image is wider than thumbnail (in aspect ratio sense)
		   $new_height = $thumb_height;
		   $new_width = $width / ($height / $thumb_height);
		}
		else
		{
		   // If the thumbnail is wider than the image
		   $new_width = $thumb_width;
		   $new_height = $height / ($width / $thumb_width);
		}

		$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

		// Resize and crop
		imagecopyresampled($thumb,
						   $image,
						   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
						   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
						   0, 0,
						   $new_width, $new_height,
						   $width, $height);
		imagejpeg($thumb, $filename, 80);
		echo $filename . "<br>";

	}
}