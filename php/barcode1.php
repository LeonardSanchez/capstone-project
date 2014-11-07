<?php
	// first, we must include the required files to draw the barcode
	require_once("class/BCGFontFile.php");
	require_once("class/BCGColor.php");
	require_once("class/BCGDrawing.php");

	// next we must include the file of our barcode type
	require_once("class/BCGcode93.php");

	// Now, we will generate colors for the barcode
	// the arguments are R, G, and B for color
	$colorFront = new BCGColor(0, 0, 0);
	$colorBack  = new BCGColor(255, 255, 255);

	// Also, we need to load a font for the the label under the barcode if we want one
	$font = new BCGFontFile("./class/font/Arial.ttf", 12);

	// construct the barcode

?>