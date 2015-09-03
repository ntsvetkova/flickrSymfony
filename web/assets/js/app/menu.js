/**
 * Created by vkalachikhin on 03.09.15.
 */
define("app/menu", ["jquery"], function ($) {

    $( document ).ready(function() {
          $("#table").load('http://symf.com/en/menu');
    });

});