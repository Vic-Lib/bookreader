//
// This file shows the minimum you need to provide to BookReader to display a book
//
// Copyright(c)2008-2009 Internet Archive. Software license AGPL version 3.

// Create the BookReader object

var options = {
    getNumLeafs: function (){
        return num_pages;
    },
    getPageWidth: function(index) { 
        return page_sizes[index][0];
    },
    getPageHeight: function(index) { 
        return page_sizes[index][1];
    },
    getPageURI: function(index, reduce, rotate) {
        return url_list[index];
    },
    getPageSide: function(index) {
        if (0 == (index & 0x1)) {
            return 'R';
        } else {
            return 'L';
        }
    },
    getSpreadIndices: function(pindex) {
        var spreadIndices = [null, null];
        if ('rl' == this.pageProgression) {
            // Right to Left
            if (this.getPageSide(pindex) == 'R') {
                spreadIndices[1] = pindex;
                spreadIndices[0] = pindex + 1;
            } else {
                // Given index was LHS
                spreadIndices[0] = pindex;
                spreadIndices[1] = pindex - 1;
            }
        } else {
            // Left to right
            if (this.getPageSide(pindex) == 'L') {
                spreadIndices[0] = pindex;
                spreadIndices[1] = pindex + 1;
            } else {
                // Given index was RHS
                spreadIndices[1] = pindex;
                spreadIndices[0] = pindex - 1;
            }
        }
        return spreadIndices;
    },

    getPageNum: function(index) {
        return index+1;
    },

    // Override the path used to find UI images
    imagesBaseURL: '../BookReader-source/BookReader/images/',
    // Note previously the UI param was used for mobile, but it's going to be responsive
    // embed === iframe
    metadata: [
        {label: 'Resource ID', value: rid},
        {label: 'Title', value: title},
        {label: 'Access', value: access},
        {label: 'Contributed By', value: contributor},
    ],
    thumbnail: url_list[0],

    showLogo: false,
    
    bookId: rid,
    bookPath: path_to_pdf,
    ui: 'full', // embed, full (responsive)
    searchInsideUrl: "/leslie/resourcespace/plugins/bookreader/search_inside.php",

};
var br = new BookReader(options);
// Let's go!
br.init();
