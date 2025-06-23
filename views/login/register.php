
<div class="login">
    <main class="subir ">
    <div class="form login-form">
        <h2>register</h2>
        <form id="register" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="avartar">Avatar</label>
                <input type="file" name="img" id="img" accept="image/*">
            </div>

            <div class="form-group">
                <label for="direccion">dirrecion</label>
                <input type="text" name="direccion" id="direccion" placeholder="Calle, numero, ciudad, pais">
            </div>
            
            <a href="/login">tengo cuenta</a>
            <a href="/login">no me acuerdo de mi contraseña</a>
            <button type="submit" class="boton">register</button>
        </form>
    </div>
</main>
</div>