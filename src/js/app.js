document.addEventListener("DOMContentLoaded", () => {
    iniciarApp();
});

function iniciarApp() {
    if(document.querySelector("#admin-panel")){
        adminPanel();   
    }

    if(document.querySelector("#reset-form")){
        resetPassword();
    }
    if(document.querySelector("#forgert-form")) {
        forgetPassword();
    }
    if(document.querySelector("#token-texto-r")){
        confirme()
    }
    if(document.querySelector("#categorias")){
        if(document.querySelector("#carrito")){
            carrito=[]
            pedido=[]
            const icon=document.querySelector("#carrito")
            icon.addEventListener("click",()=>{
                modalCarrito();
            })
        }
        
        Promise.all([
            FindByAll("categoria_id", 2,"#especiales-h","especiales-card",2),
            CAll()
        ]).catch(error => {
            console.error("Error cargando datos:", error);
        });
     }
    if(document.querySelector("#especiales-v")){
         FindByAll("categoria_id", 2,"#especiales-v","especiales-card",1);
    }
    if(document.querySelector("#register")){
        register()
    }

    if(document.querySelector("#login")){
        login()
    }

}

async function pedidosAdmin(){
    try {
      
        
        const fecha = document.querySelector("#fecha-filtros-admin");
        const todos = document.querySelector("#todos-filtro-admin");
        
        if (!fecha || !todos) {
            throw new Error("No se encontraron los elementos de filtro");
        }
        
        const url = `/api/admin/ordenes?fecha=${fecha.value}&todos=${todos.checked}`;
      
        const response = await fetch(url, {
            method: "GET",
            headers: {
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status} - ${response.statusText}`);
        }
        
        const data = await response.json();
    
        
        if (data.error) {
            console.error("❌ Error en la API:", data.error);
            Swal.fire({
                title: "Error en la consulta",
                text: data.error,
                icon: "error"
            });
            return;
        }
        
        console.log(`✅ Se cargaron ${data.length} pedidos`);
        mostrarPedidos(data);
        
    } catch (error) {
        console.error("❌ Error en pedidosAdmin:", error);
        Swal.fire({
            title: "Error de conexión",
            text: `No se pudieron cargar los pedidos: ${error.message}`,
            icon: "error"
        });
    }
}

function adminPanel(){
   
    
    const fecha = document.querySelector("#fecha-filtros-admin");
    const todos = document.querySelector("#todos-filtro-admin");
    pedidosAdmin();
    
    // Configurar eventos de filtro
    fecha.addEventListener("change", async (e) => {
        e.preventDefault();
       
        await pedidosAdmin();
    });
    
    todos.addEventListener("change", async (e) => {
        e.preventDefault();
     
        await pedidosAdmin();
    });
    
   
}



function mostrarPedidos(pedidos){
   
    
    const contendor = document.querySelector("#pedidos-admin");
    if (!contendor) {
        console.error("❌ No se encontró el contenedor de pedidos");
        return;
    }
    
    // Limpiar contenedor
    contendor.innerHTML = '';
    
    if (!pedidos || pedidos.length === 0) {
        contendor.innerHTML = `
            <div class="no-pedidos">
                <p>📭 No hay pedidos para mostrar</p>
                <small>Intenta cambiar la fecha o marcar "todo"</small>
            </div>
        `;
       
        return;
    }
    
   
    
    pedidos.forEach((pedido, index) => {
        const card = document.createElement("div");
        card.classList.add("pedido-admin");
        card.innerHTML = `
            <div class="pedido-info">
                <h3>👤 Cliente: ${pedido.nombre || 'Sin nombre'}</h3>
                <p>Información de pastel</p>
                <div class="pedido-info-content">
                <p>🍰 Pastel: ${pedido.nombre_pastel || 'Sin nombre'}</p>
                <p>🔢 Cantidad: ${pedido.cantidad || 0}</p>
                <p>💰 Total: $${pedido.total || 0}</p>
                </div>
                <p>Información de envio</p>
                <div class="pedido-info-content-2">
                <p>📅 Fecha: ${pedido.fecha || 'Sin fecha'}</p>
                <p>📍 Dirección: ${pedido.direccion || 'Sin dirección'}</p>
                <p>🕐 Hora: ${pedido.hora || 'Sin hora'}</p>
              </div>

            </div>
        `;
        contendor.appendChild(card);
    });
    
    
}

async function login(){

    const form = document.querySelector("#login-form")
    form.addEventListener("submit", async(e)=>{
        e.preventDefault()
        const data = new FormData(e.target)
        const response = await fetch("/api/login",{
            method:"POST",
            body:data
        })
         Swal.fire({
            title: "Procesando...",
            text: "Por favor, espere.",
            icon: "info",
            showConfirmButton: false,
        });
        const r = await response.json()

        if(r==true){
            Swal.fire({
                title: "bienvenido",
                icon: "success"
                
            }).then(() => {
                window.location.href = "/home";
            });
        }else{
             Swal.fire({
                title: "Error",
                text: r,
                icon: "error"
            });
        }

    })
    
}

async function resetPassword() {
    const form = document.querySelector("#reset-form");
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get("token");
        const response = await fetch("/api/login/reset?token="+token , {
            method: "POST",
            body: formData
        })

        Swal.fire({
            title: "Procesando...",
            text: "Por favor, espere.",
            icon: "info",
            showConfirmButton: false,
        });
        const r = await response.json();
        if(r==true){
            Swal.fire({
                title: "Contraseña restablecida",
                text: "Tu contraseña ha sido restablecida correctamente.",
                icon: "success"
            }).then(() => {
                window.location.href = "/login";
            });
        }else{
            Swal.fire({
                title: "Error",
                text: r,
                icon: "error"
            });
        }
    })
}
async function forgetPassword() {
    const form = document.querySelector("#forgert-form");
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        
        Swal.fire({
            title: "Procesando...",
            text: "Por favor, espere.",
            icon: "info",
            showConfirmButton: false,
        });

        const response = await fetch("/api/login/forget", {
            method: "POST",
            body: formData
        });

        const data = await response.json();
        if(data==true){
            Swal.fire({
                title: "Revisa tu correo",
                text: "Si el correo existe, recibirás un enlace para restablecer tu contraseña.",
                icon: "info"
            }).then(() => {
                window.location.href = "/login";
            });
        }else{
            Swal.fire({
                title: "Error",
                text: data,
                icon: "error"
            });
        }
    })
}

async function confirme() {
    const urlParams = new URLSearchParams(window.location.search);
    const texto = document.querySelector("#token-texto-r");
    const token = urlParams.get("token");
    const url = "/api/login/confirm?token=" + token;
    const r =await fetch(url, {
        method: "GET"
    })
     const data = await r.json();
    if(data==true){
        texto.textContent = "Cuenta confirmada, ahora puedes iniciar sesión";
        Swal.fire({
            title: "Cuenta confirmada",
            text: "Ahora puedes iniciar sesión.",
            icon: "success"
        }).then(() => {
            window.location.href = "/login";
        });
    }else{
        texto.textContent = "Token no válido o expirado";
        Swal.fire({
            title: "Token no válido",
            text: "El token proporcionado no es válido o ha expirado.",
            icon: "error"
        }).then(() => {
            window.location.href = "/register";
        });
    }

}

async function register() {
    try{
        const form = document.querySelector("#register");
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        Swal.fire({
            title: "Procesando...",
            text: "Por favor, espere.",
            icon: "info",
            showConfirmButton: false,
            })

        const response = await fetch("/api/login/register", {
            method: "POST",
            body: formData
        });
        
        const data = await response.json();
        if(data==true){
            Swal.fire({
                title: "revisa tu correo",
                text: "confirme su cuenta.",
                icon: "info"
            }).then(() => {
                window.location.href = "/login";
            });
        }else{
            Swal.fire({
                title: "completar el formulario",
                text: data,
                icon: "info"
            });
        }
    })
    }catch(data) {
        Swal.fire({
            title: "Error de conexión",
            text: "Por favor, intente más tarde.",
            icon: "error"
        });
        return;
    }
    
}

async function CAll(){
    try{
    const response = await fetch("/api/categorias/all",{
        method: "GET"
    });
    const data = await response.json();
    mostrarC(data,"#categorias","categoria-card");
    }catch(error){
        Swal.fire({
            title: "Error de conexión",
            text: "Por favor, intente más tarde.",
            icon: "error"
        });
    }
}


async function FindByAll(column, value,elemeto,clase,tipo) {
    try{
        const response = await fetch("/api/FindByAll?column="+column+"&value="+value,
        {
            method: "GET",
        });
        
        const data = await response.json();

        if(tipo=="1"){ mostrar(data,elemeto,clase);}
        if(tipo=="2"){ mostrarH(data,elemeto,clase);}
    }catch(error) {
        Swal.fire({
            title: "Error de conexión",
            text: "Por favor, intente más tarde.",
            icon: "error",
            showConfirmButton: true,
        });
    }
}

    function mostrarH(especiales,elemeto,clase) {
      
        const contendor = document.querySelector(elemeto);

        especiales.forEach(especial => {
             const {id,nombre,precio,img,categoria_id}=especial;

        const card=document.createElement("div");
         card.style.backgroundImage = `url(/build/img/imagenes_menu/${img})`;
         card.lazy = "true";
         card.style.backgroundSize = "cover";
        card.style.backgroundPosition = "center";
        card.style.backgroundRepeat = "no-repeat";
        card.dataset.id=id;
        const layout = document.createElement("div");
        layout.classList.add("layout");
        layout.addEventListener("click",()=>{
            modal(id,img,nombre,precio);
        });
        card.appendChild(layout);
        card.classList.add(clase);
        const titulo=document.createElement("h2");
        titulo.textContent = nombre;
        layout.appendChild(titulo);
        contendor.appendChild(card);
        });

       
       
    }


    function añadir(){
        const cantidad = document.querySelector("#btn-cantidad").value;
        const cantidadint= parseInt(cantidad);
        const id = document.querySelector("#modal").dataset.id;
        const nombre = document.querySelector("#modal").dataset.nombre;
        const precio = document.querySelector("#modal").dataset.precio;
        const img = document.querySelector("#modal").dataset.img;
        const item = {id,nombre,precio,img,cantidadint};
        if(carrito.find(item => item.id == id)){
            const index = carrito.findIndex(item => item.id == id);
            carrito[index].cantidadint += cantidadint;
        }else if(cantidad==0){
            Swal.fire({
                title: "Cantidad no válida",
                text: "La cantidad no puede ser 0",
                icon: "error"
            });
        }
        else{
            carrito.push(item);
        }
    
        cerrarModal("#modal");
        
        
    }

    function modalCarrito(){
        const img = document.querySelector("#perfil-img").value;
        const nombre = document.querySelector("#perfil-nombre").value;
        const email = document.querySelector("#perfil-email").value;
        const direccion = document.querySelector("#perfil-direccion").value;

        if(document.querySelector("#modal-carrito")){
            
           cerrarModal("#modal-carrito");
            return;
        }

        if(carrito.length==0){
            Swal.fire({
                title: "No hay productos en el carrito",
                icon: "error"
            });
            return;
        }
      
        document.body.style.overflow = 'hidden';
        const modal = document.createElement("div");
        const contendor = document.querySelector("body");
        modal.classList.add("modal-carrito");
        modal.classList.add("modal");
        modal.id="modal-carrito";
        modal.innerHTML = `
        <div class="modal-content">
            <h2>Carrito</h2>
        </div>
        <div class="perfil">
            <img src="/build/img/imagenes_perfiles/${img}" alt="perfil">
            <div class="perfil-info">
                <p>${nombre}</p>
                <p>${email}</p>
                
            </div>
        </div>
        <h3>pasteles</h3>
        ${carrito.map(item => `
        <div class="carrito-item">
            <img src="/build/img/imagenes_menu/${item.img}" alt="${item.nombre}">
            <div class="carrito-item-info">
            <h2>${item.nombre}</h2>
            <p>${item.precio}</p>
            <p>(${item.cantidadint})</p>
            </div>
            <button class="boton btn-eliminar" onclick="eliminarItem(${item.id})"><img class="icono-eliminar" src="/build/img/iconos/eiminar.svg" alt="eliminar"></button>
        </div>
        `).join("")}
        <p>total: ${carrito.reduce((acc,item)=> acc+item.precio*item.cantidadint,0).toFixed(2)}</p>
        <div class="fecha enviar-carrito">
        <input type="time" class="input" id="hora" placeholder="hora" min="07:00" max="23:00" step="900" value="07:00">
        <input type="date" class="input" id="fecha" placeholder="fecha" min="${new Date().toISOString().split('T')[0]}">
        </div>
        <div class="alertas">     
                <p id="alerta-hora"></p>
        </div>
       <div class="enviar-carrito">
       <button class="boton-blanco btn-enviar" id="btn-enviar" onclick="enviar()">enviar pedido</button>
       <input type="text" class="input" id="direccion" placeholder="direccion" value="${direccion}">
       </div>
        </div>
        <div class="modal-carrito-footer">
            <button class="boton-blanco btn-cerrar" id="btn-cerrar" style="margin-bottom: 8rem;" onclick="cerrarModal('#modal-carrito')">cerrar</button>
        </div>
        `;
        contendor.appendChild(modal);

        const fecha = document.querySelector("#fecha");
        const hora = document.querySelector("#hora");
        const alertaHora = document.querySelector("#alerta-hora");
        
     
        // Validación de hora
        hora.addEventListener("change", () => {
            const horaSeleccionada = hora.value;
            const [horas, minutos] = horaSeleccionada.split(':').map(Number);
            const horaActual = new Date();
            const horaActualNum = horaActual.getHours();
            const minutosActuales = horaActual.getMinutes();
            
            // Limpiar alerta anterior
            alertaHora.textContent = "";
            
            // Validar rango de horas (7am a 11pm)
            if(horas < 7 || horas >= 12) {
                alertaHora.textContent = "Solo se puede seleccionar de 7:00 AM a 12:00 PM";
                hora.value = "";
                return;
            }
            
            // Si es hoy, validar que no sea hora pasada
            const fechaSeleccionada = new Date(fecha.value);
            const fechaActual = new Date();
            const esHoy = fechaSeleccionada.toDateString() === fechaActual.toDateString();
            
            if(esHoy) {
                // Si es la hora actual o anterior
                if(horas < horaActualNum || (horas === horaActualNum && minutos <= minutosActuales)) {
                    alertaHora.textContent = "No se puede seleccionar la hora actual o anterior";
                    hora.value = "";
                    return;
                }
                
                // Validar que tenga al menos 1 hora de anticipación
                const tiempoMinimo = new Date();
                tiempoMinimo.setHours(tiempoMinimo.getHours() + 1);
                
                if(horas <= tiempoMinimo.getHours()) {
                    alertaHora.textContent = "Debe seleccionar al menos 1 hora de anticipación";
                    hora.value = "";
                    return;
                }
            }
        });
    }

   async function enviar(){
        const id = document.querySelector("#perfil-id").value;
        const fecha = document.querySelector("#fecha").value;
        if(fecha==null || fecha==""){
            Swal.fire({
                title: "Fecha no válida",
                text: "Por favor, seleccione una fecha",
                icon: "error"
            });
        }else{
        const hora = document.querySelector("#hora").value;
        const direccion = document.querySelector("#direccion").value;
    
        Swal.fire({
            title: "Procesando...",
            text: "Por favor, espere.",
            icon: "info",
            showConfirmButton: false,
        });
        
        const $url = "/api/envio";
        carrito.forEach(async item => {
            const formData = new FormData();
            formData.append('usuario_id', id);
            formData.append('fecha', fecha);
            formData.append('hora', hora);
            formData.append('direccion', direccion);
            formData.append('pastel_id', parseInt(item.id));
            formData.append('cantidad', item.cantidadint);
        
            const response = await fetch($url,{
                method: "POST",
                body: formData
            })
            const data = await response.json();
           
        })
            Swal.fire({
                title: "Pedido enviado",
                text: "El pedido ha sido enviado correctamente",
                icon: "success"
            });
            carrito=[];
            modalCarrito();
       
   
     }
    }

    function eliminarItem(id){
        carrito = carrito.filter(item => item.id != id);
        modalCarrito();
    }

    function modal(id,img,nombre,precio){
        document.body.style.overflow = 'hidden';
        if(document.querySelector("#modal")){
            cerrarModal("#modal");
            return;
        }
        const modal = document.createElement("div");
        const contendor = document.querySelector("body");
        modal.classList.add("modal");
        modal.dataset.id=id;
        modal.dataset.nombre=nombre;
        modal.dataset.precio=precio;
        modal.dataset.img=img;
        modal.id="modal";
        
        modal.innerHTML = `
        <img src="/build/img/imagenes_menu/${img}" alt="${nombre}">
        <div class="">
        <div class="modal-content"> 
            <h2>${nombre}</h2>
            <p>${precio}</p>
            <div class="modal-footer">
            <button class="boton-blanco btn-añadir" id="btn-añadir" onclick="añadir()">añadir</button>
            <input type="number" class="input" id="btn-cantidad" min="1" max="10" value="1">
            </div>
            <button class="boton-blanco btn-cerrar" id="btn-cerrar" style="margin-bottom: 8rem;" onclick="cerrarModal('#modal')">cerrar</button>
        </div>
        `;
       
        contendor.appendChild(modal);
    }

    function cerrarModal(m){
        document.body.style.overflow = 'auto';
        const modal = document.querySelector(m);
        modal.remove();
    }

function mostrar(especiales,elemeto,clase) {
      
        const contendor = document.querySelector(elemeto);

        especiales.forEach(especial => {
             const {id,nombre,precio,img,categoria_id}=especial;

        const card=document.createElement("div");
         card.style.backgroundImage = `url(/build/img/imagenes_menu/${img})`;
         card.lazy = "true";
         card.style.backgroundSize = "cover";
        card.style.backgroundPosition = "center";
        card.style.backgroundRepeat = "no-repeat";
        card.dataset.id=id;
        
        const layout = document.createElement("a");
        layout.classList.add("layout");
        layout.href = "/login";
        card.appendChild(layout);
        card.classList.add(clase);
      
        
        const titulo=document.createElement("h2");
        titulo.textContent = nombre;
        layout.appendChild(titulo);
        contendor.appendChild(card);
        });

       
       
    }

    function mostrarC(categorias,elemeto,clase) {
      
        const contendor = document.querySelector(elemeto);

        categorias.forEach(c=> {
             const {id,categoria,img}=c;

        const card=document.createElement("div");
         card.style.backgroundImage = `url(/build/img/imagenes_categorias/${img})`;
         card.lazy = "true";
         card.style.backgroundSize = "cover";
        card.style.backgroundPosition = "center";
        card.style.backgroundRepeat = "no-repeat";
        card.dataset.id=id;
        
        const layout = document.createElement("div");
        layout.classList.add("layout");
        layout.addEventListener("click",()=>{
            modalM(id,categoria)
        })
        card.appendChild(layout);
        card.classList.add(clase);
      
        
        const titulo=document.createElement("h2");
        titulo.textContent = categoria;
        layout.appendChild(titulo);
        contendor.appendChild(card);
        });

       
       
    }

    function modalM(id,nombre){
        document.body.style.overflow = 'hidden';
        const modal = document.createElement("div");
        const contendor = document.querySelector("body");
       
        modal.addEventListener("click",()=>{
            cerrarModal("#modal-menu");
        })
        modal.id="modal-menu";
        modal.innerHTML = `
        <div class="modal" id="modal-menu">
        <div class="modal-content" id="modal-menu-content">
            <h2>${nombre}</h2>
        
        </div>
        </div>
        `;
        contendor.appendChild(modal);
        FindByAll("categoria_id",id,"#modal-menu-content","menu-card",2);
    }


