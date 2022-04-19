
// Declaración de variables ----------------------------------------------------------
let showButton = null;
let commentSection = null;
let commentDiv = null;
let formulario = null;
let sendButton = null;
//let likeButton = null;
let fname = null;
let fcomment = null;
let banned = [];

// Inicializar ----------------------------------------------------------

window.onload = init;

function init() {
    /*  ----------- Variables inicializadas  ----------- */
    // Botón que muestra los comentarios anteriores
    showButton = document.getElementById("toggleComments");
    // Sección de comentarios (comentarios anteriores)
    commentSection = document.getElementById("commentSection");
    // Contenedor de los comentarios y el form
    commentDiv = document.getElementById("flex-comentarios");
    // El formulario de los datos del usuario
    formulario = document.getElementById("form");
    // Nombre que introduce el usuario en el formulario
    fname = document.forms["form"]["fname"];
    // Comentario que introduce el usuario
    fcomment = document.forms["form"]["fcomment"];
    // Botón que publica el comentario
    sendButton = document.getElementById('commentButton');
    // Botón de corazón
    //likeButton = document.getElementById('fa-heart');

    // Probando
    commentDiv.style.display = "none";
    showButton.textContent = "Mostrar comentarios";

    // Mostrar/Ocultar comentarios anteriores
    showButton.addEventListener("click", showComments);

    // Comprobar palabras que escribe el usuario
    fcomment.addEventListener("keyup", censor(fcomment));
    fname.addEventListener("keyup", censor(fname));

    // Verificar y publicar comentario
    formulario.addEventListener("submit", verificar);

    // Dar like (no funciona)
    //likeButton.addEventListener("click", liked);

    banned = getBanned();

}

/* liked

function liked(){
    if(likeButton.classList.contains("liked"))
        likeButton.classList.remove( "liked");
    else
        likeButton.classList.add( "liked");
}*/

// Mostrar comentarios --------------------------------------------------

function showComments() {
    if (commentDiv.style.display === "none") {
        commentDiv.style.display = "flex";
        showButton.textContent = "Ocultar comentarios";
    } else {
        commentDiv.style.display = "none";
        showButton.textContent = "Mostrar comentarios";
    }
}

// Censurar palabras prohibidas --------------------------------------------------

function getBanned(){
    let xhttp = new XMLHttpRequest();
    let words = [];

    xhttp.open('GET', 'http://localhost/banned.php', true);

    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){ // response finished & request ready & status == OK
            json = JSON.parse(this.responseText);
            if(json == null)
                window.alert('el array de palabras censurables es null'); //TODO quitar
            else
                for(var i of json)
                    words.push(i["palabra"]);
        }
    };

    xhttp.send(null);

    return words;
}

function censor (palabra){ // Se podría hacer con un regex

    for(var aux of banned){ // que ponga tantos * como letras tiene la palabra
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

    // Tras las comprobaciones, publicamos el comentario
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
    heart.className = "fa-solid fa-heart";

    const textbox = document.createElement('div');
    textbox.innerHTML = texto;
    textbox.className = "texto";
    document.forms["form"]["fcomment"].value = ""; // Borramos lo que haya escrito el usuario

    // Añadimos los elementos (nombre, fecha, hora...)
    wrapper.append(nombreDiv, textbox, heart);

    // Lo metemos en la sección de comentarios
    commentSection.appendChild(wrapper);
}