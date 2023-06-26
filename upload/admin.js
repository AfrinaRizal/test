
$ (function(){
    "use strict";

        // console.log('test');
    list_admin();
    // console.log('test');

    // del_product(product_id);
    if($('#flag').val() === 'upt'){
        load_tab();
    }
    // console.log('test');
    // load_category();


});

function list_admin() {
    
    var host = "http://localhost/test/public";
    var settings = {
        "url":  host + "/listAdmin",
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
                { "name": "name", "title": "Admin Name" },
                { "name": "pfile", "title": "Image"},
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
                admin_id: field.admin_id, 
                name: field.name, 
                pfile: `<img src='uploadfile/` + field.pfile + `'  style="width:200px;">`, 
                bil: bil++,
                action:`<button class="btn btn-primary" onclick="details('`+field.admin_id+`');"><i class="fa fa-edit"></i></button>
                <button id="admin_id" class="btn btn-danger" onclick="del_admin('`+field.admin_id+`');"><i class="fa fa-trash"></i></button>`
            });
        });
        $("#list_admin").html('');
        $("#list_admin").footable({
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

var confirmed = false;

$("#form_input").on('submit',function(e){
    if(!confirmed){
        e.preventDefault();
        let name = $("#name").val();
        // let pfile = $("#pfile").val();
        let pfile = $("#pfile")[0].files[0];

  

        let form = new FormData();
        form.append('name',name);
        form.append('pfile',pfile);

      
        // var host = "http://"+window.location.hostname+"/test/public/login/";
        // var host = "http://localhost/test/public/";

var settings = {
//   "async": true,
//   "crossDomain": true,
//   "url": "http://localhost/test/public/login",
// var host = "http://localhost/test/public/";

  "url": host +"/upload",

  "method": "POST",
  "headers": {},
  "processData": false,
  "contentType": false,
  "mimeType": "multipart/form-data",
  "data": form
};

$.ajax(settings).done(function (response) {
  console.log(response);
//   console.log('test');

  //path 
  window.location.replace("index.html");

//   window.location.reload();
});
        // let obj = new post(host+'createProduct',form,'');
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

//load the data of the admin in update_admin
function load_tab(){

    var settings = {
        // "async": true,
        // "crossDomain": true,
        "url": host+"showAdmin/" + window.sessionStorage.id,
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
        $("#admin_id").val(data.admin_id);
        $("#name").val(data.name);
        // $("#pfile").val(data.pfile);

        let path = "uploadfile/";
        let pfile = "default.jpg";
        let pfile_default = "default.jpg";
        if(data.pfile != null  && data.pfile != ""){
            pfile = data.pfile;
            pfile_default = data.pfile;
            $('#btn-remove').removeClass('hidden');
            $('#divGambar').html('');
            let append =   `<span class="input-group-text"><i class=" text-muted material-icons">add_a_photo</i></span>
                            <span  id="btn-upload" class="input-group-text input-info-disabled disabled" style="cursor:not-allowed"> 
                                <a class="text-white " id="url-gambar" >Muat Naik</a> 
                            </span>
                            <span class='input-group-text' style='cursor:not-allowed;'>`+path+pfile_default+`</span>
                            <span id='btn-remove' onclick='removeGambar();' class='input-danger btn-danger input-group-text' style='cursor:pointer'>
                                <i class=' text-white material-icons'>delete_forever</i>
                            </span>`;
            $('#divGambar').append(append);
        }

        $("#gambar_original").attr("src", path+pfile);
        
    });
  
}


//update product
var confirmed = false;


$("#form_update").on('submit', function (e) {
    // $("#loading_modal").modal('show');
    // let $this = $(this);
    if (!confirmed) {
        e.preventDefault();
        let admin_id = $("#admin_id").val();
        let name = $("#name").val();
        let pfile = $("#pfile")[0].files[0];
      
      

        var form = new FormData();
        form.append("admin_id", admin_id);
        form.append("name", name);
        form.append("pfile", pfile);
   
        // let path = "uploadfile/";
        // $("#gambar_original").attr("src", path);


        let obj = new post(host+'/updateAdmin',form,window.sessionStorage.token).execute();
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

$("#pfile").change(function(event) {

    if($("#pfile").val() != null || $("#pfile").val() != ""){
        
        $('#btn-upload').css('cursor','not-allowed').removeClass('input-info btn-info').removeAttr("onclick").addClass('input-info-disabled disabled');
        $("#url_gambar").removeAttr('href');
        $("#divGambar").append("<span class='input-group-text'>"+$("#pfile").val().split('\\').pop()+"</span><span id='btn-remove' onclick='removeGambar();' class='input-danger btn-danger input-group-text' style='cursor:pointer'><i class=' text-white material-icons'>delete_forever</i></span>");
        
        var reader = new FileReader();

        reader.onload = function (e)
        {

            $('#gambar_original').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);

    }

});

$("#btn-remove").click(function () {    
    removeGambar();
});

function removeGambar(){
    let path = "uploadfile/";
    let img = "default.jpg";
    let append = '<span class="input-group-text"><i class=" text-muted material-icons">add_a_photo</i></span><span  id="btn-upload" onclick="triggerGambar();" class="input-group-text input-info btn-info" style="cursor:pointer"> <a class="text-white " >Muat Naik</a> </span>';

    $('#gambar_original').attr('src',path+img);
    $('#pfile').val(null);
    $('#btn-remove').addClass('hidden');
    $('#divGambar').html(append);
}

$("#btn-upload").on("click", function(){
    triggerGambar();
});

function triggerGambar(){
    $("#pfile").trigger("click");
}


//delete admin
function del_admin(admin_id){
    
    // var host = "http://localhost/test/public";
    var form = new FormData();
    form.append("admin_id", admin_id);
    let obj = new post(host+'/deleteAdmin',form,window.sessionStorage.token).execute();
    if(obj.success){
        result = obj;
        alert("Padam maklumat ini?");
        window.location.reload();

    }
}

//display update data 
function details(admin_id){

    window.sessionStorage.id=admin_id;
    window.location.replace("update_admin.html");


}