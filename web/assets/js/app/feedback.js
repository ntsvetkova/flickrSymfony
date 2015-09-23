require (["jquery", "underscore", "app/validator", "bootstrap"], function ($, _, validate) {
    $( document ).ready(function () {
        var locale = window.location.pathname.slice(1) != '' ? window.location.pathname.slice(1) : 'en';
        $("#feedback-btn").bind('click', function() {
            var modal = $("#feedback");
            modal.find("div.modal-error").hide();

            function hide(modal) {
                modal.modal('hide');
            }

            var throttled = _.throttle(hide, 2000, {leading: false});

            $.ajax({
                url: '/locale/feedback',
                success: function create(response) {
                    modal.find("div.modal-body").html(response);
                    validate();

                    var submit = modal.find("button[type='submit']");
                    submit.on('click', function() {
                        console.log('click');
                        var data = {};
                        modal.find('input, textarea').each(function() {
                            data[$(this).attr('name')] = $(this).val();
                        });
                        $.post('/locale/feedback', data)
                            .success(function(data) {
                                if (_.isObject(data) && _.has(data, 'code') && _.has(data, 'message') && data.code == 0) {
                                    modal.find("div.modal-body").html(data.message);
                                    throttled(modal);
                                }
                                else {
                                    create(data);
                                }
                            })
                            .fail(function() {
                                modal.find("div.modal-error").show();
                            });
                        });
                    },
                fail: function() {
                    modal.find("div.modal-error").show();
                }
            });
        });
    });
});