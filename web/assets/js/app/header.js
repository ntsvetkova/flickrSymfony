define("app/header", ["jquery", "underscore"], function ($, _) {
    var Header = {
        render: function(target, link) {
            $.getJSON(link, successHandler);
            function successHandler(response) {
                if (_.isObject(response) && _.has(response, 'data') && _.isObject(response.data) && _.has(response.data, 'headerText')) {
                    target.html(response.data.headerText);
                }
            }
        }
    };
    return Header;
});