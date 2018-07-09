<?php

function HookBookreaderAllAdditionalheaderjs() {

	global $baseurl_short;

	//echo '<script src="' . $baseurl_short . 'plugins/bookreader/BookReader-source/BookReader/jquery-1.10.1.js" type="text/javascript" ></script>';
	
	//echo '<script src="' . $baseurl_short . 'plugins/bookreader/BookReader-source/BookReader/jquery-ui-1.12.0.min.js" type="text/javascript" ></script>';
	//echo '<script src="' . $baseurl_short . 'plugins/bookreader/BookReader-source/BookReader/jquery.browser.min.js" type="text/javascript" ></script>';
	echo '<script src="' . $baseurl_short . 'plugins/bookreader/BookReader-source/BookReader/dragscrollable-br.js" type="text/javascript" ></script>';
	echo '<script src="' . $baseurl_short . 'plugins/bookreader/BookReader-source/BookReader/jquery.colorbox-min.js" type="text/javascript" ></script>';
	//echo '<script src="' . $baseurl_short . 'plugins/bookreader/BookReader-source/BookReader/jquery.bt.min.js" type="text/javascript" ></script>';
	echo '<script src="' . $baseurl_short . 'plugins/bookreader/BookReader-source/BookReader/BookReader.js" type="text/javascript" ></script>';
	echo '<script src="' . $baseurl_short . 'plugins/bookreader/BookReader-source/BookReader/plugins/plugin.url.js" type="text/javascript" ></script>';
	echo '<script src="' . $baseurl_short . 'plugins/bookreader/BookReader-source/BookReader/plugins/plugin.search.js" type="text/javascript" ></script>';

	echo '<link rel="stylesheet" href="' . $baseurl_short . 'plugins/bookreader/BookReader-source/BookReader/BookReader.css" type="text/css" />';
	echo '<link rel="stylesheet" href="' . $baseurl_short . 'plugins/bookreader/BookReader-source/BookReader/BookReaderDemo.css" type="text/css" />';
	
}

?>
