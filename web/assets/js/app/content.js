define("app/content", ["jquery", "underscore", "app/manager"], function ($, _, Manager) {
    var Content = {
        data: {},
        isLoaded: false,
        render: function(target, link) {
            var that = this;
            target.hide();
            $.ajax({
                url: link,
                success: function create(response) {
                    if (_.isObject(response) && _.has(response, 'html') && _.has(response, 'data')) {
                        target.html(response.html);
                        target.fadeIn(1000);
                        that.data = response.data;
                        var submit = target.find("button[type='submit']");
                        submit.on('click', function() {
                            that.submit(target, link, create);
                        });
                        $("a.large").bind('click', function() {
                            that.loadImage(this);
                        });
                    }
                    else {
                        target.html(response);
                        target.fadeIn(1000);
                    }
                    that.isLoaded = true;
                },
                fail: function() {
                    target.html('');
                }
            });
        },
        submit: function(target, link, functionName) {
            var data = {};
            target.find('input, textarea').each(function () {
                data[$(this).attr('name')] = $(this).val();
            });
            $.post(link, data)
                .success(function (response) {
                    functionName(response);
                });
        },
        loadImage: function(a) {
            var modal = $("#photo_large");
            $(modal.find("div.modal-body")).empty();
            var img = $("<img />").attr('src', a.href)
                .css('width', '100%')
                .on('load', function() {
                    $(modal.find("div.modal-body")).append(img);
                });
        }
    };
    return Content;
});