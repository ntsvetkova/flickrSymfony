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
        extend: function(obj, extension) {
            for ( var key in extension ){
                obj[key] = extension[key];
            }
        },
        createMenu: function() {
            Menu.create();
            if (Menu.isCreated) {
                this.extend(menuContainer, new Subject());
                menuContainer.addObserver(contentContainer);
                menuContainer.on('click', 'a.menu', function (e) {
                    e.preventDefault();
                    menuContainer.notify(this.pathname);
                });
                this.loadContent();
            }
        },
        loadContent: function () {
            this.extend(contentContainer, new Observer());
            contentContainer.update = function(link) {
                Content.render(contentContainer, link);
                if (Content.isLoaded) {
                    Manager.extend(contentContainer, new Subject());
                    contentContainer.addObserver(headerContainer);
                    Manager.changeHeader();
                    contentContainer.notify(Content.data);
                }
            };
        },
        changeHeader: function() {
            this.extend(headerContainer, new Observer());
            headerContainer.update = function(title) {
                Header.render(headerContainer, title);
            };
        }

    };
    return Manager;
});
