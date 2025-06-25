<?php

function sanitizar($html){
    return htmlspecialchars($html);
}
function mover($url){
    header("Location: $url");
    exit;
}

function auth(){
    session_start();
    if($_SESSION["login"] == true){
        return true;
    }else{
        mover("/login");
    }
}

function admin(){
    session_start();
    if($_SESSION["admin"] == true){
        return true;
    }else{
        if($_SESSION["login"] ==true){
            mover("/home");
        }else{
            mover("/login");
        }
    }
}