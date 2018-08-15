<!DOCTYPE html>
<html>
<head>
    <title>bookreader demo</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- JS dependencies -->
    <script src="../BookReader-source/BookReader/jquery-1.10.1.js"></script>
    <script src="../BookReader-source/BookReader/jquery-ui-1.12.0.min.js"></script>
    <script src="../BookReader-source/BookReader/jquery.browser.min.js"></script>
    <script src="../BookReader-source/BookReader/dragscrollable-br.js"></script>
    <script src="../BookReader-source/BookReader/jquery.colorbox-min.js"></script>
    <script src="../BookReader-source/BookReader/jquery.bt.min.js"></script>

    <!-- BookReader and plugins -->
    <link rel="stylesheet" href="../BookReader-source/BookReader/BookReader.css"/>
    <script src="../BookReader-source/BookReader/BookReader.js"></script>
    <script type="text/javascript" src="../BookReader-source/BookReader/plugins/plugin.url.js"></script>
    <script src="../BookReader-source/BookReader/plugins/plugin.search.js"></script>    

    <!-- Custom CSS overrides -->
    <link rel="stylesheet" href="../css/bookreader_css.css"/>

	<style>
		html, body { width: 100%; height:100%; margin:0; padding: 0; }
        #BookReader { width: 100%; height:100%; }
	</style>


    <?php

    if ((!isset($_POST['field_rid'])) || (!isset($_POST['field_pdf'])) || 
        (!isset($_POST['field_metadata'])) || (!isset($_POST['field_urls'])))
        {
        return true;
        }
    $rid         = $_POST['field_rid'];
    $path_to_pdf = $_POST['field_pdf'];
    $metadata    = unserialize(base64_decode($_POST['field_metadata']));
    $url_list    = unserialize(base64_decode($_POST['field_urls']));

    $page_count  = count($url_list);
    $image_sizes = array();

    // Get the dimensions of each of the record's pages.
    for ($i = 0; $i < $page_count; $i++)
        {
        list($width, $height) = getimagesize($url_list[$i]);
        array_push($image_sizes, array($width, $height));
        }

    // Pass variables along to javascript
    // Arrays must be encoded first
    $image_sizes = json_encode($image_sizes);
    $url_list    = json_encode($url_list);

    echo '<script type="text/javascript">';
    echo "var rid = "          . $rid         . ";\n";
    echo "var title = '"       . $metadata[0] . "';\n";
    echo "var access = '"      . $metadata[1] . "';\n";
    echo "var contributor = '" . $metadata[2] . "';\n";
    echo "var num_pages = "    . $page_count  . ";\n";
    echo "var page_sizes = "   . $image_sizes . ";\n";
    echo "var path_to_pdf = '" . $path_to_pdf . "';\n";
    echo "var url_list = "     . $url_list    . ";\n";
    echo "</script>";

    ?>

</head>
<body style="background-color: #939598;">

	<div id="BookReader">
		  Internet Archive BookReader Demo<br/>

	<noscript>
	<p>
		The BookReader requires JavaScript to be enabled. Please check that your browser supports JavaScript and that it is enabled in the browser settings.  You can also try one of the <a href="https://archive.org/details/goodytwoshoes00newyiala"> other formats of the book</a>.
	</p>
	</noscript>
	</div>

    <script src="../script/bookreader_script.js" type="text/javascript"></script>

</body>
</html>