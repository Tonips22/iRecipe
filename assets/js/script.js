const nav_menu = document.querySelector(".menu-nav");
const nav_bar = document.querySelector(".nav-bar ul");
const btn_sesion = document.querySelector(".btn-sesion");
const btn_cerrar_sesion = document.querySelector(".btn-cerrar-sesion");
const title = document.querySelector(".title");
let nav_menu_activado = false;

const recetas = document.querySelectorAll(".receta");

function mostrarInfoReceta(){
    recetas.forEach(receta =>{
        const info = receta.querySelector(".info-receta");
        receta.addEventListener("mouseenter", ()=>{
            info.style.display = "flex";
        })

        receta.addEventListener("mouseleave", ()=>{
            info.style.display = "none";
        })
    })
}

function mostrarNavegacion(){
    console.log(nav_bar);
    console.log(btn_sesion);
    console.log(btn_cerrar_sesion);
    console.log(nav_menu);
    nav_menu.addEventListener("click", ()=>{
        if(!nav_menu_activado){
            nav_bar.style.display = "flex";
            if(btn_sesion !== null){
                btn_sesion.style.display = "block";
            }else if(btn_cerrar_sesion !== null){
                btn_cerrar_sesion.style.display = "block";
            }
            nav_menu_activado = true;
        }else{
            nav_bar.style.display = "none";
            if(btn_sesion !== null){
                btn_sesion.style.display = "none";
            }else if(btn_cerrar_sesion !== null){
                btn_cerrar_sesion.style.display = "none";
            }
            nav_menu_activado = false;
        }

    })
}

function app() {
    mostrarNavegacion();
    mostrarInfoReceta();
}

app();