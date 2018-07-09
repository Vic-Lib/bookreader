function showDemo(){
    ModalClose();

    jQuery(document).ready(function(){
        jQuery("#br-overlay").css("display", "block");
        jQuery("#br-overlay").attr("onclick", "closeBox()");
        jQuery("#br-overlay").append('<iframe class="bookreader-wrapper" src="../plugins/bookreader/BookReader-source/BookReaderDemo/demo-embed-iframe-src.html"></iframe>');
        //../plugins/bookreader/BookReader-source/BookReaderDemo/demo-embed-iframe-src.html
        jQuery(".bookreader-wrapper").css("width", "80%");
        jQuery(".bookreader-wrapper").css("height", "80%");
    });
}

function closeBox(){
    jQuery("#br-overlay").css("display", "none");
    jQuery("#br-overlay").empty();
}
