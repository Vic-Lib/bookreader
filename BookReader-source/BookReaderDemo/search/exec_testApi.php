<?php

//echo getcwd() . "\n";

/**
 * Run the jar file that performs a pdf search on a given term.
 * Capture and modify the results to fit new dimensions.
 * Echo out the resulting json file.
 */

$callback = $_GET['callback'];
$item_id = $_GET['item_id'];
$path = $_GET['path'];
$doc = $_GET['doc'];
$q = $_GET['q'];

if (empty($path)){
	$path = ".";
}

// If the pdf document isn't supplied by the link, use test3.pdf.
// (This could be removed later on)
if (empty($doc)){

	$doc = "test3";
}

$item_id = escapeshellarg($item_id);
$path = escapeshellarg($path);
$doc = escapeshellarg($doc);
$q = escapeshellarg(str_replace('"', '', $q));
$style = "abbyy";

//$cmd = "java -jar testApi.jar '" . $item_id . "' '" . $doc . "' '" . $path . "' '" . $q . "' '" . $callback . "' '" . $style . "'";

$cmd = "java -jar testApi.jar " . $item_id . " " . $doc . " " . $path . " " . $q . " '" . $callback . "' '" . $style . "' ";
		
//echo $cmd . "\n";

$output = shell_exec($cmd);

header('Content-Type: application/json');

$lines = explode("\n", $output);
$header_lines = array_slice($lines, 0, 5);
$text_lines = array_slice($lines, 5);

$cb = substr($header_lines[0], strpos($header_lines[0], ":") + 1);
$ia = substr($header_lines[1], strpos($header_lines[1], ":") + 1);
$query = substr($header_lines[2], strpos($header_lines[2], ":") + 1);
$numPages = substr($header_lines[3], strpos($header_lines[3], ":") + 1);

echo $cb . "( {" 
	. "\n\t\"ia\": \"" . $ia .  "\","
    . "\n\t\"q\": \"\\\"" . $query . "\\\"\","
    . "\n\t\"page_count\": " . $numPages . ","
    . "\n\t\"leaf0_missing\": true,"
    . "\n\t\"matches\": [\n";

/** 
 * Read the rest of output line by line and echo out the completed json file.
 * Modify the dimensions in $output to work on the actual image size of the jpgs.
 */
foreach ($text_lines as $line) {
	$label = substr($line, 0, strpos($line, ":"));
	$content = substr($line, strpos($line, ":") + 1);

	if ($label == "text"){
		$text = $content;
	}
	elseif ($label == "page_num"){
		$pagenum = $content;
		$pagenum_padded = str_pad($pagenum, 3, "0", STR_PAD_LEFT);
	}
	elseif ($label == "page_size"){
		$dimensions = explode(",", $content);
		$pgwidth = $dimensions[0];
		$pgheight = $dimensions[1];

		// Note that this is relative to the current file system.
		$filename = "../../../jpgs/pg-" . $pagenum_padded . ".jpg";
		list($width, $height) = getimagesize($filename);

		$ratio_w = $width / $pgwidth;
		$ratio_h = $height / $pgheight;
	}
	elseif ($label == "text_bounds"){
		$bounds = explode(",", $content);
		$bBound = $bounds[0] * $ratio_h;
		$tBound = $bounds[1] * $ratio_h;
		$rBound = $bounds[2] * $ratio_w;
		$lBound = $bounds[3] * $ratio_w;

	}
	elseif ($label == "term_bounds"){
		$coords = explode(",", $content);
		$r = $coords[0] * $ratio_w;
		$b = $coords[1] * $ratio_h;
		$t = $coords[2] * $ratio_h;
		$l = $coords[3] * $ratio_w;
	}
	else{
		echo ("{" . "\n\t\"text\": \"" . $text . "\", " 
        			. "\n\t\"par\": [{" 
        			. "\n\t\t\"page\": " . $pagenum . ", \"page_width\": " . $width . ", \"page_height\": " . $height . ","
        			. "\n\t\t\"b\": " . $bBound . ", \"t\": " . $tBound . ", \"r\": " . $rBound . ", \"l\": " . $lBound . ","
        			. "\n\t\t\"boxes\": ["
        			. "\n\t\t\t{\"page\": " . $pagenum . ", \"r\": " . $r . ", \"b\": " . $b . ", \"t\": " . $t . ", \"l\": " . $l . "}"
        			. "\n\t\t] \n\t}] \n}," . "\n");
	}
}

echo "] \n} )";

?>