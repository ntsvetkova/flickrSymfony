/**
 * Created by vkalachikhin on 03.09.15.
 */
define("app/menu", ["jquery", "underscore"], function ($, _) {

    $( document ).ready(function() {
        var locale = window.location.pathname.slice(1) != '' ? window.location.pathname.slice(1) : 'en';
        $.getJSON('http://symf.com/'+locale+'/menu', function(json) {
            var responseJson = JSON.stringify(json);
            var responseItems = JSON.parse(responseJson);

            var Link = {
                type: 'link',
                text: '',
                path: '',
                defineLink: function(text, path) {
                    this.text = text;
                    this.path = path
                }
            };
            var menuLink = _.create(Link);
            menuLink.type = 'menu link';

            $( responseItems.items ).each(function(index) {
                menuLink.defineLink(responseItems.items[index].text, responseItems.items[index].path);
                $( '<div></div>' )
                    .addClass('cell')
                    .append( $( '<a></a>' )
                        .addClass('menu')
                        .text(menuLink.text)
                        .attr('href', menuLink.path)
                )
                    .fadeIn(1000)
                    .appendTo("#table");
            });
        });
    });
        //$("#table").load('http://symf.com/en/menu');;
});