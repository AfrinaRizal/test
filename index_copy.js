$(function(){
    'use strict';

    if(window.sessionStorage.token != null){
        window.location.replace("view/");
    }
    else{
        window.localStorage.clear();
        window.sessionStorage.clear();
    }
    
});

var confirmed = false;

$("#form_login").on('submit',function(e){
    if(!confirmed){
        e.preventDefault();
        let icnum = $("#icnum").val();
        let password = $("#password").val();

        let form = new FormData();
        form.append('icnum',icnum);
        form.append('password',password);

        // var host = "http://"+window.location.hostname+"/test/public/login/";
//         var host = "http://localhost/test/public/";

// var settings = {
// //   "async": true,
// //   "crossDomain": true,
// //   "url": "http://localhost/test/public/login",

//   "url": host +"/login",

//   "method": "POST",
//   "headers": {},
//   "processData": false,
//   "contentType": false,
//   "mimeType": "multipart/form-data",
//   "data": form
// };

// $.ajax(settings).done(function (response) {
//   console.log(response);
//   //path 
//   window.location.replace("view.html");
// });
        let obj = new post(host+'login',form,'');
        let obj_login = obj.execute();

        if(obj_login.success){

            let data = obj_login.data;
            // alert(data);
            if($("#stay_login").prop('checked')){
                window.localStorage.icnum = data.icnum;
                // window.localStorage.agensi = data.agensi;
                window.localStorage.token = obj_login.token;
            }

            window.sessionStorage.icnum = data.icnum;
            // window.sessionStorage.agensi = data.agensi;
            window.sessionStorage.token = obj_login.token;
            // if (icnum == password){
            //     swal({
            //         title: "Log Masuk",
            //         text: "Pertama Kali Log Masuk. Sila Ubah Katalaluan Anda.",
            //         type: "info",
            //         closeOnConfirm: true,
            //         allowOutsideClick: false,
            //         html: false
            //     }).then(function(){
            //         $("#update_password").modal("show");
            //     });
            // } 
            
            // else  {
                window.location.replace("view.html");
            // }

        } else {
            // alert("tiada");
            swal({
                title: "Log Masuk",
                text: "Gagal!",
                type: "error",
                showConfirmButton: true,
                allowOutsideClick: true,
                html: obj_login.data,
                timer: 1000
            }).then(function(){},
                function (dismiss) {
                    // window.location.reload();
                }
            );
        }
    }
});

$("#form_register").on('submit',function(e){
    if(!confirmed){
        e.preventDefault();
        let name = $("#name").val();
        let email = $("#email").val();
        let icnum = $("#icnum").val();
        let address = $("#address").val();
        let contact = $("#contact").val();
        let password = $("#password").val();


        let form = new FormData();
        form.append('name',name);
        form.append('email',email);
        form.append('icnum',icnum);
        form.append('address',address);
        form.append('contact',contact);
        form.append('password',password);


        // var host = "http://"+window.location.hostname+"/test/public/login/";
        var host = "http://localhost/test/public/";

var settings = {
//   "async": true,
//   "crossDomain": true,
//   "url": "http://localhost/test/public/login",

  "url": host +"/register",

  "method": "POST",
  "headers": {},
  "processData": false,
  "contentType": false,
  "mimeType": "multipart/form-data",
  "data": form
};

$.ajax(settings).done(function (response) {
  console.log(response);
  //path 
  window.location.replace("index.html");
});
        // let obj = new post(host+'login',form,'');
        // let obj_login = obj.execute();

        // if(obj_login.success){
        //     let data = obj_login.data;
        //     if($("#stay_login").prop('checked')){
        //         window.localStorage.icno = data.icno;
        //         window.localStorage.agensi = data.agensi;
        //         window.localStorage.token = obj_login.token;
        //     }

        //     window.sessionStorage.icno = data.icno;
        //     window.sessionStorage.agensi = data.agensi;
        //     window.sessionStorage.token = obj_login.token;
        //     if (idpengguna == passwords){
        //         swal({
        //             title: "Log Masuk",
        //             text: "Pertama Kali Log Masuk. Sila Ubah Katalaluan Anda.",
        //             type: "info",
        //             closeOnConfirm: true,
        //             allowOutsideClick: false,
        //             html: false
        //         }).then(function(){
        //             $("#update_password").modal("show");
        //         });
        //     } else  {
        //         window.location.replace("view/");
        //     }

        // } else {
        //     swal({
        //         title: "Log Masuk",
        //         text: "Gagal!",
        //         type: "error",
        //         showConfirmButton: false,
        //         allowOutsideClick: false,
        //         html: obj_login.data,
        //         timer: 1000
        //     }).then(function(){},
        //         function (dismiss) {
        //             window.location.reload();
        //         }
        //     );
        // }
    }
});

// $("#logOut").on('click',function () {
//     logOut();
// });


$("#form_update").on('submit',function(e){
    if(!confirmed){
        e.preventDefault();
        let icnum = $("#icnum").val();
        let newpassword = $("#newpassword").val();
        let confirmnewpassword = $("#confirmnewpassword").val();
        if(newpassword == confirmnewpassword){
            var form = new FormData();
            form.append("icnum", icnum);
            form.append("password", newpassword);

            let obj = new post(host+'updatepassword',form,window.sessionStorage.token).execute();
            if(obj.success){
                swal({
                    title: "KEMASKINI KATALALUAN",
                    text: "Berjaya!",
                    type: "success",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    html: false,
                    timer: 1000
                }).then(function(){},
                    function (dismiss) {
                        window.location.replace("view.html");
                    }
                );
            } else {

            }
        }
    }
});