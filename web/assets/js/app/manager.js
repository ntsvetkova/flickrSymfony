define("app/manager", ["jquery", "underscore", 'app/menu', 'app/header', 'app/content'], function ($, _, Menu, Header, Content) {
    var menuContainer = $("div.container-menu");
    var contentContainer = $("div.content");
    var headerContainer = $("div.header h1");

    function ObserverList(){
        this.observerList = [];
    }

    ObserverList.prototype.add = function( obj ){
        return this.observerList.push( obj );
    };

    ObserverList.prototype.count = function(){
        return this.observerList.length;
    };

    ObserverList.prototype.get = function( index ){
        if( index > -1 && index < this.observerList.length ){
            return this.observerList[ index ];
        }
    };

    ObserverList.prototype.indexOf = function( obj, startIndex ){
        var i = startIndex;

        while( i < this.observerList.length ){
            if( this.observerList[i] === obj ){
                return i;
            }
            i++;
        }

        return -1;
    };

    ObserverList.prototype.removeAt = function( index ){
        this.observerList.splice( index, 1 );
    };

    function Subject(){
        this.observers = new ObserverList();
    }

    Subject.prototype.addObserver = function( observer ){
        this.observers.add( observer );
    };

    Subject.prototype.removeObserver = function( observer ){
        this.observers.removeAt( this.observers.indexOf( observer, 0 ) );
    };

    Subject.prototype.notify = function( context ){
        var observerCount = this.observers.count();
        for(var i=0; i < observerCount; i++){
            this.observers.get(i).update( context );
        }
    };

    function Observer(){
        this.update = function() {};
    }

    var Manager = {
        createMenu: function() {
            Menu.create();
            if (Menu.isCreated) {
                _.extend(menuContainer, new Subject());
                menuContainer.addObserver(contentContainer);
                menuContainer.addObserver(headerContainer);
                menuContainer.on('click', 'a.menu', function (e) {
                    if (this.target != 'this') {
                        e.preventDefault();
                        menuContainer.notify(this.pathname);
                    }
                    else {
                        this.target = '_self';
                    }
                });
                this.loadContent();
                this.changeHeader();
            }
        },
        loadContent: function () {
            _.extend(contentContainer, new Observer());
            contentContainer.update = function(link) {
                Content.render(contentContainer, link);
            };
        },
        changeHeader: function() {
            _.extend(headerContainer, new Observer());
            headerContainer.update = function(link) {
                Header.render(headerContainer, link);
            };
        }

    };
    return Manager;
});
