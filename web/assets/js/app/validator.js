require (["jquery", "underscore"], function ($, _) {
    $( document ).ready(function () {

        var timer = null;
        $("input.form-control").keydown(function() {
            clearTimeout(timer);
            timer = _.delay(validate, 2000, this);
        });

        function validate(input)
        {
            $.post('/validation', {name: input.name, value: input.value})
                .success(function (json) {

                    if (json == 'Success') {

                        var span = $('<span></span>')
                            .addClass("glyphicon glyphicon-ok form-control-feedback")
                            .attr('aria-hidden', 'true')
                            .css('top', '35px');

                        if (!$(input).parent().hasClass("input-group")) {
                            $(input).parent()
                                .removeClass("has-error")
                                .addClass("has-success has-feedback")
                                .children("label.control-label.input-sm").remove();
                            $(input).parent()
                                .find("span.glyphicon").remove();
                            span.insertAfter($(input));
                        }
                        else {
                            $(input).parent()
                                .removeClass("has-error")
                                .addClass("has-success");
                            $(input).parent().parent()
                                .removeClass("has-error")
                                .addClass("has-success has-feedback")
                                .children("label.control-label.input-sm").remove();
                            $(input).parent().parent()
                                .find("span.glyphicon").remove();
                            span.insertAfter($(input).parent());

                        }

                        //todo weak/strong password

                    }
                    else {

                        var label = $('<label></label>')
                            .addClass("control-label input-sm")
                            .text(json)
                            .css({
                                'width': '100%',
                                'margin-bottom': '10px'
                            });

                        if (!$(input).parent().hasClass("input-group")) {
                            $(input).parent()
                                .removeClass("has-success")
                                .addClass("has-error has-feedback")
                                .children("label.control-label.input-sm").remove();
                            $(input).parent()
                                .find("span.glyphicon").remove();
                            label.insertAfter($(input));
                        }
                        else {
                            $(input).parent()
                                .removeClass("has-success")
                                .addClass("has-error");
                            $(input).parent().parent()
                                .removeClass("has-success")
                                .addClass("has-error has-feedback")
                                .children("label.control-label.input-sm").remove();
                            $(input).parent().parent()
                                .find("span.glyphicon").remove();
                            label
                                .css('color', '#a94442')
                                .insertAfter($(input).parent());
                        }
                    }
                })
                .fail(function () {
                    console.log('Error: the response is not a JSON response');
                });
        };
    });
});