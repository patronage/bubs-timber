// requires cookies lib and query string
// https://github.com/ScottHamper/Cookies
// https://github.com/sindresorhus/query-string
// bower install --save query-string cookies-js

Cookies.defaults = {
    path: '/',
    // domain: '.bubs.dev',
    expires: 365 * 24 * 60 * 60
};

var bsdSource = function() {
    var parsed = queryString.parse(location.search);
    if ( parsed.source ) {
        Cookies.set('source', parsed.source);
    }
    if ( parsed.subsource ) {
        Cookies.set('subsource', parsed.subsource);
    }
};


var fitVidInit = function(){
    $('.container').fitVids();
};

var smoothScrollInit = function(){
    $('a').smoothScroll();
};

var matchHeightInit = function(){
    $('.js-match-height').matchHeight();
};

var quickshareInit = function(){
    quickShare();
};

// init without document.ready
bsdSource();

// init within document.ready
(function($) {

    fitVidInit();
    matchHeightInit();
    smoothScrollInit();
    quickShareInit();

})(jQuery);
