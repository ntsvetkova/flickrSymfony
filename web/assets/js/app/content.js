define("app/content", ["jquery", "underscore", "app/manager"], function ($, _, Manager) {
    var contentContainer = $("div.content");
    var Content = {
        data: {},
        render: function(link) {
            $.ajax({
                url: link,
                success: function(response) {
                    if (_.isObject(response) && _.has(response, 'html') && _.has(response, 'data')) {
                        contentContainer.html(response.html);
                    }
                    else {
                        contentContainer.html(response);
                    }
                },
                fail: function() {
                    contentContainer.html('');
                }
            });
        }
    };
    return Content;
});