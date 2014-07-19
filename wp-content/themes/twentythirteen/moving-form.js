/*Pour faire bouger le form au scroll*/
(function($) {
var positionElement = $('.widget_text').offset().top;
jQuery(window).scroll(
    function() {
        if (jQuery(window).scrollTop() >= positionElement) {
            // fixed
            jQuery('.widget_text').addClass("move");
        } else {
            // relative
            jQuery('.widget_text').removeClass("move");
        }
    }
);
})( jQuery );
