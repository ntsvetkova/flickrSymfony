require (["jquery", "underscore", "app/validator"], function ($, _, validate) {
    $( document ).ready(function () {
        var locale = window.location.pathname.slice(1) != '' ? window.location.pathname.slice(1) : 'en';
        $("button#feedback").bind('click', function() {
            $("div.feedback").show();
            //$.ajax({
            //    url:  '/locale/feedback',
            //    success: function(response) {
            //        $("div.feedback").html(response);
            //    }
            //});
        });

        validate();
        $("div.g-recaptcha").children().children().css('margin', '10px auto 0');
    });
});