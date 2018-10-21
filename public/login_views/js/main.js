"use strict";

/** Route Settings */
const loginRoute = "/api/login";

/** Username/Password */
let username = "";
let password = "";

$(window).on("load", function() {

    /** Click on sign-in */
    $(document).on("click","#sign",function(e) {
        e.preventDefault();
        username = $("#username").val();
        password = $("#password").val();
        //
        login();
        //
        $('.form-items','.form-content').addClass('hide-it');
        $('.form-sent','.form-content').addClass('show-it');
    });

});


/**
 * Ajax call
 *
 * @param url
 * @param postData
 * @param callback
 */
const jqxhr = function (url, postData, callback) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        method: "POST",
        url: url,
        crossDomain: true,
        data: postData,
        success: function (data) {
            callback(data);
        },
        error: function (data) {
            console.log(data);
            alert("Errore \n\n Something went wrong");
        }
    });

};

/**
 * Login function
 */
function login(){

    jqxhr(loginRoute, {
            "email" : username,
            "password" : password
    },
    function (data) {

        try {

            let redirectUrl = data.data.dashboard_url;

            window.location.replace(redirectUrl);

        } catch (e) {

            console.log(data);

            alert("Errore \n\n Something went wrong");

        }

    });

}