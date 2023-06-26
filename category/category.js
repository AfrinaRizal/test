
$ (function(){
    "use strict";
    list_category();
    del_category(category_id);
    load_tab();

});

function list_category() {
    
    var host = "http://localhost/test/public";
    var settings = {
        "url":  host + "/listCategory",
        "method": "POST",
        // "timeout": 0,
        "headers": {
            "Content-Type": "application/json"
        },
    };

    $.ajax(settings).done(function (response) {
        if(response.success){
            var columns = [
                { "name": "bil", "title": "Bil" },
                { "name": "name", "title": "Category Name"},
                { "name": "action", "title": "Action"},

        
                // { "name": "status_rekod", "title": "Status", "breakpoints": "md sm xs" },
                // { "name": "upt_btn", "title": "Tindakan"},
                // {"name":"status","title":"Status","breakpoints":"sm xs"}
            ];
        
        // let convertList = JSON.stringify(response.data);
        // $("#load_product").val(convertList);
        var list = [];
        let bil = 1;

        $.each(response.data, function (i, field) {
          

            list.push({
                category_id: field.category_id, 
                name: field.name, 
                bil: bil++,
                action:`<button class="btn btn-primary" onclick="details('`+field.category_id+`');"><i class="fa fa-edit"></i></button>
                <button id="category_id" class="btn btn-danger" onclick="del_category('`+field.category_id+`');"><i class="fa fa-trash"></i></button>`

               
            });
        });
        $("#list_category").html('');
        $("#list_category").footable({
            "columns": columns,
            "rows": list,
            "paging": {
                "enabled": true,
                "size": 20
            },
            "filtering": {
                "enabled": true,
                "placeholder": "Carian...",
                "dropdownTitle": "Carian untuk:",
                "class": "brown-700"
            }
        });
    }
    });
}

// function create_category() {

var confirmed = false;

$("#form_input").on('submit',function(e){
    if(!confirmed){
        e.preventDefault();
        // let category_id = $("#category_id").val();
        let name = $("#name").val();

        let form = new FormData();
        // form.append('category_id',category_id);
        form.append('name',name);
      
        // var host = "http://"+window.location.hostname+"/test/public/login/";
        var host = "http://localhost/test/public/";

var settings = {
//   "async": true,
//   "crossDomain": true,
//   "url": "http://localhost/test/public/login",

  "url": host +"/createCategory",

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
//   window.location.reload();
});
        let obj = new post(host+'createCategory',form,'');
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

// }


function load_tab(){

    var settings = {
        // "async": true,
        // "crossDomain": true,
        "url": host + "showCategory/" + window.sessionStorage.id,
        "method": "GET",
        // "timeout": 0,
        "headers": {
            "Content-Type": "application/json"
        },
        "processData": true,
        "data": ""
    };

    $.ajax(settings).done(function (response) {

        let data=response.data;
        $("#category_id").val(data.category_id);
        $("#name").val(data.name);
    });
    // let obj = new get(host+'/showCategory',window.sessionStorage.category_id).execute();
    // if(obj.success){
    //     let data = obj.data; 
    //     $.each(data, function(i, item){
                
             
    //     });
    // } 
}


$("#form_update").on('submit', function (e) {
    // $("#loading_modal").modal('show');
    // let $this = $(this);
    if (!confirmed) {
        e.preventDefault();
        let category_id = $("#category_id").val();
        let name = $("#name").val();
      

        var form = new FormData();
        form.append("category_id", category_id);
        form.append("name", name);
     
        // for (var pair of form.entries()) {
        //     console.log(pair[0]+ ', ' + pair[1]); 
        // }

        let obj = new post(host+'/updateCategory',form,window.sessionStorage.token).execute();
        if(obj.success){
            window.sessionStorage.token = obj.token;            
            swal({
                title: "Kemaskini Pengguna Sistem",
                text: "Berjaya!",
                type: "success",
                showConfirmButton: false,
                allowOutsideClick: false,
                html: false,
                timer: 2000
            }).then(function(){},
                
            );
            // alert("Update success");
            // window.location.reload();
        }
    }
});



function del_category(category_id){

    
    // var host = "http://localhost/test/public";
    var form = new FormData();
    form.append("category_id", category_id);
    let obj = new post(host+'deleteCategory',form,window.sessionStorage.token).execute();
    if(obj.success){
        result = obj;
        alert("Padam maklumat ini?");
        window.location.reload();

    }
}

function details(category_id){

    window.sessionStorage.id=category_id;
    window.location.replace("update_category.html");


}