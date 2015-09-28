define("app/header", ["jquery", "underscore"], function ($, _) {
    var Header = {
        render: function(target, header) {
            target.html(header);
        }
    };
    return Header;
});