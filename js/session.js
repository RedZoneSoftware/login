"use strict";
/*************************** SERVER CALL SECTION ******************************/

var __getUserAccess, getUserAccess, __handleSuccessfulLogin, __receiveGetAccessResponse, UserParams, __validateInputs, adjustPerPageSize, logout;


__getUserAccess = function(params)
{
    $.ajax({
        type: "POST",
        url: "getAccess.php",
        data: params
    }).done(function(response) {
        console.log(response);
        __receiveGetAccessResponse($.parseJSON(response));
    });
};

__handleSuccessfulLogin = function(redirect) {
    if(redirect === "") {
        window.location = "login_success.php";
    } else {
        window.location = "redirect.php";
    }
};

__receiveGetAccessResponse = function(userArrayObj) {

    if (userArrayObj['validated'])
    {
        // not actually used anywhere
        KELLY_UTILS.cookieCreate('user_name', userArrayObj['username']);
        KELLY_UTILS.cookieCreate('user_roles', userArrayObj['roles']);
        KELLY_UTILS.cookieCreate('rzsession', userArrayObj['session']);
        // show success notification and then forward
        $('#successContainer').show();
        // forward after one second just to show we're paying attention
        setTimeout(function() {
            __handleSuccessfulLogin(userArrayObj['redirect']);
        }, 1000);
    }
    else
    {
        new mBox.Notice({
            type: 'error',
            position: {
                x: 'left',
                y: 'top'
            },
            content: 'Invalid User Name'
        });
    }
};

UserParams = function(name, pass, redi)
{
    this.params = {};
    this.params.name = name;
    this.params.pass = pass;
    this.params.redi = redi;

    return this.params;
};

getUserAccess = function()
{
    var userName = $('#username').val();
    var userPass = $('#password').val();
    var userRedi = $('#redirect').val();

    var userParams = new UserParams(userName, userPass, userRedi);

    __getUserAccess(userParams);
};

__validateInputs = function() {
    var userName = $('#username').val();
    var userPass = $('#password').val();

    if (userName === "") {
        $('.name.error').removeClass('hidden');
    } else {
        $('.name.error').addClass('hidden');
    }

    if (userPass === "") {
        $('.pass.error').removeClass('hidden');
    } else {
        $('.pass.error').addClass('hidden');
    }

    if (userPass === "" || userName === "") {
        $('#newUserSubmit').prop("disabled", true);
    } else {
        $('#newUserSubmit').prop("disabled", false);
    }
};

/******************************************************************************/

// Just public page load novelties
var adjustPerPageSize = function()
{
    var w = $(document).width();
    var h = $(document).height();
    var mld = (h / 2 - $('#passcodeLoginDiv').height() / 2);
    var mua = (h / 2 - $('#passcodeUserAdd').height() / 2);

    // Center things
    $('#passcodeLoginDiv').css('margin-top', mld);
    $('#passcodeUserAdd').css('margin-top', mua);
};

var logout = function() {
    KELLY_UTILS.cookieErase('user_name');
    KELLY_UTILS.cookieErase('user_roles');
    KELLY_UTILS.cookieErase('rzsession');

    window.location = "logout.php";
};

var initLoginPage = function() {
    $('#username').keydown(function(e) {
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        __validateInputs();
        if (key === 13) {
            e.preventDefault();
            getUserAccess();
        }
    });

    $('#password').keydown(function(e) {
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        __validateInputs();
        if (key === 13) {
            e.preventDefault();
            getUserAccess();
        }
    });

    $('.validate').blur(function(e) {
        __validateInputs();
    });

    $('#newUserSubmit').mouseenter(function(e) {
        __validateInputs();
    });

    adjustPerPageSize();
};