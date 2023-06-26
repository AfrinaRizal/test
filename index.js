$("#form_login").on('submit',function(e){
    if(!confirmed){
        e.preventDefault();
        let icnum = $("#icnum").val();
        let password = $("#password").val();

       

        const form = new FormData();

form.append("icnum", icnum );
form.append("password", password);
var host = "http://localhost/test/public/";

var settings = {
//   "async": true,
//   "crossDomain": true,
  // "url": "http://localhost/test/public/login",
  "url": host +"/login",

  "method": "POST",
  "headers": {},
  "processData": false,
  "contentType": false,
  "mimeType": "multipart/form-data",
  "data": form
};

$.ajax(settings).done(function (response) {
  console.log(response);
  
  alert("Berjaya masuk");
});
    }
});