define("app/menu_links", ['jquery', 'underscore'], function($, _) {
    function MenuLinks() {
        this.menuLinks = [];
    };

    MenuLinks.prototype.add = function(menuLink) {
        return this.menuLinks.push(menuLink);
    };

    MenuLinks.prototype.count = function () {
        return this.menuLinks.length;
    };

    MenuLinks.prototype.get = function( index ){
        if( index > -1 && index < this.menuLinks.length ) {
            return this.menuLinks[ index ];
        }
    };

    MenuLinks.prototype.indexOf = function( menuLink, startIndex ) {
        var i = startIndex;

        while( i < this.menuLinks.length ){
            if( this.menuLinks[i] === menuLink ){
                return i;
            }
            i++;
        }

        return -1;
    };

    MenuLinks.prototype.removeAt = function( index ){
        this.menuLinks.splice( index, 1 );
    };

    return MenuLinks;
});
