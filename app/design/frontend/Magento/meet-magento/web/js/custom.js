require([
    'jquery'
],function($){
    $(function(){
        var shrinkHeader = 50;
        $(window).scroll(function() {
            var scroll = getCurrentScroll();
            if ( scroll >= shrinkHeader ) {
                $('.page-header').addClass('shrink');
            }
            else {
                $('.page-header').removeClass('shrink');
            }
        });
        function getCurrentScroll() {
            return window.pageYOffset || document.documentElement.scrollTop;
        }

        $(document).ready(function(){
            $('.confapp-agenda-wrapper ul').hide();
            $('.confapp-agenda-wrapper ul:first').show();
            $('.confapp-agenda-wrapper .conf-days a.conf-days-item:first').addClass('active');

            $('.confapp-agenda-wrapper .conf-days a.conf-days-item').click(function(){
                $('.confapp-agenda-wrapper .conf-days a.conf-days-item').removeClass('active');
                $(this).addClass('active');
                var currentTab = $(this).attr('href');
                $('.confapp-agenda-wrapper ul').hide();
                $(currentTab).show();
                return false;
            });
        });

    });
});

