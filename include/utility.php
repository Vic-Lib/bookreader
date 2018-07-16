<?php
	function getUrlList(){
		global $baseurl, $resource;

		$urls = array();
		$page_count = get_page_count($resource);

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
	
?>