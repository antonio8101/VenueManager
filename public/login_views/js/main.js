"use strict";

/** Env */
const env = $('meta[name="env"]').attr('content');

/** Username/Password */
let username = "";
let password = "";

$(window).on("load", function() {

    /** Password Forget */
    $('.btn-forget').on('click',function(e){
        e.preventDefault();
        $('.form-items','.form-content').addClass('hide-it');
        $('.form-sent','.form-content').addClass('show-it');
    });

    /** Click on sign-in */
    $(document).on("click","#sign",function(e) {
        e.preventDefault();
        username = $("#username").val();
        password = $("#password").val();
        //
        login(env);
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
 *
 * @param env
 */
function login(env){

    jqxhr(env + "api/login", {
            "username" : username,
            "password" : password
        },
        function (data) {
            console.log(data);
            let redirectUrl = data.data.dashboard_url;
            window.location.replace(redirectUrl);
            // showOnReservation_Confirmed(data);
        });

}