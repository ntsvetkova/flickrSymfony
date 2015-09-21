/**
 * Created by vkalachikhin on 03.09.15.
 */
requirejs.config({
    baseUrl: 'assets/js',
    paths: {
        app: 'app',
        jquery: 'jquery',
        recaptcha: 'https://www.google.com/recaptcha'
    },
    waitSeconds: 45,
    shim: {
        recaptcha: {
            exports: 'grecaptcha'
        }
    }
});
