document.addEventListener("DOMContentLoaded", () => {
    iniciarApp();
});

function iniciarApp() {
    consulta();
    
}


async function consulta(){
try{

    const url ="http://localhost:3000/api/servicios";
    const result=await fetch(url)
    const services =await result.json();
    
    mostrarS(services)
}catch(error){
alerta("error", "Error con el servidor", ".contenedor" ,false);
}
}

function mostrarS(S){
    
    alerta("success", S, ".header");
}

function alerta(tipo,mensage,elemento,desaparecer = true) {
    const alerta = document.createElement("div");
    const element = document.querySelector(elemento);
    alerta.classList.add("alerta");
    alerta.classList.add(tipo);
    alerta.textContent = mensage;
    element.appendChild(alerta);

    if(desaparecer){
        setTimeout(() => {
        alerta.remove();
    }, 3000);
    }
    
}