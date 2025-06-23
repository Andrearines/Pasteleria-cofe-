<?php
require_once __DIR__. '/../includes/app.php';
use controllers\paginas;
use controllers\login;
use controllers\API;
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
$r->get("/forgot",[login::class,'forgot']);
$r->post("/forgot",[login::class,'forgot']);
//reset password
$r->get("/reset",[login::class,'reset']);
$r->post("/reset",[login::class,'reset']);
//confirm account
$r->get("/confirmar",[login::class,'confirmar']);

//visitas
$r->get("/",[paginas::class,'visit']);


// API Routes
$r->get("/api/FindByAll",[API::class,'findbyall']);
$r->post("/api/servicios/crear",[API::class,'crearServicio']);
$r->put("/api/servicios/actualizar",[API::class,'actualizarServicio']);
$r->delete("/api/servicios/eliminar",[API::class,'eliminarServicio']);

$r->Rutas();