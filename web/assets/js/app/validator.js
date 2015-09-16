require (["jquery", "underscore"], function ($, _) {
    $( document ).ready(function () {

        $("label.required").each(function(index) {
            var attr = $(this).attr("for");
            if (typeof attr === typeof undefined || attr === false) {
                $(this).remove();
            }
        });

        var timer = null;
        $("input.form-control").keydown(function () {
            clearTimeout(timer);
            timer = _.delay(validate, 1000, this);
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
                            $(input).parent()
                                .children("div.alert").remove();
                            if (classAdd != "has-success") {
                                label.insertAfter($(input));
                            }
                            span.insertAfter($(input));
                        }
                        else {
                            $(input).parent()
                                .removeClass(classRemove)
                                .addClass(classAdd);
                            $(input).parent().parent()
                                .removeClass(classRemove)
                                .addClass("has-feedback " + classAdd)
                                .children("label.control-label.input-sm").remove();
                            $(input).parent().parent()
                                .find("span.glyphicon").remove();
                            $(input).parent().parent()
                                .children("div.alert").remove();
                            if (classAdd == "has-error") {
                                label.css('color', '#a94442')
                            }
                            if (classAdd != "has-success") {
                                label.insertAfter($(input).parent());
                            }
                            span.insertAfter($(input).parent());
                        }
                    }

                    function createForm() {
                        $(input).parent().next('div').show();
                        var collectionHolder = $(input).parent().next('div');
                        collectionHolder.data('index', collectionHolder.find(':input').length);
                        var prototype = collectionHolder.children('div').data('prototype');
                        var index = collectionHolder.data('index');
                        if (index == 0) {
                            var newForm = prototype.replace(/__name__/g, index);
                            var newFormDiv = collectionHolder.append(newForm);
                            var newInput = newFormDiv.find('input.form-control');
                            newInput.keydown(function() {
                                clearTimeout(timer);
                                timer = _.delay(validate, 1000, this);
                            });
                            newFormDiv.children('div').children('label.required').remove();
                        }
                    }

                    if (json.code == 0) {
                        create("has-success", "has-error has-warning", "glyphicon-ok");
                        if (input.name.indexOf('age') > 0 && input.value >= 18) {
                           createForm();
                        }
                    }
                    else if (json.code == 1) {
                        create("has-error", "has-success has-warning", "glyphicon-remove");
                        if (input.name.indexOf('age') > 0) {
                            $(input).parent().next('div').hide();
                        }
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