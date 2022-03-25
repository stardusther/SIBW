
// Variables ----------------------------------------------------------

let showButton = document.getElementById("toggleComments"); // Botón que muestra los comentarios anteriores
let commentSection = document.getElementById("commentSection"); // Sección de comentarios (comentarios anteriores)
let formDiv = document.getElementById("flex-comentarios");
let formulario = document.getElementById("form"); // El formulario de los datos del usuario
let sendButton = document.getElementById('commentButton'); // Botón que publica el comentario
let likeButton = document.getElementById('animate__heartBeat'); // Botón de corazón


// Inicializar ----------------------------------------------------------

window.onload = init;

function init() {
    // Mostrar/Ocultar comentarios anteriores
    showButton.addEventListener("click", showComments);
    // Comprobar palabras que escribe el usuario
    formulario.addEventListener("keyup", censor(document.getElementById('fcomment')));
    formulario.addEventListener("keyup", censor(document.getElementById('fname')));
    // Verificar y publicar comentario
    formulario.addEventListener("submit", verificar);
    likeButton.addEventListener("click", liked);
}

// liked

function liked(){
    likebutton.toggleClass();
}

// Mostrar comentarios --------------------------------------------------

function showComments() {
    if (formDiv.style.display === "none") {
        formDiv.style.display = "flex";
        showButton.textContent = "Ocultar comentarios";
    } else {
        formDiv.style.display = "none";
        showButton.textContent = "Mostrar comentarios";
    }
}

// Censurar palabras prohibidas --------------------------------------------------

function censor (palabra){
    //var palabra = document.getElementById('fcomment');
    let banned = ['coño', 'puta', 'cabrón', 'polla', 'joder', 'imbécil']; 
    for(var aux of banned){
        palabra.value = palabra.value.replace(aux, "*".repeat(aux.length));
    }
}

// Verificar comentario --------------------------------------------

function verificar() {
    // Que los campos no están vacios
    let nom = document.forms["form"]["fname"].value;
    let mail = document.forms["form"]["femail"].value;
    let texto = document.forms["form"]["fcomment"].value;

    if (nom == "" || mail == "" || texto == "") {
        alert("Debes rellenar todos los campos");
        return false;
    }

    // Validar email
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail) == false) {
        alert("Has escrito una dirección de correo inválida");
        
        return (false);
    }

    publicarComentario();

}


// Publicar comentario formateado -----------------------------------

function publicarComentario() {
    // Guardamos la fecha actual dd/mm/yy hh:mm
    let hoy = new Date();
    
    let fechaDiv = document.createElement('span');
    fechaDiv.className = "fecha";
    fechaDiv.innerHTML = " " + hoy.toLocaleString();

    // Creamos el comentario
    const wrapper = document.createElement('div');
    const nombre = document.forms["form"]["fname"].value;
    const texto = document.forms["form"]["fcomment"].value;

    wrapper.className = "comentario";

    let nombreDiv = document.createElement('p');
    nombreDiv.className = "nombre";
    nombreDiv.append(nombre, fechaDiv);

    let heart = document.createElement('i');
    heart.className = "fa-solid fa-heart animate__heartBeat";

    const textbox = document.createElement('div');
    textbox.innerHTML = texto;
    textbox.className = "texto";
    document.forms["form"]["fcomment"].value = ""; // Borramos lo que haya escrito el usuario

    // Añadimos los elementos (nombre, fecha, hora...)
    wrapper.append(nombreDiv, textbox, heart);

    // Lo metemos en la sección de comentarios
    commentSection.appendChild(wrapper);
}