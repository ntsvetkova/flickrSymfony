define("app/manager", ["jquery", "underscore", 'app/menu', 'app/header', 'app/content', 'app/publish'], function ($, _, Menu, Header, Content, Publish)  {
    var menuContainer = $("div#menu-table");
    var contentContainer = $("div#content-table");
    var headerContainer = $("div.header h1");

    var Manager = {
        createMenu: function () {
            Menu.create();
            if (Menu.isCreated) {
                menuContainer.on('click', 'a.menu', function (e) {
                    if (this.target != 'this') {
                        e.preventDefault();
                        Publish.publish("changeContent", this.pathname);
                    }
                    else {
                        this.target = '_self';
                    }
                });
            }
        }
    };

    Publish.subscribe("changeContent", function(topic, link) {
        Content.render(contentContainer, link);
    });
    Publish.subscribe("changeHeader", function (topic, header) {
        Header.render(headerContainer, header);
    });

    return Manager;
});