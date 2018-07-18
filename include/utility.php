<?php
	function getAllUrls(){
		global $baseurl, $resource;

		$urls = array();
		$page_count = getPageCount();

		for ($i = 1; $i < $page_count + 1; $i++){
		  	$preview_url = getPreviewURL($resource, -1, $i);
		    array_push($urls, $preview_url);
		}

		return $urls;
	}

	function getPageCount(){
		global $resource;

		$page_count = get_page_count($resource);
		return $page_count;
	}

	function getPageDimensions(){
		global $resource;

		$image = getPreviewURL($resource);
		list($width, $height) = getimagesize($image);
		return array($width, $height);
	}

	function buildOptions(){

        $urlList = getAllUrls();
        $page_count = getPageCount();
        list($w, $h) = getPageDimensions();

        // Create the pageinfo for the first page.
        $pageInfo = '[{width:' . $w . ', height:' . $h . ', uri:"' . $urlList[0] . '"},],';

        for ($i = 1; $i < $page_count; $i++){
        	if ($i % 2 == 1){
        		$pageInfo .= '[{width:' . $w . ', height:' . $h . ', uri:"' . $urlList[$i] . '"},';
        	}
        	else{
        		$pageInfo .= '{width:' . $w . ', height:' . $h . ', uri:"' . $urlList[$i] . '"},],';
        	}
        }

        if ($page_count % 2 == 0){
        	$pageInfo .= "],";
        }
        // Wrap the pageinfo with square braces to "transform" it into a list.
        $data = "data: [" . $pageInfo . "], ";

        $bookTitle = 'bookTitle: "BookReader Embedded",';
        $bookUrl = 'bookUrl: "https://archive.org/details/BookReader",';
        $bookUrlText = 'bookUrlText: "Back to Archive.org",';
        $bookUrlTitle = 'bookUrlTitle: "Back to Archive.org", ';

        $imagesBaseUrl = 'imagesBaseURL: "../plugins/bookreader/BookReader-source/BookReader/images/",';
        $ui = 'ui: "embed",';
        $el = 'el: "#BookReader",';

        return "{" . $data . $bookTitle . $bookUrl . $bookUrlText . $bookUrlTitle . $imagesBaseUrl . $ui . $el . "}";
    }
	
?>