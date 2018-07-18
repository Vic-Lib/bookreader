<?php

include dirname(__FILE__) . "/../include/utility.php";

function HookBookreaderViewRenderbeforerecorddownload(){
  global $baseurl;
  //echo buildOptions();
    ?>
      <script>
      var overlay_exists = document.getElementById("br-overlay");
      if (!overlay_exists){
        jQuery("body").append('<div id="br-overlay" style="background-color:rgb(0,0,0); opacity:0.9; width:100%; height:100%; position:fixed; display:none; "></div>');
        jQuery("body").append('<div id="br-content" style="display:none;"></div>');

        //jQuery("body").append('<div id="br-content" style="width:100%; height:100%; position:fixed; display:none;"><iframe id="bookreader-wrapper" src="../plugins/bookreader/include/bookreader_init.php" style="width:80%; height:80%; top:50px; position:relative;"></iframe></div>');
      }
      
      </script>
    <?php
  }

function HookBookreaderViewReplacepreviewlink() {
  global $baseurl, $resource;
	?>

  <div id="previewWrapper">
    <a id="previewLink" onclick="displayBR()">
      <script>
        function displayBR(){
          ModalClose();
          jQuery("#br-content").append('<div id="BookReader" style="width:80%; margin:auto;">Internet Archive BookReader</div>');
          jQuery("#br-overlay").css("display", "block");
          jQuery("#br-content").css("display", "block"); 
          jQuery("#br-overlay").attr("onclick", "closeBox()");
          
          var options = <?php echo buildOptions();?>;
          var br = new BookReader(options);
          br.init();
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