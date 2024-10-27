jQuery(document).ready(function ($) {

    // console.log(document.documentElement.scrollTop);

    $('#header-alt-logo').hide();
    $('#whatsapp-icon').hide();

    $('.cart-item').mouseenter(function () {
        $('#main-header-logo').hide();
        $('#header-alt-logo').show();
    });

    $('.cart-item').mouseleave(function () {
        $('#main-header-logo').show();
        $('#header-alt-logo').hide();
    });

    $("#scrool-up").click(function () {
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });

    window.onscroll = function () {
        scrollFunction();
    };

    function scrollFunction() {
        if (document.body.scrollTop > 0 || document.documentElement.scrollTop > 0) {
            $("#header-alt-logo").show();
            $("#main-header-logo").hide();
            $('#whatsapp-icon').show();
        } else {
            $("#header-alt-logo").hide();
            $("#main-header-logo").show();
            $('#whatsapp-icon').hide();
        }
    }

});

