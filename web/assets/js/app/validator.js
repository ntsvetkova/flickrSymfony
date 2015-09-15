require (["jquery", "underscore"], function ($, _) {
    $( document ).ready(function () {
        $( "input.form-control" ).bind('keypress blur change keyup', function() {
            var input = this;
            $.post('/validation', {name: this.name, value: this.value})
                .success(function (json) {

                    function removeErrorLabel() {
                        if (!$( input ).parent().hasClass("input-group")) {
                            $( input ).parent()
                                .children("label[class='control-label input-sm']").remove();
                        }
                        else {
                            $( input ).parentsUntil("div[class='']")
                                .children("label[class='control-label input-sm']").remove();
                        }
                    }

                    if (json == 'Success') {
                        $( input ).parent()
                            .removeClass("has-error")
                            .addClass("has-success has-feedback");

                        removeErrorLabel();

                        var span = $('<span></span>')
                            .addClass("glyphicon glyphicon-ok form-control-feedback")
                            .attr('aria-hidden', 'true')
                            .css('top', '35px');
                        if (!$( input ).parent().hasClass("input-group")) {
                            span.insertAfter($(input));
                        }
                        else {
                            $( input).parent().removeClass("has-feedback");
                            $( input ).parentsUntil("div[class='']").children("span.glyphicon").remove();
                            $( input ).parent().parent()
                                .addClass("has-success has-feedback");
                            span.insertAfter($( input ).parent());
                        }

                        //todo weak/strong password

                    }
                    else {
                        $( input ).parent()
                            .removeClass("has-success")
                            .addClass("has-error has-feedback")
                            .children("span.glyphicon").remove();

                        removeErrorLabel();

                        var label =  $('<label></label>')
                            .addClass("control-label input-sm")
                            .text(json)
                            .css({
                                'width': '100%',
                                'margin-bottom': '10px'
                            });
                        if ($( input ).parent().hasClass("input-group")) {
                            $( input ).parentsUntil("div[class='']").children("span.glyphicon").remove();
                            label
                                .css('color', '#a94442')
                                .insertAfter($( input ).parent());
                        }
                        else {
                           label.insertAfter($( input ));
                        }
                    }
                })
                .fail(function () {
                    console.log('Error: the response is not a JSON response');
                });
        });
    });
});