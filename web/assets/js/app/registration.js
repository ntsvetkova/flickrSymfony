require (["jquery", "underscore", "app/validator"], function ($, _, validate) {
    $( document ).ready(function () {
        validate();

        $("label.required").each(function (index) {
            var attr = $(this).attr("for");
            if (typeof attr === typeof undefined || attr === false) {
                $(this).remove();
            }
        });

        $("div.g-recaptcha").children().children().css('margin', '10px auto 0');
    });
});