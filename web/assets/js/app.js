/**
 * Created by vkalachikhin on 03.09.15.
 */
requirejs.config({
    baseUrl: 'assets/js',
    paths: {
        app: 'app',
        recaptcha:
            //'//www.google.com/recaptcha/api',
            '//www.google.com/recaptcha/api/js/recaptcha_ajax'
            //'//www.gstatic.com/recaptcha/api2/r20150915103233/recaptcha__en'
            //'https://www.google.com/recaptcha/api'
    },
    waitSeconds: 100,
    shim: {
        recaptcha: {
            deps: ['jquery'],
            exports: 'po'
        }
    }
});
