require (["jquery", "underscore"], function ($, _) {
    $( document ).ready(function () {
        $( "#app_registration_user__username" ).blur(function() {
            $.post('/validation', {name: this.name, value: this.value})
                .success(function (json) {
                    if (json == 'Success') {
                        $( "#app_registration_user__username" ).parent().removeClass().addClass("has-success");
                        $( "label[class='control-label input-sm']").remove();
                    }
                    else {
                        $( "#app_registration_user__username" ).parent().removeClass().addClass("has-error");
                        if ( $( "label[class='control-label input-sm']" ).length ) {
                            $( "label[class='control-label input-sm']" ).text(json);
                        }
                        else {
                            $('<label></label>')
                                .addClass("control-label input-sm")
                                .text(json)
                                .css('margin-bottom', '10px')
                                .insertAfter($("#app_registration_user__username"));
                        }
                    }
                });
        });
    });
});