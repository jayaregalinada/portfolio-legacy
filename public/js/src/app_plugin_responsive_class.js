
/*
* Inspired by:
* http://designedbythomas.co.uk/blog/how-detect-width-web-browser-using-jquery
*
* This script is ideal for getting specific class depending on device width
* for enhanced theming. Media queries are fine in most cases but sometimes
* you want to target a specific JQuery call based on width. This will work
* for that. Be sure to put it first in your script file. Note that you could
* also target the body class instead of 'html' as well.
* Modify as needed
 */
(function($) {
  $(document).ready(function() {
    var current_width;
    current_width = $(window).width();
    if (current_width < 481) {
      $('html').addClass('m320').removeClass('m768').removeClass('desktop').removeClass('m480');
    } else if (current_width < 739) {
      $('html').addClass('m768').removeClass('desktop').removeClass('m320').removeClass('tablet');
    } else if (current_width < 970) {
      $('html').addClass('tablet').removeClass('desktop').removeClass('m320').removeClass('m768');
    } else if (current_width > 971) {
      $('html').addClass('desktop').removeClass('m320').removeClass('m768').removeClass('tablet');
    }
    if (current_width < 650) {
      $('html').addClass('mobile-menu').removeClass('desktop-menu');
    }
    if (current_width > 651) {
      $('html').addClass('desktop-menu').removeClass('mobile-menu');
    }
  });
  $(window).resize(function() {
    var current_width;
    current_width = $(window).width();
    if (current_width < 481) {
      $('html').addClass('m320').removeClass('m768').removeClass('desktop').removeClass('tablet');
    } else if (current_width < 669) {
      $('html').addClass('m768').removeClass('desktop').removeClass('m320').removeClass('tablet');
    } else if (current_width < 970) {
      $('html').addClass('tablet').removeClass('desktop').removeClass('m320').removeClass('m768');
    } else if (current_width > 971) {
      $('html').addClass('desktop').removeClass('m320').removeClass('m768').removeClass('tablet');
    }
    if (current_width < 650) {
      $('html').addClass('mobile-menu').removeClass('desktop-menu');
    }
    if (current_width > 651) {
      $('html').addClass('desktop-menu').removeClass('mobile-menu');
    }
  });
})(jQuery);
