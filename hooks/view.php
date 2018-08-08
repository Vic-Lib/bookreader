<?php

function HookBookreaderViewRenderbeforerecorddownload()
    {
    global $baseurl, $ref, $title_field, $resource;
    
    $title = get_data_by_field($resource['ref'], $title_field);
    ?>

    <form id="resourceId" action="../plugins/bookreader/include/bookreader_init.php" target="br-content" method="post">
        <input type="hidden" name="rid" value="<?php echo $ref;?>">
        <input type="hidden" name="title" value="'<?php echo $title;?>'">
    </form>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("#resourceId").submit();
        });

        var overlay_exists = document.getElementById("br-overlay");
        if (!overlay_exists)
            {
            jQuery("body").append('<div id="br-overlay" onclick="closeBR()" style="background-color:rgb(0,0,0); opacity:0.9; width:100%; height:100%; position:fixed; display:none;"></div>');
            jQuery("body").append('<iframe id="br-content" name="br-content" style="width:100%; height:100%; position:fixed; display:none;" src="../plugins/bookreader/include/bookreader_init.php"></iframe>');
            jQuery("body").append('<span id="close-frame" onclick="closeBR()" style="font-size:1.1em; color:rgb(70,150,224); top:0.8em; left:0.8em; position:fixed; display:none;">✖ close</span>');
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
                jQuery("#close-frame").css("display", "block");
                }

            function closeBR()
                {
                jQuery("#BookReader").remove();
                jQuery("#close-frame").css("display", "none");
                jQuery("#br-overlay").css("display", "none");
                jQuery("#br-content").css("display", "none");
                
                }
        </script>

	<?php
	return true;
    }

?>