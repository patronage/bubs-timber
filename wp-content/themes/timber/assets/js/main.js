// Small global functions can go here.
// Custom scripts can go in their own file.
// Globally used scripts are loaded via layout.twig
// Page specific scripts are loaded via {% block footer_scripts %}

var fitVidInit = function(){
    $('.container').fitVids();
};

var smoothScrollInit = function(){
    $('a:not(.no-smooth-scroll)').smoothScroll();
};

var matchHeightInit = function(){
    $('.js-match-height').matchHeight();
};

var headerNav = function(){
    // better dropdown hover intent ( inspired by https://stackoverflow.com/a/42183824/462002 )
    $('.component-main-header').on('mouseenter mouseleave','.dropdown',function(e){
      var $dropdown =$( e.target ).closest('.dropdown');
      $dropdown.addClass('show');
      setTimeout(function(){
        $dropdown[ $dropdown.is(':hover') ? 'addClass' : 'removeClass' ]('show');
      } , 300);
    });
};

// a widow (single word on it's own line) adjuster. Typically fills in the last line with previous word(s)
// inspired by http://justinhileman.info/article/a-jquery-widont-snippet/
var widont = function() {
    $('h1,h2,h3,p').each(function() {
        var $element = $(this);

        // use  .no-widont to opt out of using it on the element above (handy for react element, highlighed text, ..)
        if ($element.hasClass('no-widont')){
            return;
        }
        $element.html($(this).html().replace(/\s([^\s<]{0,8})\s*$/,'&nbsp;$1'));
    });
};

// init within document.ready
(function($) {

    headerNav();
    fitVidInit();
    matchHeightInit();
    smoothScrollInit();
    analyticsSourcing();
    widont();

})(jQuery);
