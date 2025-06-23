document.addEventListener("DOMContentLoaded", () => {
    iniciarApp();
});

function iniciarApp() {

    

    if(document.querySelector("#especiales-v")){
        categoria_id("categoria_id", 2);
    }
    if(document.querySelector("#register")){
        register()
    }
}

async function register() {
    const form = document.querySelector("#register");
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const response = await fetch("/api/login/register", {
            method: "POST",
            body: formData
        });
        const data = await response.json(); // ← para procesar respuesta
    console.log("Respuesta del servidor:", data);
    })
}


async function categoria_id(column, value) {
    //categoria_id
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


