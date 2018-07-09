<?php

function HookBookreaderViewRenderbeforerecorddownload()
	{
    ?>
    <script>
      var overlay_exists = document.getElementById("br-overlay");
      if (!overlay_exists){
        jQuery("body").append('<div id="br-overlay" style="background-color:rgba(0,0,0); opacity:0.8; width:100%; height:100%; display:none;"></div>');
      }
    </script>
    <?php
  }

function HookBookreaderViewReplacepreviewlink() {
  global $baseurl;
	?>

  <div id="previewWrapper">
    <a id="previewLink" onclick="showDemo()">
    <script src="../plugins/bookreader/BookReader-source/test.js" type="text/javascript"></script>
  </div>
  
	<?php
	return true;
}


?>