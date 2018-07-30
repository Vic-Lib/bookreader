<!DOCTYPE html>
<html>
<head>
    <title>bookreader demo</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- JS dependencies -->
    <script src="../BookReader/jquery-1.10.1.js"></script>
    <script src="../BookReader/jquery-ui-1.12.0.min.js"></script>
    <script src="../BookReader/jquery.browser.min.js"></script>
    <script src="../BookReader/dragscrollable-br.js"></script>
    <script src="../BookReader/jquery.colorbox-min.js"></script>
    <script src="../BookReader/jquery.bt.min.js"></script>


<?php
//image size for ALL pages
$pages = array();

$files = glob('../../jpgs/*.jpg');
foreach($files as $file) {
	$imagesize = getimagesize($file);
	array_push($pages, array('width' => $imagesize[0], 'height' => $imagesize[1]));
}

$pages_json = json_encode($pages);
echo '<script type="text/javascript">';
echo 'var pages_json = ' . $pages_json . ';';
//echo 'alert(pages_json[0].width);';
echo '</script>';
?>

    <!-- BookReader and plugins -->
    <link rel="stylesheet" href="../BookReader/BookReader.css"/>
    <script src="../BookReader/BookReader.js"></script>
    <script type="text/javascript" src="../BookReader/plugins/plugin.url.js"></script>
    <script src="../BookReader/plugins/plugin.search.js"></script>    

    <!-- Custom CSS overrides -->
    <link rel="stylesheet" href="BookReaderDemo.css"/>
</head>
<body>

    <style>
html, body { width: 100%; height: 100%; margin: 0; padding: 0; }
#BookReader { width: 100%; height: 100%; }
    </style>

  <div id="BookReader">
      Internet Archive BookReader Demo<br/>
      <noscript>
      <p>
          The BookReader requires JavaScript to be enabled. Please check that your browser supports JavaScript and that it is enabled in the browser settings.  You can also try one of the <a href="https://archive.org/details/goodytwoshoes00newyiala"> other formats of the book</a>.
      </p>
      </noscript>
  </div>
  <script type="text/javascript" src="BookReaderJSSearch.js"></script>
</body>
</html>
