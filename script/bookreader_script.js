//
// This file provides the required info to BookReader to display a book
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

    // embed, full (responsive)
    ui: 'full',

    showLogo: false,

    // Override the path used to find UI images
    imagesBaseURL: '../BookReader-source/BookReader/images/',

    // Adjust zoom Levels, (reduce < 1 = zoom in)
    reductionFactors: [
        {reduce: 0.5, autofit: null},
        {reduce: 0.8, autofit: null},
        {reduce: 1,   autofit: null},
        {reduce: 1.3, autofit: null},
        {reduce: 2, autofit: null},
        {reduce: 4, autofit: null},
        {reduce: 6, autofit: null}
    ],

    // Values for the "About this book" popup
    metadata: [
        {label: 'Resource ID', value: rid},
        {label: 'Title', value: title},
        {label: 'Access', value: access},
        {label: 'Contributed By', value: contributor},
    ],
    thumbnail: url_list[0],


    /* BookReader's search plugin options */
    server: rs_dir,
    bookId: rid,
    bookPath: path_to_pdf,
    searchInsideUrl: "/plugins/bookreader/search_inside.php",

};
var br = new BookReader(options);
// Let's go!
br.init();
