<?php

?>

<html>
<head>
	<title>bookreader demo</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes">

	<link rel="stylesheet" href="../BookReader-source/BookReader/BookReader.css"/>

	<!-- Include Embed css -->
	<link rel="stylesheet" href="../BookReader-source/BookReader/BookReaderEmbed.css"/>

	<script src="../BookReader-source/BookReader/jquery-1.10.1.js"></script>
	<script src="../BookReader-source/BookReader/jquery-ui-1.12.0.min.js"></script>
	<script src="../BookReader-source/BookReader/jquery.browser.min.js"></script>
	<script src="../BookReader-source/BookReader/dragscrollable-br.js"></script>
	<script src="../BookReader-source/BookReader/jquery.colorbox-min.js"></script>
	<script src="../BookReader-source/BookReader/jquery.bt.min.js"></script>

	<script src="../BookReader-source/BookReader/BookReader.js"></script>

	<!-- Plugins -->
	<script src="../BookReader-source/BookReader/plugins/plugin.iframe.js"></script>

	<style>
		html, body, #BookReader { width: 100%; height:100%; margin:0; padding: 0; }
	</style>
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

</body>
</html>

<script>
    //
    // This file shows the minimum you need to provide to BookReader to display a book
    //
    // Copyright(c)2008-2009 Internet Archive. Software license AGPL version 3.

    // Create the BookReader object
    var options = {
        data: [
        <?php

        $private_key="";
        $user="";
        $url = 'http://128.100.124.214/leslie/resourcespace/';

        $query="user=" . $user . "&function=get_page_count&param1=6558";
        $sign=hash("",$private_key . $query);
        $num_pages = file_get_contents($url . "api/?" . $query . "&sign=" . $sign);
        $page_count = str_replace('"', '', $num_pages);

        $output = "";
        $w = 800;
        $h = 1200;

        for ($i = 1; $i < $page_count + 1; $i++){
            $query="user=" . $user . "&function=get_resource_path&param1=6558&param2=&param3=scr&param4=&param5=&param6=" . $i;
            $sign=hash("sha256",$private_key . $query);
            $uri = file_get_contents($url . "api/?" . $query . "&sign=" . $sign);

            $output .= "[{width:" . $w . ", height:" . $h .", uri:" . $uri . "}],";
        }
        echo $output;

        ?>
        ],

        // Book title and the URL used for the book title link
        bookTitle: 'BookReader Embedded',
        bookUrl: 'https://archive.org/details/BookReader',
        bookUrlText: 'Back to Archive.org',
        bookUrlTitle: 'Back to Archive.org',

        // Override the path used to find UI images
        imagesBaseURL: '../BookReader-source/BookReader/images/',
        // Note previously the UI param was used for mobile, but it's going to be responsive
        // embed === iframe

        ui: 'embed', // embed, full (responsive)

        el: '#BookReader',

        //searchInsideUrl: "../exec_testApi.php",

    };

    var br = new BookReader(options);

    // Let's go!
    br.init();

</script>

<?php
    
?>