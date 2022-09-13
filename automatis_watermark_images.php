<?php
/*
this script will automatically put watermark on your thousand of images 
if you have a tons of images with large width/height pixels, 
and you needs to change all image files into smaller pixels and put watermarks,
use this apps. you can change/update resize your hundred / thousands / millions image with just one,two,three second.

put your original images in folder images
create folder results

author : Kukuh TW
email : kukuhtw@gmail.com
resize_watermarks-master

*/

$dir    = 'c:\xampp\htdocs\resize_watermarks-master\images'; // <--- this is your directory images
$files1 = scandir($dir);
$files2 = scandir($dir, 1);
$opacity=30; // change opacity here


//$width_template=1200; // width=350 , sure you can change this width template pixel
//$height_template=600; // height=350  , sure you can change this height template pixel


$datajson1 = json_encode($files1) ;
$datadecode = json_decode($datajson1);

$allfiles = implode("~~~",$files1);
$jumlahdata = substr_count($allfiles,"~~~");
 

	
for ($x=0;$x<=$jumlahdata;$x++) {
	echo "<br> Data ke ".$x. " = " .$datadecode[$x];
	$cek_extension = substr($datadecode[$x], -3);
	$cek_extension = strtolower($cek_extension);
    if ($cek_extension=="jpg" || $cek_extension=="peg" || $cek_extension=="png") {
		$fileakandiresize = "images/".$datadecode[$x];
		$filehasilresize = "results_resize/".$datadecode[$x];
		$filehasilwatermarks = "results_watermarks/".$datadecode[$x];
		list($width, $height) = getimagesize($fileakandiresize);



	//off course, you can change this template with your own file png
	//check if template vertical

	 if ($width > $height) {
	 	$fullfilenametemplate = "http://localhost/resize_watermarks-master/template/verifikasi_horizontal.png";
	 }
	 else {
	 	$fullfilenametemplate = "http://localhost/resize_watermarks-master/template/verifikasi_vertical.png";	
	 }		
		$w_step1= $width;
		$h_step1= $height;
		
	    $dst_x=0;
		$dst_y=0;
		$src_x=0;
		$src_y=0;
		$dst_w = $w_step1;
		$dst_h = $h_step1;
		$src_w=$width;
		$src_h=$height;
		// Load   gambar upload
		
		echo "<br> = fileakandiresize = ".$fileakandiresize;
		echo "<br> = filehasilresize = ".$filehasilresize;
		echo "<br> = dst_w = ".$dst_w;
		echo "<br> = dst_h = ".$dst_h;
		echo "<br> = src_w = ".$src_w;
		echo "<br> = src_h = ".$src_h;
		
		$dst_image = imagecreatetruecolor($dst_w, $dst_h);
		
		if ($cek_extension=="jpg" || $cek_extension=="peg" ) {
			$src_image = imagecreatefromjpeg($fileakandiresize);
		}
		else if ($cek_extension=="png") {
			$src_image = imagecreatefrompng($fileakandiresize);	
		}
		
		
		imagecopyresized($dst_image, $src_image,
		$dst_x, $dst_y,
		$src_x, $src_y,
		$dst_w, $dst_h,
		$src_w, $src_h );
		
		
		echo "<br> = dst_image = ".$dst_image;
		echo "<br> = src_image = ".$src_image;
		
		echo "<br> = filehasilresize = ".$filehasilresize;
			
		imagejpeg($dst_image,$filehasilresize);			

	//step 2 , gambar hasil resize digabungkan ke dalam template dimensi 350x350px
	list($widthhasilresize, $heighthasilresize) = getimagesize($filehasilresize);

	     /* tambahan */
		$dst_x=0;
		$dst_y=0;
      $src_x=0;
		$src_y=0;

		$dst_w = $width;
		$dst_h = $height;
        $src_w = $width;
	    $src_h = $height;
		$dst_image = imagecreatetruecolor($dst_w, $dst_h);
		$src_image = imagecreatefromjpeg($filehasilresize);

		imagecopyresized($dst_image, $src_image,$dst_x, $dst_y,
		$src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h );
		// Output
		
		imagejpeg($dst_image,$filehasilwatermarks);
		
		echo "<br> = dst_image = ".$dst_image;
		
		echo "<br> = filehasilwatermarks = ".$filehasilwatermarks;
		echo "<br> = fullfilenametemplate = ".$fullfilenametemplate;
		
		//$image = imagecreatefromjpeg($filehasilresise);
		$image = imagecreatefromjpeg($filehasilwatermarks);
	  	$insert = imagecreatefrompng($fullfilenametemplate);
		
  		$image = image_overlap_f($image, $insert,$opacity);

        $filesoutput = $filehasilwatermarks;
		imagejpeg($image,$filesoutput);
		imageDestroy($image);
    }
	
}

function image_overlap_f($background, $foreground,$opacity){
//echo "<p>background1 = ".$background;
//echo "<p>foreground1 = ".$foreground;

   $dst_x=0;
   $dst_y=0;
   $src_x=0;
   $src_y=0;
   $src_w = imagesx($foreground);
   $src_h = imagesy($foreground);

ImageCopyMerge($background,
               $foreground,
               $dst_x,$dst_y, $src_x, $src_y,
               $src_w,$src_h,$opacity);
			   
 return $background;
}



?>
