<?php

/**
 * Run the jar file that performs a pdf search on a given term.
 * Capture and modify the results to fit new dimensions.
 * Echo out the resulting json file.
 */

$callback = $_GET['callback'];
$item_id  = $_GET['item_id'];
$path     = $_GET['path'];
$doc      = $_GET['doc'];
$q        = $_GET['q'];

if (empty($item_id))
	{
	$item_id = "bookreader test";
	}

if (empty($path))
	{
	$path = ".";
	}
else 
	{
	// The relative path to your resourcespace filestore directory
	$pos           = strpos($path, "filestore");
	$relative_path = "../../" . substr($path, $pos);
	$relative_path = escapeshellarg($relative_path);
	}

$item_id = escapeshellarg($item_id);
$path    = escapeshellarg($path);
$doc     = escapeshellarg($doc);
$q       = escapeshellarg(str_replace('"', '', $q));
$style   = "abbyy";

$cmd    = "java -jar testApiNew.jar " . $item_id . " " . $relative_path . " " . $q . " '" . $callback . "' '" . $style . "' ";
$output = shell_exec($cmd);


header('Content-Type: application/json');

$lines        = explode("\n", $output);
$header_lines = array_slice($lines, 0, 5);
$text_lines   = array_slice($lines, 5);

$cb       = substr($header_lines[0], strpos($header_lines[0], ":") + 1);
$ia       = substr($header_lines[1], strpos($header_lines[1], ":") + 1);
$query    = substr($header_lines[2], strpos($header_lines[2], ":") + 1);
$numPages = substr($header_lines[3], strpos($header_lines[3], ":") + 1);

// Set the private API key for the user (from the user account page) and the user we're accessing the system as.
$private_key = "";
$user        = "";
$url         = "";

/***
 * Start of output from exec_testApi.php
 * The info is passed back to BookReader's search feature.
 **/
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
foreach ($text_lines as $line)
	{
	$label 	 = substr($line, 0, strpos($line, ":"));
	$content = substr($line, strpos($line, ":") + 1);

	if ($label == "text")
		{
		$text = $content;
		}
	elseif ($label == "page_num")
		{
		$pagenum = $content;
		}
	elseif ($label == "page_size")
		{
		$dimensions = explode(",", $content);
		$ratio_w    = 1.0;
		$ratio_h    = 1.0;
		$pgwidth    = $dimensions[0];
		$pgheight   = $dimensions[1];
		$p6         = $pagenum + 1;
		
		$query = "user=" . $user . "&function=get_resource_path&param1=" . trim($item_id, '"\'') . "&param2=&param3=scr&param4=&param5=&param6=" . $p6;
		$sign  = hash("sha256",$private_key . $query);
		$uri   = file_get_contents($url . "api/?" . $query . "&sign=" . $sign);

        if ($uri != "")
        	{
        	$uri = str_replace('"', '', $uri);
        	$uri = str_replace('\\', '', $uri);
        	list($width, $height) = getimagesize($uri);

        	$ratio_w  = $width / $pgwidth;
			$ratio_h  = $height / $pgheight;
			$pgwidth  = $width;
			$pgheight = $height;
    		}
		}
	elseif ($label == "text_bounds")
		{
		$bounds = explode(",", $content);
		$bBound = $bounds[0] * $ratio_h;
		$tBound = $bounds[1] * $ratio_h;
		$rBound = $bounds[2] * $ratio_w;
		$lBound = $bounds[3] * $ratio_w;
		}
	elseif ($label == "term_bounds")
		{
		$coords = explode(",", $content);
		$r = $coords[0] * $ratio_w;
		$b = $coords[1] * $ratio_h;
		$t = $coords[2] * $ratio_h;
		$l = $coords[3] * $ratio_w;
		}
	else
		{
		echo ("{" . "\n\t\"text\": \"" . $text . "\", " 
        			. "\n\t\"par\": [{" 
        			. "\n\t\t\"page\": " . $pagenum . ", \"page_width\": " . $pgwidth . ", \"page_height\": " . $pgheight . ","
        			. "\n\t\t\"b\": " . $bBound . ", \"t\": " . $tBound . ", \"r\": " . $rBound . ", \"l\": " . $lBound . ","
        			. "\n\t\t\"boxes\": ["
        			. "\n\t\t\t{\"page\": " . $pagenum . ", \"r\": " . $r . ", \"b\": " . $b . ", \"t\": " . $t . ", \"l\": " . $l . "}"
        			. "\n\t\t] \n\t}] \n}," . "\n");
		}
	}

echo "] \n} )";

?>