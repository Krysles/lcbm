//jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $(document).on('click', '.page-scroll', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});

$(window).load(function(){
    $("#navbar").sticky({ topSpacing: 0 });
});

