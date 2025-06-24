document.addEventListener("DOMContentLoaded", () => {
    iniciarApp();
});

function iniciarApp() {
    
    if(document.querySelector("#token-texto-r")){
        confirme()
    }

    if(document.querySelector("#especiales-v")){
         FindByAll("categoria_id", 2);
    }
    if(document.querySelector("#register")){
        register()
    }
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


async function FindByAll(column, value) {
    
    try{
  const response = await fetch("/api/FindByAll?column="+column+"&value="+value,
    {
        method: "GET",}
   );
  const data = await response.json();

 mostrar(data,"#especiales-v","especiales-card");
   }catch(error) {
        Swal.fire({
            title: "no se pudo conectar con la base de datos?",
            text: "Por favor, intente más tarde.",
            icon: "error"
        });
        return;
   }
    
   
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


