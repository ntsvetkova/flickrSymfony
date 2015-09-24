//define("app/recaptcha", ["async!https://www.google.com/recaptcha/api.js?hl=en!onload"], function (grecaptcha) {
//    console.log('loaded');
//
//    return function(id) {
//        return grecaptcha.render(id, {
//                'sitekey': '6LdiDQ0TAAAAAIdApd1TC3ri_H73Y2sgNoF4QFfh'
//            });
//    };
//});

define("app/recaptcha", function () {
    requirejs(['recaptcha'],
        function() {
                Recaptcha.create('6LdiDQ0TAAAAAIdApd1TC3ri_H73Y2sgNoF4QFfh', 'test');
                //grecaptcha.render('test', {
                //    'sitekey': '6LdiDQ0TAAAAAIdApd1TC3ri_H73Y2sgNoF4QFfh'
                //});
        }
    );

    console.log( 'loaded' );
});