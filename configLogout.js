function logOut(){
    window.localStorage.clear();
    window.sessionStorage.clear();
    setTimeout(window.location.replace("index.html"),1000);
}