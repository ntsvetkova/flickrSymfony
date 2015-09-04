/**
 * Created by vkalachikhin on 03.09.15.
 */
define("app/menu", ["jquery", "underscore"], function ($, _) {
    return function() {
        $( document ).ready(function () {
            var locale = window.location.pathname.slice(1) != '' ? window.location.pathname.slice(1) : 'en';
            $.getJSON(locale + '/menu', function (json) {
                var responseJson = JSON.stringify(json);
                var responseItems = JSON.parse(responseJson);

                function Link() {
                    this.type = 'link';
                }

                Link.prototype.defineLink = function(text, path) {
                    this.text = text;
                    this.path = path;
                };

                function MenuLink() {
                    Link.call(this);
                    this.type = 'menu link';
                }

                MenuLink.prototype = _.create(Link.prototype);
                MenuLink.prototype.constructor = MenuLink;
                var menuLink = new MenuLink();
                //console.log(menuLink);

                _.each(responseItems.items, function(item) {
                    if (_.has(item, 'text') && _.has(item, 'path')) {
                        menuLink.defineLink(item.text, item.path);
                        $('<div></div>')
                            .addClass('cell')
                            .append($('<a></a>')
                                .addClass('menu')
                                .text(menuLink.text)
                                .attr({
                                    href: menuLink.path,
                                    title: menuLink.text
                                })
                        )
                            .fadeIn(1000)
                            .appendTo("#table");
                    }
                });
            })
                .fail(function() {
                    $( "#table" ).html('Error: the response is not a JSON response');
                });
        });
    }
});