define("app/menu", ["jquery", "underscore"], function ($, _) {
    var Menu = {
        isCreated: false,
        create: function () {
            $(document).ready(function () {

                function Link() {
                    this.type = 'link';
                    this.target = '_self';
                }

                Link.prototype.defineLink = function (text, path) {
                    this.text = text;
                    this.path = path;
                };

                function MenuLink() {
                    Link.call(this);
                    this.type = 'menu link';
                }

                MenuLink.prototype = _.create(Link.prototype);
                MenuLink.prototype.constructor = MenuLink;

                $.getJSON('/menu', function (json) {
                    var count = 0;
                    _.each(json.items, function (item, index, list) {
                        if (_.isObject(item) && _.has(item, 'text') && _.has(item, 'path')) {
                            var menuLink = new MenuLink();
                            menuLink.defineLink(item.text, item.path);
                            if (_.has(item, 'target')) {
                                menuLink.target = item.target;
                            }
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
                                        title: menuLink.text,
                                        target: menuLink.target
                                    })
                                )
                                .fadeIn(1000, function () {
                                    if (count % 2 == 0) {
                                        $(this).css({
                                            'transform': 'translateX(10px)',
                                            '-moz-transform': 'translateX(10px)',
                                            '-ms-transform': 'translateX(10px)',
                                            '-webkit-transform': 'translateX(10px)',
                                            '-o-transform': 'translateX(10px)'
                                        })
                                    } else {
                                        $(this).css({
                                            'transform': 'translateX(-10px)',
                                            '-moz-transform': 'translateX(-10px)',
                                            '-ms-transform': 'translateX(-10px)',
                                            '-webkit-transform': 'translateX(-10px)',
                                            '-o-transform': 'translateX(-10px)'
                                        })
                                    }
                                    $(this).css({
                                        '-webkit-transition': '-webkit-transform .5s',
                                        '-moz-transition': '-moz-transform .5s',
                                        'o-transition': '-o-transform .5s',
                                        'transition': 'transform .5s'
                                    });
                                    count++;
                                })
                                .appendTo("#menu-table");
                            $("a[title='mars']").attr('title', 'MARS');
                        }
                    });
                })
                    .fail(function () {
                        $("#menu-table").html('Error: the response is not a JSON response');
                        console.log('Error: the response is not a JSON response');
                    });
            });
            this.isCreated = true;
        }
        //},
        //itemClick: function() {
        //    if (this.isCreated) {
        //        $("div.container-menu").on('click', 'a.menu', function (e) {
        //            e.preventDefault();
        //            return this.href;
        //        });
        //    }
        //    return '#';
        //}
    };
    return Menu;
});