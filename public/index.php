<?php
require_once __DIR__. '/../includes/app.php';
use controllers\paginas;
use controllers\login;
use controllers\API;
use controllers\admin;
use MVC\Router;
$r=new Router;

//login
$r->get("/login",[login::class,'login']);
$r->post("/login",[login::class,'login']);
//logout
$r->get("/logout",[login::class,'logout']);
//register
$r->get("/register",[login::class,'register']);
$r->post("/register",[login::class,'register']);
//forgot password
$r->get("/forget",[login::class,'forget']);
$r->post("/forget",[login::class,'forget']);
//reset password
$r->get("/reset",[login::class,'reset']);
$r->post("/reset",[login::class,'reset']);
//confirm account
$r->get("/confirmar",[login::class,'confirm']);

//visitas
$r->get("/",[paginas::class,'visit']); 

//home
$r->get("/home",[paginas::class,"home"]);

//admin
$r->get("/admin",[admin::class,"index"]);

// API Routes(login)
$r->get("/api/FindByAll",[API::class,'findbyall']);
$r->get("/api/categorias/all",[API::class,'call']);
$r->post("/api/login",[API::class,"login"]);
$r->post("/api/login/register",[API::class,'register']);
$r->post("/api/login/forget",[API::class,'forget']);
$r->post("/api/login/reset",[API::class,'reset']);
$r->post("/api/envio",[API::class,'envio']);
$r->get("/api/login/confirm",[API::class,'confirm']);

//API admin
$r->get("/api/admin/ordenes",[API::class,'ordenes']);


$r->Rutas();