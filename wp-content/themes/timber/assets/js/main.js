// Small global functions can go here.
// Custom scripts can go in their own file.
// Globally used scripts are loaded via layout.twig
// Page specific scripts are loaded via {% block footer_scripts %}

var fitVidInit = function(){
    $('.container').fitVids();
};

var smoothScrollInit = function(){
    $('a').smoothScroll();
};

var matchHeightInit = function(){
    $('.js-match-height').matchHeight();
};

var quickShareInit = function(){
    quickShare();
};

var headerNavPosition = function(inMobileMq){
    // in mobile, the middle images are under the second large image . in desktop they are under the first one
    if ( inMobileMq.matches ){ // mobile
        $('.main-header-nav-desktop-holder .main-header-nav').appendTo( $('.main-header-nav-mobile-holder') );
    } else { //desktop
        $('.main-header-nav-mobile-holder .main-header-nav').appendTo($('.main-header-nav-desktop-holder'));
    }
};

var headerInit = function(){
    mobileMq = window.matchMedia('(max-width: 767px)'); //are we in mobile?

    //initial
    headerNavPosition(mobileMq);

    //on resize
    mobileMq.addListener(function(mql){
        headerNavPosition(mql);
    });

};

// init without document.ready

// init within document.ready
(function($) {

    fitVidInit();
    matchHeightInit();
    headerInit();
    smoothScrollInit();
    quickShareInit();
    analyticsSourcing();

})(jQuery);
