define("app/content", ["jquery", "underscore", "app/publish"], function ($, _, Publish) {
    function submitData(target, link, functionName) {
        var data = {};
        target.find('input, textarea').each(function () {
            data[$(this).attr('name')] = $(this).val();
        });
        $.post(link, data)
            .success(function (response) {
                functionName(response);
            });
    };

    function loadImage (a) {
        var modal = $("#photo_large");
        $(modal.find("img.loading")).show();
        $(modal.find(".large_photo")).remove();
        var img = $("<img />").attr('src', a.href)
            .addClass('large_photo')
            .css('width', '100%')
            .on('load', function () {
                $(modal.find("img.loading")).hide();
                $(modal.find("div.modal-body")).append(img);
            });
    };

    var Content = {
        render: function (target, link) {
            target.hide();
            $("img.loading").show();
            $.getJSON(link, successHandler)
                .fail(function () {
                    target.html('');
                });
            function successHandler(response) {
                if (_.isObject(response) && _.has(response, 'html') && _.has(response, 'data')) {
                    if (_.isObject(response.data) && _.has(response.data, 'headerText')) {
                        Publish.publish("changeHeader", response.data.headerText);
                    }
                    target.html(response.html);
                    $("img.loading").hide();
                    target.fadeIn(1000);
                    var submit = target.find("button[type='submit']");
                    submit.on('click', function () {
                        submitData(target, link, successHandler);
                    });
                    $("a.large").bind('click', function () {
                        loadImage(this);
                    });
                }
                else {
                    target.html(response);
                    target.fadeIn(1000);
                }
            };
        }
    };
    return Content;
});