<?php
require_once __DIR__. '/../includes/app.php';
use controllers\paginas;
use controllers\API;
use MVC\Router;
$r=new Router;
$r->get("/",[paginas::class,'index']);
$r->post("/",[paginas::class,'index']);

// API Routes
$r->get("/api/servicios",[API::class,'servicios']);
$r->post("/api/servicios/crear",[API::class,'crearServicio']);
$r->put("/api/servicios/actualizar",[API::class,'actualizarServicio']);
$r->delete("/api/servicios/eliminar",[API::class,'eliminarServicio']);

$r->Rutas();