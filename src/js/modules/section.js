(function($) {

    $(document).ready(function() {
        sectionFullwidth();
    });

    $(window).load(function() {
        sectionFullwidth();
    });

    $(window).resize(function() {
        sectionFullwidth();
    });

    function sectionFullwidth() {
        $('.x_section__fullwidth, .x_section__fullwidth-no-padding').each(function(){
           let _this = $(this);
           let _wWidth = $(window).width();
           let $page_content = $('.page-content');
           let _width = ($page_content.length) ? $page_content.width() : $(this).parent().width();
           let _quarterWidth = (_wWidth - _width) / 2;
           _this.css({
              width : `${_wWidth}px`,
              left : `-${_quarterWidth}px`,
           });
        });
    }

})(jQuery);