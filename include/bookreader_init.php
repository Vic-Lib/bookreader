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
    include_once "../../../include/general.php";
    include_once "../../../include/db.php";
    include_once "../../../include/resource_functions.php";
    include "../getimagesize_helper.php";

    global $title_field, $baseurl;

    /// Get metadata for BookReader initialization ///

    if (isset($_GET['ref'])) {
        $rid = $_GET['ref'];
        } else {
        return true;
        }

    $resource = get_resource_data($rid);

    $title       = get_data_by_field($resource['ref'], $title_field);
    $access      = $lang["access" . $resource["access"]];
    $udata       = get_user($resource["created_by"]);
    $contributor = $udata["fullname"];
    $metadata    = array($title, $access, $contributor);
    $rs_dir      = substr($baseurl, strpos($baseurl, "//") + 2);
    $path_to_pdf = get_resource_path($rid, true, '', false, $resource['file_extension'], -1, 1, false, '', -1, false);

    $page_count  = get_page_count($resource);
    $url_list    = array(); 
    $image_sizes = array(); 

    // The built-in general-purpose PHP method getimagesize() is very slow. 
    // Under the assumption that the BookReader will only deal with jpeg,
    // we are using getjpegsize() instead to boost up the speed.
    for ($i = 1; $i < $page_count + 1; $i++)
        {
        $url = get_resource_path($rid, false, 'scr', false,  $resource['preview_extension'], -1, $i, false, '', -1, true);
        array_push($url_list, $url);
        // list($width, $height) = getimagesize($url);
        list($width, $height) = getjpegsize($url);
        array_push($image_sizes, array($width, $height));
        }

    $image_sizes = json_encode($image_sizes);
    $url_list    = json_encode($url_list);

    echo '<script type="text/javascript">'    . "\n";
    echo "var rid = "          . $rid         . ";\n";
    echo "var rs_dir = '"      . $rs_dir      . "';\n";
    echo "var title = '"       . $metadata[0] . "';\n";
    echo "var access = '"      . $metadata[1] . "';\n";
    echo "var contributor = '" . $metadata[2] . "';\n";
    echo "var num_pages = "    . $page_count  . ";\n";
    echo "var path_to_pdf = '" . $path_to_pdf . "';\n";
    echo "var page_sizes = "   . $image_sizes . ";\n";
    echo "var url_list = "     . $url_list    . ";\n";
    echo "</script>";


    /// Set url attached to the `close` button ///

    if (isset($_SERVER['HTTP_REFERER'])) {
        $close_url = $_SERVER['HTTP_REFERER'];
        } 
        else {
        $close_url = $baseurl . "/pages/view.php?ref=" . $rid;
        }
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

    <a id="close-frame" href="<?php echo $close_url;?>" style="font-size:1.1em; color:rgb(70,150,225); top:0.8em; left:0.8em; position:fixed; z-index:999; cursor:pointer; text-decoration: none; font-family: WorkSans, Tahoma, Arial, Helvetica, sans-serif;">✖ close</a>    

</body>
</html>
