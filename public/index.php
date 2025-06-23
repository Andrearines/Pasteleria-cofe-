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
$r->get("/",[paginas::class,'visit']);


// API Routes
$r->get("/api/FindByAll",[API::class,'findbyall']);
$r->post("/api/servicios/crear",[API::class,'crearServicio']);
$r->put("/api/servicios/actualizar",[API::class,'actualizarServicio']);
$r->delete("/api/servicios/eliminar",[API::class,'eliminarServicio']);

$r->Rutas();