<?php

function HookBookreaderViewRenderbeforerecorddownload()
    {
    global $baseurl, $ref;
    ?>
    <form id="resourceId" action="../plugins/bookreader/include/bookreader_init.php" target="br-content" method="post">
        <input type="hidden" name="rid" value="<?php echo $ref;?>">
    </form>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("#resourceId").submit();
        });

        var overlay_exists = document.getElementById("br-overlay");
        if (!overlay_exists)
            {
            jQuery("body").append('<div id="br-overlay" onclick="closeBR()" style="background-color:rgb(0,0,0); opacity:0.9; width:100%; height:100%; position:fixed; display:none;"></div>');
            jQuery("body").append('<iframe id="br-content" name="br-content" style="width:80%; height:80%; top:50px; margin:auto; position:relative; display:none;" src="../plugins/bookreader/include/bookreader_init.php"></iframe>');
            }
    </script>

    <?php
    }

function HookBookreaderViewReplacepreviewlink()
    {
	?>
    <div id="previewWrapper">
        <a id="previewLink" onclick="displayBR()">
        <script type="text/javascript">
            function displayBR()
                {
                ModalClose();
                jQuery("#br-overlay").css("display", "block");
                jQuery("#br-content").css("display", "block");
                }

            function closeBR()
                {
                jQuery("#BookReader").remove();
                jQuery("#br-overlay").css("display", "none");
                jQuery("#br-content").css("display", "none");
                }
        </script>

	<?php
	return true;
    }

?>