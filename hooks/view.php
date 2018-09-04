<?php

function HookBookreaderViewRenderbeforerecorddownload()
    {
    global $baseurl, $ref, $lang, $title_field, $resource, $use_watermark, $baseurl_short;

    // Grab the path to the resourcespace folder
    $rs_dir = substr($baseurl, strpos($baseurl, "//") + 2);
    
    /* 
     Grab the metadata info for the record
     included fields: title, access, contributed by
     */
    $title       = get_data_by_field($resource['ref'], $title_field);
    $access      = $lang["access" . $resource["access"]];
    $udata       = get_user($resource["created_by"]);
    $contributor = $udata["fullname"];
    $metadata    = array($title, $access, $contributor);

    /*
     Grab the .pdf path to the record in filestore. 
     Grab the .jpg paths of all the record's pages in filestore.
     */
    $path_to_pdf = get_resource_path($ref, true, '', false, $resource['file_extension'], -1, 1, false, '', -1, false);
    $url_list    = array();
    $page_count  = get_page_count($resource);

    for ($i = 1; $i < $page_count + 1; $i++)
        {
        $url = get_resource_path($ref, false, 'scr', false,  $resource['preview_extension'], -1, $i, false, '', -1, true);
        array_push($url_list, $url);
        }
    ?>

    <form id="resourceId" action="../plugins/bookreader/include/bookreader_init.php" target="br-content" method="post">
        <input type="hidden" name="field_rid"      value= "<?php echo $ref;?>">
        <input type="hidden" name="field_dir"      value= "<?php echo $rs_dir;?>">
        <input type="hidden" name="field_pdf"      value= "<?php echo $path_to_pdf;?>">
        <input type="hidden" name="field_metadata" value="'<?php print base64_encode(serialize($metadata));?>'">
        <input type="hidden" name="field_urls"     value="'<?php print base64_encode(serialize($url_list));?>'">
    </form>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("#resourceId").submit();
        });

        var overlay_exists = document.getElementById("br-overlay");
        if (!overlay_exists)
            {
            jQuery("body").append('<div id="br-overlay" onclick="closeBR()" style="background-color:rgb(0,0,0); opacity:0.9; width:100%; height:100%; position:fixed; display:none;"></div>');
            jQuery("body").append('<iframe id="br-content" name="br-content" style="width:100%; height:100%; position:fixed; z-index:3; display:none;" src="../plugins/bookreader/include/bookreader_init.php"></iframe>');
            }
    </script>
    <?php
    }

function HookBookreaderViewReplacepreviewlink()
    {
	?>
    <div id="previewWrapper">
        <a id="previewLink" onclick="displayBR()" style="cursor:pointer;">
        <script type="text/javascript">
            function displayBR()
                {
                ModalClose();
                jQuery("body").append('<span id="close-frame" onclick="closeBR()" style="font-size:1.1em; color:rgb(70,150,225); top:0.8em; left:0.8em; position:fixed; z-index:3; cursor:pointer;">✖ close</span>');
                jQuery("#br-overlay").css("display", "block");
                jQuery("#br-content").css("display", "block");
                jQuery("#br-content").focus();
                }

            function closeBR()
                {
                jQuery("#BookReader").remove();
                jQuery("#close-frame").remove();
                jQuery("#br-overlay").css("display", "none");
                jQuery("#br-content").css("display", "none");
                }
        </script>      
	<?php
	return true;
    }

function HookBookreaderViewAftersearchimg()
    {
    /*
      This hook allows for a preview link to be present even when not signed in.
      However the BookReader viewer only works for viewing but not searching.
     */
      
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