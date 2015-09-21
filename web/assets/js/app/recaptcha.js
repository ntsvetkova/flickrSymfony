define("app/recaptcha", ['https://www.google.com/recaptcha/api.js'], function() {
    return function () {
        return this.grecaptcha;
    };
    //console.log(data);
    //return grecaptcha;
});
