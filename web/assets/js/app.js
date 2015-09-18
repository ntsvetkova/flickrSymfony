/**
 * Created by vkalachikhin on 03.09.15.
 */
requirejs.config({
    baseUrl: 'assets/js',
    paths: {
        app: 'app',
        recaptcha: 'https://www.google.com/recaptcha/api'
    },
    waitSeconds: 45,
    shim: {
        recaptcha: { exports: 'grecaptcha' }
    }
});
