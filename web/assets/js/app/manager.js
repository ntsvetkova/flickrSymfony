define('app/manager', ['jquery', 'underscore', 'app/menu', 'app/header', 'app/content'], function ($, _, Menu, Header, Content) {
    var menuContainer = $("div.container-menu");

    var Manager = {
        createMenu: function() {
            Menu.create();
            if (Menu.isCreated) {
                menuContainer.on('click', 'a.menu', function (e) {
                    e.preventDefault();
                    Manager.renderContent(this.pathname);
                    Manager.changeHeader(this.text);
                });
            }
        },
        changeHeader: function(title) {
            Header.render(title);
        },
        renderContent: function(link) {
            Content.render(link);
        }
    };
    return Manager;
});
