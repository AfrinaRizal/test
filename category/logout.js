$(function(){
    'use strict';


});


$("#logOut").on('click',function () {
    window.localStorage.clear();
    window.sessionStorage.clear();
    setTimeout(window.location.replace("../index.html"),1000);});
