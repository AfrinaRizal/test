
$ (function(){
    "use strict";

        // console.log('test');
    list_product();

    // del_product(product_id);
    if($('#flag').val() === 'upt'){
        load_tab();
    }
    // console.log('test');
    load_category();


});

function list_product() {
    
    var host = "http://localhost/test/public";
    var settings = {
        "url":  host + "/list",
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
                { "name": "product_name", "title": "Product Name" },
                { "name": "category", "title": "Category"},
                { "name": "price", "title": "Price", },
                { "name": "stock", "title": "Stock" },
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
                product_id: field.product_id, 
                product_name: field.product_name, 
                category: field.category,
                price:field.price,
                stock:field.stock,
                bil: bil++,
                action:`<button class="btn btn-primary" onclick="details('`+field.product_id+`');"><i class="fa fa-edit"></i></button>
                <button id="product_id" class="btn btn-danger" onclick="del_product('`+field.product_id+`');"><i class="fa fa-trash"></i></button>`
            });
        });
        $("#list_product").html('');
        $("#list_product").footable({
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
        let product_name = $("#product_name").val();
        let category = $("#category").val();
        let price = $("#price").val();
        let stock = $("#stock").val();

        let form = new FormData();
        form.append('product_name',product_name);
        form.append('category',category);
        form.append('price',price);
        form.append('stock',stock);
      
        // var host = "http://"+window.location.hostname+"/test/public/login/";
        // var host = "http://localhost/test/public/";

var settings = {
//   "async": true,
//   "crossDomain": true,
//   "url": "http://localhost/test/public/login",
// var host = "http://localhost/test/public/";

  "url": host +"/createProduct",

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

//load the data of the product in update_product
function load_tab(){

    var settings = {
        // "async": true,
        // "crossDomain": true,
        "url": host+"showProduct/" + window.sessionStorage.id,
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
        $("#product_id").val(data.product_id);
        $("#product_name").val(data.product_name);
        $("#category").val(data.category);
        $("#price").val(data.price);
        $("#stock").val(data.stock);
    });
    // let obj = new get(host+'/showCategory',window.sessionStorage.category_id).execute();
    // if(obj.success){
    //     let data = obj.data; 
    //     $.each(data, function(i, item){
                
             
    //     });
    // } 
}


//update product
var confirmed = false;


$("#form_update").on('submit', function (e) {
    // $("#loading_modal").modal('show');
    // let $this = $(this);
    if (!confirmed) {
        e.preventDefault();
        let product_id = $("#product_id").val();
        let product_name = $("#product_name").val();
        let category = $("#category").val();
        let price = $("#price").val();
        let stock = $("#stock").val();
      

        var form = new FormData();
        form.append("product_id", product_id);
        form.append("product_name", product_name);
        form.append("category", category);
        form.append("price", price);
        form.append("stock", stock);
     
        // for (var pair of form.entries()) {
        //     console.log(pair[0]+ ', ' + pair[1]); 
        // }

        let obj = new post(host+'/updateProduct',form,window.sessionStorage.token).execute();
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

//dropdown category name
function load_category(){
    // console.log('test');
let obj = "";
obj = new post(host+'/listCategory',window.sessionStorage.token).execute();
if(obj.success){
    let data = obj.data;
    console.log(data);
    $("#category").html('<option value="">SELECT CATEGORY</option>');
    $("#upt_category").html('<option value="">SELECT CATEGORY</option>');
    $.each(data, function(i, item){
        $("#category").append(`<option value="`+item.name+`">`+item.name+`</option>`);
        $("#upt_category").append(`<option value="`+item.name+`">`+item.name+`</option>`);
    });
} else {
    swal(obj.message,obj.data,'error');
}
}


// $("#category").on('change',function(){
//     var form = new FormData();
//     form.append("name", $("#category").val());    
//     obj = new post(host+'/listCategory',form,window.sessionStorage.token).execute();
//     if(obj.success){
//         $("#divCategory").removeClass('d-none');
//         $("#category").html('<option value="">PILIH BAHAGIAN</option>');
//         $.each(obj.data, function(i,item){
//             $("#category").append(`<option value="`+item.name+`">`+item.name+`</option>`);
//         });
//     } else {
//         $("#divCategory").addClass('d-none');
//     }
// });

//delete product
function del_product(product_id){
    
    // var host = "http://localhost/test/public";
    var form = new FormData();
    form.append("product_id", product_id);
    let obj = new post(host+'/deleteProduct',form,window.sessionStorage.token).execute();
    if(obj.success){
        result = obj;
        alert("Padam maklumat ini?");
        window.location.reload();

    }
}

//display update data 
function details(product_id){

    window.sessionStorage.id=product_id;
    window.location.replace("update_product.html");


}