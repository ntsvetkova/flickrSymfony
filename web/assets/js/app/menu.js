/**
 * Created by vkalachikhin on 03.09.15.
 */
define("app/menu", ["jquery"], function ($) {

    $( document ).ready(function() {
        var locale = window.location.pathname.slice(1) != '' ? window.location.pathname.slice(1) : 'en';
        $.ajax({
            url: 'http://symf.com/'+locale+'/menu',
            contentType: 'application/json',
            success: function(json) {
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

                var menuLink = Object.create(Link);
                menuLink.type = 'menu link';

                for (i = 0; i < responseItems.items.length; i++) {
                    menuLink.defineLink(responseItems.items[i].text, responseItems.items[i].path);
                    $( '<div></div>' )
                        .addClass('cell')
                        .append( $( '<a></a>' )
                                    .addClass('menu')
                                    .text(menuLink.text)
                                    .attr('href', menuLink.path)
                                )
                        .fadeIn(1000)
                        .appendTo("#table");
                }
            }
        });
        //$("#table").load('http://symf.com/en/menu');
    });

});