define("app/publish", ["jquery", "underscore"], function ($, _) {
    var topics = {};
    var subscriberID = -1;
    var Publish = {
        publish: function( topic, args ) {
            if ( !topics[topic] ) {
                return false;
            }
            var subscribers = topics[topic],
                length = subscribers ? subscribers.length : 0;
            while (length--) {
                subscribers[length].func( topic, args );
            }
            return this;
        },
        subscribe: function( topic, func ) {
            if (!topics[topic]) {
                topics[topic] = [];
            }
            var token = ( ++subscriberID ).toString();
            topics[topic].push({
                token: token,
                func: func
            });
                return token;
            },
        unsubscribe: function( token ) {
            for (var m in topics) {
                if (topics[m]) {
                    for (var i = 0, j = topics[m].length; i < j; i++) {
                        if (topics[m][i].token === token) {
                            topics[m].splice(i, 1);
                            return token;
                        }
                    }
                }
            }
            return this;
        }
    };
    return Publish;
});