<main id="admin-panel" class="contenedor subi admin">
<h1>panel de administracion</h1>
<p>hola: <?php echo $_SESSION["nombre"]?></p>

<div class="busquedad-admin ">
    <div class="form-group">
   
  <h2>fecha</h2>
 
    <input type="date" name="fecha-filtros-admin" id="fecha-filtros-admin" value="<?php echo date('Y-m-d'); ?>">
    <div class="todos">
    <div>
    <input id="todos-filtro-admin" name="todos-filtro-admin" type="checkbox" />
    <label for="todos-filtro-admin">todo</label>
     </div>
    
</div>
</div>

</div>
<div id="pedidos-admin">

</div>
</main>
