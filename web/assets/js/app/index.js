/**
 * Created by vkalachikhin on 03.09.15.
 */
require(['app/menu', 'jquery'], function(menu, $) {
    $( "div[class='header']" ).css('color','grey');
    $( "div.header" )
        .on("mouseenter", function() {
            $( this ).css('color', 'black')
        })
        .on("mouseleave", function() {
            $( this ).css('color', 'grey')
        });
    menu();
});
