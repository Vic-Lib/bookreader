<?php

function HookBookreaderViewRenderbeforerecorddownload()
	{
	global $resource, $title_field;

    $url = getPreviewURL($resource);
    
    if(false === $url)
        {
        return;
        }

    $title             = get_data_by_field($resource['ref'], $title_field);
    $page_count        = get_page_count($resource);

    for($i = 1; $i < $page_count + 1; $i++)
        {
        // Handle first preview (regardless if it is multi page or just one preview)
        if(1 == $i)
            {
            setLink('#previewimagelink', $url, $title);
            setLink('#previewlink', $url, $title, 'bookreader');

            continue;
            }

        // This applies only to resources that have multi page previews
        $preview_url = getPreviewURL($resource, -1, $i);

        if(false === $preview_url)
            {
            continue;
            }
            ?>
        <a href="<?php echo $preview_url; ?>"
           rel="testfile"
           title="<?php echo htmlspecialchars(i18n_get_translated($title)); ?>"
           onmouseup="">
       </a>
        <?php
        }
    }

?>