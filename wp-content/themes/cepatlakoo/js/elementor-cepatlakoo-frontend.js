(function($) {

    'use strict';

    $(document).ready(function($) {
        var wasClick = [];
        $(".quick-contact-info a").on('click', function() {
            var FBAction = $(this).attr('fb-pixel');
            if ( typeof fbq !== 'undefined' && FBAction ) {
                if ($.inArray(FBAction, wasClick) == -1) {
                    if( FBAction != 'noevent' ){
                        fbq('track', FBAction, {});
                        wasClick.push(FBAction);
                    }
                }
            }
        });

        $('.gallery-thumbnail').each(function(index, element) {
            var get_gallery_thumb_opt = $(this).text();
            var that = $(this).siblings('.shop-detail-custom');

            if (get_gallery_thumb_opt == 'hide_gallery') {
               that.find(".thumbnails-slider").addClass('owl-carousel').owlCarousel({
                    items: 1,
                    loop: false,
                    margin: 0,
                    nav: true,
                    dots: false,
                    singleItem: true,
                    thumbs: false,
                    thumbsPrerendered: false,
                    autoHeight: false,
                    navText: ["<i class='icon icon-angle-left'></i>", "<i class='icon icon-angle-right'></i>"]
                });
            } else if (get_gallery_thumb_opt == 'show_gallery') {
               that.find(".thumbnails-slider").addClass('owl-carousel').owlCarousel({
                    items: 1,
                    loop: false,
                    margin: 0,
                    nav: true,
                    dots: false,
                    singleItem: true,
                    thumbs: true,
                    thumbsPrerendered: true,
                    autoHeight: false,
                    navText: ["<i class='icon icon-angle-left'></i>", "<i class='icon icon-angle-right'></i>"]
                });
            }
        });

    });
})(jQuery);
