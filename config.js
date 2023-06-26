let id_users_master, users_id_master, name_master, icno_master, email_master, notel_master, agensi_master, jawatan_master, pejabat_master, bahagian_master, adm_superadmin_master, adm_pendaftaran_master, adm_perakuan1_master, adm_perakuan2_master, adm_perakuan3_master, adm_perakuan4_master, adm_kelulusan_master, adm_semakan_master, adm_keranimb_master;
let kat_permohonan_master = ["consent","strata","asing"];
let kat_menu = ["pendaftaran","perakuan","kelulusan","keputusan","rayuan","template"];
if(window.location.hostname == "localhost"){
  var host = "http://"+window.location.hostname+"/test/public/";
  var hostPDF = "http://"+window.location.hostname+"/test";
  var hostSPTB = "http://"+window.location.hostname+"/test/public/";
} else {
  var host = "http://"+window.location.hostname+"/test/public/";
  var hostPDF = "http://"+window.location.hostname+"/";
  var hostSPTB = "http://"+window.location.hostname+"/test/public/";
}

// amri hitam
const escapeRegExpMatch = function (s) {
    return s.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
}
const isExactMatch = (str, match) => {
    return new RegExp(`\\b${escapeRegExpMatch(match)}\\b`).test(str);
}
// test sini
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

// function logOut(){
//     window.localStorage.clear();
//     window.sessionStorage.clear();
//     setTimeout(window.location.replace("index.html"),1000);
// }

var backgroundColor = ["#ffffff", "aliceblue","#fffaed","#edfff3","#edfffb","#edflff","#ffedfd","#ffeded"];

const monthNames = ["Januari", "Februari", "Mac", "April", "Mei", "Jun", "Julai", "Ogos", "September", "October", "November", "Disember"];

function padTo2Digits(num) {
    return num.toString().padStart(2, '0');
  }

function formatDate(date) {
    return (
      [
        padTo2Digits(date.getDate()),
        padTo2Digits(date.getMonth() + 1),
        date.getFullYear(),
      ].join('-') +
      ' ' +
      [
        padTo2Digits(date.getHours()),
        padTo2Digits(date.getMinutes()),
        padTo2Digits(date.getSeconds()),
      ].join(':')
    );
}

function formatDateNoTime(date) {
    return (
      [
        padTo2Digits(date.getDate()),
        padTo2Digits(date.getMonth() + 1),
        date.getFullYear(),
      ].join('-')
    );
}

function formatDateToDB(date) {
    return (
      [
        date.getFullYear(),
        padTo2Digits(date.getMonth() + 1),
        padTo2Digits(date.getDate()),
      ].join('-') +
      ' ' +
      [
        padTo2Digits(date.getHours()),
        padTo2Digits(date.getMinutes()),
        padTo2Digits(date.getSeconds()),
      ].join(':')
    );
}