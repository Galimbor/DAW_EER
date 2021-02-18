'use strict'

let btnRegister = document.querySelector("#btnRegister");
let btnLogin = document.querySelector("#btnLogin");

btnLogin.addEventListener("click", function (e){
    e.preventDefault();
    document.querySelector("#register").classList.add("hidden");
    document.querySelector("#login").classList.remove("hidden");
});

btnRegister.addEventListener("click", function (e){
    e.preventDefault();
    document.querySelector("#login").classList.add("hidden");
    document.querySelector("#register").classList.remove("hidden");
});