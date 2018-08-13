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

    if (!isset($_POST['field_rid']))
        {
        return true;
        }
    $rid = $_POST['field_rid'];

    // This info is used for the metadata (about) section.
    if  ((!isset($_POST['field_title'])) || (!isset($_POST['field_access'])) || (!isset($_POST['field_contrib'])))
        {
        return true;
        }
    $title       = $_POST['field_title'];
    $access      = $_POST['field_access'];
    $contributor = $_POST['field_contrib'];

    // Set the private API key for the user (from the user account page) and the user we're accessing the system as.
    $private_key = "";
    $user        = "";
    $url         = "";

    // Run a query to get the number of pages in the pdf
    $query      = "user=" . $user . "&function=get_page_count&param1=" . $rid;
    $sign       = hash("sha256", $private_key . $query);
    $num_pages  = file_get_contents($url . "api/?" . $query . "&sign=" . $sign);
    $page_count = str_replace('"', '', $num_pages);
    
    // Run a query to get the path to the pdf
    $query       = "user=" . $user . "&function=get_resource_path&param1=" . $rid . "&param2=&param3=&param4=&param5=pdf&param6=";
    $sign        = hash("sha256", $private_key . $query);
    $path_to_pdf = file_get_contents($url . "api/?" . $query . "&sign=" . $sign);
    $path_to_pdf = str_replace('\\', '', $path_to_pdf);


    $image_sizes = array();
    $url_list    = array();
    // Run queries to get the individual pdf pages
    for ($i = 1; $i < $page_count + 1; $i++)
        {
        $query  = "user=" . $user . "&function=get_resource_path&param1=" . $rid . "&param2=&param3=scr&param4=&param5=&param6=" . $i;
        $sign   = hash("sha256",$private_key . $query);
        $uri    = file_get_contents($url . "api/?" . $query . "&sign=" . $sign);
        $uri    = str_replace('"', '', $uri);
        $uri    = str_replace('\\', '', $uri);

        list($width, $height) = getimagesize($uri);
        array_push($image_sizes, array($width, $height));
        array_push($url_list, $uri);
        }

    // Pass variables along to javascript
    // Arrays must be encoded first
    $image_sizes = json_encode($image_sizes);
    $url_list    = json_encode($url_list);

    echo '<script type="text/javascript">';
    echo "var rid = "         . $rid         . ";\n";
    echo "var title = "       . $title       . ";\n";
    echo "var access = "      . $access      . ";\n";
    echo "var contributor = " . $contributor . ";\n";
    echo "var num_pages = "   . $page_count  . ";\n";
    echo "var page_sizes = "  . $image_sizes . ";\n";
    echo "var path_to_pdf = " . $path_to_pdf . ";\n";
    echo "var url_list = "    . $url_list    . ";\n";
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