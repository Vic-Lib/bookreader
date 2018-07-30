<?php

include dirname(__FILE__) . "/../include/utility.php";

function HookBookreaderViewRenderbeforerecorddownload(){
  global $baseurl;
    ?>
      <script>
      var overlay_exists = document.getElementById("br-overlay");
      if (!overlay_exists){
        jQuery("body").append('<div id="br-overlay" style="background-color:rgb(0,0,0); opacity:0.9; width:100%; height:100%; position:fixed; display:none; "></div>');

        jQuery("body").append('<iframe id="br-content" style="width:80%; height:80%; top:50px; margin:auto; position:relative; display:none;" src="../plugins/bookreader/BookReader-source/BookReaderDemo/demo-search.php"></iframe>');

        //jQuery("body").append('<div id="br-content" style="width:100%; height:100%; position:fixed; display:none;"><iframe id="bookreader-wrapper" src="../plugins/bookreader/include/bookreader_init.php" style="width:80%; height:80%; top:50px; position:relative;"></iframe></div>');
      }
      
      </script>
    <?php
  }

function HookBookreaderViewReplacepreviewlink() {
  global $baseurl, $resource, $ref;
	?>

  <div id="previewWrapper">
    <a id="previewLink" onclick="displayBR()">
      <script>
        function displayBR(){
          ModalClose();
          jQuery("#br-overlay").css("display", "block");
          jQuery("#br-content").css("display", "block"); 
          jQuery("#br-overlay").attr("onclick", "closeBox()");
        }

        function closeBox(){
            jQuery("#BookReader").remove();
            jQuery("#br-overlay").css("display", "none");
            jQuery("#br-content").css("display", "none");
        }

      </script>

  </div>
  
	<?php
	return true;
}


?>