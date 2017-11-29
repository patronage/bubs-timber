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

// init within document.ready
(function($) {

    headerNav();
    fitVidInit();
    matchHeightInit();
    smoothScrollInit();
    analyticsSourcing();

})(jQuery);
