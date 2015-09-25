define("app/header", ["jquery", "underscore", "app/manager"], function ($, _, Manager) {
    var Header = {
        render: function(target, title) {
           target.html(title);
        }
    };
    return Header;
});