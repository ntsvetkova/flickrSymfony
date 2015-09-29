define("app/manager", ["jquery", "underscore", 'app/menu', 'app/header', 'app/content', 'app/publish'], function ($, _, Menu, Header, Content, Publish)  {
    var menuContainer = $("div#menu-table");
    var contentContainer = $("div#content-table");
    var headerContainer = $("div.header h1");
    var content = new Content;

    var Manager = {
        createMenu: function () {
            Menu.create();
            if (Menu.isCreated) {
                menuContainer.on('click', 'a.menu', function (e) {
                    if (this.target !== '_self') {
                        e.preventDefault();
                        Publish.publish("changeContent", this.pathname);
                    }
                });
            }
        }
    };

    Publish.subscribe("changeContent", function(topic, link) {
        content.render(contentContainer, link);
    });
    Publish.subscribe("changeHeader", function (topic, header) {
        Header.render(headerContainer, header);
    });

    return Manager;
});