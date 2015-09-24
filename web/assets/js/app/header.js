define("app/header", ["jquery", "underscore", "app/manager"], function ($, _, Manager) {
    var headerContainer = $("div.header h1");
    var Header = {
        render: function(title) {
           headerContainer.html(title);
        }
    };
    return Header;
});