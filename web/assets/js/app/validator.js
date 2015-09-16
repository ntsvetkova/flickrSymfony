require (["jquery", "underscore"], function ($, _) {
    $( document ).ready(function () {

        var timer = null;
        $("input.form-control").keydown(function() {
            clearTimeout(timer);
            timer = _.delay(validate, 1500, this);
        });

        function validate(input)
        {
            $.post('/validation', {name: input.name, value: input.value})
                .success(function (json) {

                    function create(classAdd, classRemove, classGlyphicon) {
                        var label = $('<label></label>')
                            .addClass("control-label input-sm")
                            .text(json.message)
                            .css({
                                'width': '100%',
                                'margin-bottom': '10px'
                            });
                        var span = $('<span></span>')
                            .addClass("glyphicon form-control-feedback " + classGlyphicon)
                            .attr('aria-hidden', 'true')
                            .css('top', '35px');

                        if (!$(input).parent().hasClass("input-group")) {
                            $(input).parent()
                                .removeClass(classRemove)
                                .addClass("has-feedback " + classAdd)
                                .children("label.control-label.input-sm").remove();
                            $(input).parent()
                                .find("span.glyphicon").remove();
                            if (classAdd != "has-success") {
                                label.insertAfter($(input));
                            }
                            span.insertAfter($(input));
                        }
                        else {
                            $(input).parent()
                                .removeClass(classRemove)
                                .addClass(addClass);
                            $(input).parent().parent()
                                .removeClass(classRemove)
                                .addClass("has-feedback " + classAdd)
                                .children("label.control-label.input-sm").remove();
                            $(input).parent().parent()
                                .find("span.glyphicon").remove();
                            if (classAdd == "has-error") {
                                label.css('color', '#a94442')
                            }
                            if (classAdd != "has-success") {
                                label.insertAfter($(input).parent());
                            }
                            span.insertAfter($(input).parent());
                        }
                    }

                    if (json.code == 0) {
                        create("has-success", "has-error has-warning", "glyphicon-ok");
                    }
                    else if (json.code == 1) {
                        create("has-error", "has-success has-warning", "glyphicon-remove");
                    }
                    else {
                        create("has-warning", "has-error has-success", "glyphicon-warning-sign");
                    }

                })
                .fail(function () {
                    console.log('Error: the response is not a JSON response');
                });
        };
    });
});