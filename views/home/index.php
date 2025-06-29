<?php $script="bundle.min"; ?>

<main>
<h1>especiales</h1>
<div class="especial-menu carousel" id="especiales-h">
</div>
<h2>categorias</h2>
<div class="categorias subi"  id="categorias">

</div>

<input type="hidden" name="seccion" id="perfil-img" value="<?php echo $_SESSION["img"]; ?>">
<input type="hidden" name="seccion" id="perfil-nombre" value="<?php echo $_SESSION["nombre"]; ?>">
<input type="hidden" name="seccion" id="perfil-email" value="<?php echo $_SESSION["email"]; ?>">
<input type="hidden" name="seccion" id="perfil-direccion" value="<?php echo $_SESSION["direccion"]; ?>">
<input type="hidden" name="seccion" id="perfil-id" value="<?php echo $_SESSION["id"] ?>">



</main>
