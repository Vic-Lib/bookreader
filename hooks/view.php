<?php

/*
  This hook replaces the file preview link with a initialization request 
  to a BookReader page.
 */
function HookBookreaderViewReplacepreviewlink()
    {
    global $ref;
	?>

    <form id="resourceId" action="../plugins/bookreader/include/bookreader_init.php" method="get">
        <input type="hidden" name="ref"      value= "<?php echo $ref;?>">
    </form>

    <div id="previewWrapper">
        <a id="previewLink" onclick="displayBR()" style="cursor:pointer;">
        <script type="text/javascript">
            function displayBR()
                {
                jQuery(document).ready(function(){
                    jQuery("#resourceId").submit();
                });
                }
        </script>

	<?php
	return true;
    }


/*
  This hook allows for a preview link to be present even when not signed in.
  However the BookReader viewer only works for viewing but not searching.
 */
function HookBookreaderViewAftersearchimg()
    {      
    global $ref, $lang, $resource, $use_watermark;

    $file_path = get_resource_path($ref, true, 'pre', false, $resource['preview_extension'], true, 1, false);
    $url_path  = get_resource_path($ref, false, 'pre', false, $resource['preview_extension'], true, 1, false);

    if(!file_exists($file_path))
        {
        return false;
        }
    ?>
    <script type="text/javascript">
        var prev_img = document.getElementById("previewimage");
        if (prev_img == null){
            jQuery("#previewLink").append('<img id="previewimage" class="Picture" src="<?php echo $url_path; ?>" alt="<?php echo $lang['fullscreenpreview']; ?>" GALLERYIMG="no"/>');
        }
    </script>
    <?php
    }

?>