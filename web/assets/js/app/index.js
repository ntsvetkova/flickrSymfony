/**
 * Created by vkalachikhin on 03.09.15.
 */
require(['jquery', 'app/menu', 'app/manager'], function($, Menu, Manager) {
    $( "div[class='header']" ).css('color','black');
    $( "div.header" )
        .on("mouseenter", function() {
            $( this ).css('color', 'grey')
        })
        .on("mouseleave", function() {
            $( this ).css('color', 'black')
        });
    Manager.createMenu();

});
