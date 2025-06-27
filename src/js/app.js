document.addEventListener("DOMContentLoaded", () => {
    iniciarApp();
});

function iniciarApp() {
    


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
            const icon=document.querySelector("#carrito")
            icon.addEventListener("click",()=>{
                modalCarrito();
            })
        }
        
        FindByAll("categoria_id", 2,"#especiales-h","especiales-card",2);
        CAll()
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
        method: "GET",}
   );
   Swal.fire({
    title: "Procesando...",
    text: "Por favor, espere.",
    icon: "info",
    showConfirmButton: false,
    timer: 8000,
    timerProgressBar: true,
});
  const data = await response.json();

  if(tipo=="1"){ mostrar(data,elemeto,clase);}
 
  if(tipo=="2"){ mostrarH(data,elemeto,clase);}
   }catch(error) {
        Swal.fire({
            title: "no se pudo conectar con la base de datos?",
            text: "Por favor, intente más tarde.",
            icon: "error",
            showConfirmButton: false,

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

    function modalCarrito(){
        const img = document.querySelector("#perfil-img").value;
        const nombre = document.querySelector("#perfil-nombre").value;
        const email = document.querySelector("#perfil-email").value;

        if(document.querySelector("#modal-carrito")){
            
           cerrarModal("#modal-carrito");
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
        <div class="carrito-items">
            
        </div>
        <div class="modal-carrito-footer">
            <button class="boton btn-cerrar" id="btn-cerrar" style="margin-bottom: 8rem;" onclick="cerrarModal('#modal-carrito')">cerrar</button>
        </div>
        `;
        contendor.appendChild(modal);
        
    }

    function modal(id,img,nombre,precio){
        
        if(document.querySelector("#modal")){
            cerrarModal("#modal");
            return;
        }
        const modal = document.createElement("div");
        const contendor = document.querySelector("body");
        modal.classList.add("modal");
        modal.dataset.id=id;
        modal.id="modal";
        
        modal.innerHTML = `
        <div class="modal-content"> 
            <img src="/build/img/imagenes_menu/${img}" alt="${nombre}">
            <h2>${nombre}</h2>
            <p style="text-align: start;">${precio}</p>
            <div class="modal-footer">
            <button class="boton btn-añadir" id="btn-añadir" onclick="añadir()">añadir</button>
            <input type="number" class="input" id="btn-cantidad" placeholder="cantidad" min="1" max="10">
            </div>
            <button class="boton btn-cerrar" id="btn-cerrar" style="margin-bottom: 8rem;" onclick="cerrarModal('#modal')">cerrar</button>
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
        
        const layout = document.createElement("a");
        layout.classList.add("layout");
        layout.href = "/categorias?id="+id;
        card.appendChild(layout);
        card.classList.add(clase);
      
        
        const titulo=document.createElement("h2");
        titulo.textContent = categoria;
        layout.appendChild(titulo);
        contendor.appendChild(card);
        });

       
       
    }


