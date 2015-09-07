/**
 * Created by vkalachikhin on 03.09.15.
 */
define("app/menu", ["jquery", "underscore"], function ($, _) {
    return function() {
        $( document ).ready(function () {
            var locale = window.location.pathname.slice(1) != '' ? window.location.pathname.slice(1) : 'en';
            $.getJSON(locale + '/menu', function (json) {
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

                var count = 0;
                _.each(json.items, function(item) {
                    if (_.has(item, 'text') && _.has(item, 'path')) {
                        menuLink.defineLink(item.text, item.path);
                        $('<div></div>')
                            .addClass('cell')
                            .css({
                                'border-radius': '40px/20px',
                                '-webkit-border-radius': '40px/20px',
                                '-moz-border-radius': '40px/20px'
                            })
                            .append($('<a></a>')
                                .addClass('menu')
                                .text(menuLink.text)
                                .attr({
                                    href: menuLink.path,
                                    title: menuLink.text
                                })
                            )
                            .fadeIn(1000, function () {
                                if (count % 2 == 0) {
                                    $( this ).css({
                                        'transform': 'translateX(10px)',
                                        '-moz-transform': 'translateX(10px)',
                                        '-ms-transform': 'translateX(10px)',
                                        '-webkit-transform': 'translateX(10px)',
                                        '-o-transform': 'translateX(10px)'
                                    })
                                } else {
                                    $( this ).css({
                                        'transform': 'translateX(-10px)',
                                        '-moz-transform': 'translateX(-10px)',
                                        '-ms-transform': 'translateX(-10px)',
                                        '-webkit-transform': 'translateX(-10px)',
                                        '-o-transform': 'translateX(-10px)'
                                    })
                                }
                                $( this ).css({
                                    '-webkit-transition': '-webkit-transform .5s',
                                    '-moz-transition': '-moz-transform .5s',
                                    'o-transition': '-o-transform .5s',
                                    'transition': 'transform .5s'
                                });
                                count++;
                            })
                            .appendTo("#table");
                        $("a[title='mars']").attr('title', 'MARS');
                    }
                });
            })
                .fail(function() {
                    $( "#table" ).html('Error: the response is not a JSON response');
                    console.log('Error: the response is not a JSON response');
                });
        });
    }
});