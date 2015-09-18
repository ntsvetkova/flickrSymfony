require (["jquery", "underscore"], function ($, _) {
    $( document ).ready(function () {

        $("div.g-recaptcha").children().children().css('margin', '10px auto 0');

        $("label.required").each(function(index) {
            var attr = $(this).attr("for");
            if (typeof attr === typeof undefined || attr === false) {
                $(this).remove();
            }
        });

        var throttled = _.throttle(validate, 1000, {leading: false});
        $("input.form-control").bind('keydown mouseup', (function () {
            throttled(this);
        }));

        function validate(input)
        {
            var data = {name: input.name, value: input.value};
            if (input.name.indexOf('[second]') > 0) {
                var id = input.id.slice(0,-6) + 'first';
                data = {name: input.name, value: input.value, first_value: $("input#"+id)[0].value};
            }
            $.post('/validation', data)
                .success(function (json) {

                    function create(classAdd, classRemove, classGlyphicon) {
                        if (!$(input).parent().hasClass("input-group")) {
                            $(input).parent()
                                .removeClass(classRemove)
                                .addClass(classAdd);
                            if (classAdd == "has-error") {
                                $(input).parent().find("label.control-label.input-sm").text(json.message);
                                $(input).parent().find("label.control-label.input-sm").show();
                                $(input).parent().find("span.glyphicon-ok").hide();
                                $(input).parent().find("span.glyphicon-warning-sign").hide();
                            }
                            else if (classAdd == "has-warning") {
                                $(input).parent().find("label.control-label.input-sm").text(json.message);
                                $(input).parent().find("label.control-label.input-sm").show();
                                $(input).parent().find("span.glyphicon-ok").hide();
                                $(input).parent().find("span.glyphicon-remove").hide();
                            }
                            else {
                                $(input).parent().find("label.control-label.input-sm").hide();
                                $(input).parent().find("span.glyphicon-warning-sign").hide();
                                $(input).parent().find("span.glyphicon-remove").hide();
                            }
                            $(input).parent().find("span." + classGlyphicon).show();
                            $(input).parents().children("div.alert").remove();
                        }
                        else {
                            $(input).parent()
                                .removeClass(classRemove)
                                .addClass(classAdd);
                            $(input).parent().parent()
                                .removeClass(classRemove)
                                .addClass(classAdd);
                            if (classAdd == "has-error") {
                                $(input).parent().parent().find("label.control-label.input-sm").text(json.message);
                                $(input).parent().parent().find("label.control-label.input-sm").show();
                                $(input).parent().parent().find("span.glyphicon-ok").hide();
                                $(input).parent().parent().find("span.glyphicon-warning-sign").hide();
                            }
                            else if (classAdd == "has-warning") {
                                $(input).parent().parent().find("label.control-label.input-sm").text(json.message);
                                $(input).parent().parent().find("label.control-label.input-sm").show();
                                $(input).parent().parent().find("span.glyphicon-ok").hide();
                                $(input).parent().parent().find("span.glyphicon-remove").hide();
                            }
                            else {
                                $(input).parent().parent().find("label.control-label.input-sm").hide();
                                $(input).parent().parent().find("span.glyphicon-warning-sign").hide();
                                $(input).parent().parent().find("span.glyphicon-remove").hide();
                            }
                            $(input).parent().parent().find("span." + classGlyphicon).show();
                            $(input).parents().children("div.alert").remove();
                        }
                    }

                    function createForm() {
                        $(input).parent().parent().next('div').show();
                        var collectionHolder = $(input).parent().parent().next('div');
                        collectionHolder.data('index', collectionHolder.find(':input').length);
                        var prototype = collectionHolder.children('div').data('prototype');
                        var index = collectionHolder.data('index');
                        if (index == 0) {
                            var newForm = prototype.replace(/__name__/g, index);
                            var newFormDiv = collectionHolder.append(newForm);
                            var newInput = newFormDiv.find('input.form-control');
                            newInput.bind('keydown mouseup', function() {
                                throttled(this);
                            });
                            newFormDiv.children('div').children('label.required').remove();
                        }
                    }

                    if (json.code == 0) {
                        create("has-success", "has-error has-warning", "glyphicon-ok");
                        if (input.name.indexOf('age') > 0 && input.value >= 18) {
                           createForm();
                        }
                        else if (input.name.indexOf('age') > 0 && input.value < 18) {
                            $(input).parent().parent().next('div').remove();
                        }
                    }
                    else if (json.code == 1) {
                        create("has-error", "has-success has-warning", "glyphicon-remove");
                        if (input.name.indexOf('age') > 0) {
                            $(input).parent().parent().next('div').hide();
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