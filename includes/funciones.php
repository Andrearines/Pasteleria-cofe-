<?php

function sanitizar($html){
    return htmlspecialchars($html);
}
function redireccionar($url){
    header("Location: $url");
    exit;
}