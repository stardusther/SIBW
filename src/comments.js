// Mostrar/Ocultar comentarios anteriores
let showButton = document.getElementById("toggleComments"); // Botón que muestra los comentarios anteriores

showButton.addEventListener("click", showComments); // FIXME no funciona sin el onclick dentro del html

function showComments() {
   let prevComments = document.getElementById("commentSection");
   let formulario = document.getElementById("form");

   if (prevComments.style.display === "none") {
        prevComments.style.display = "block";
       formulario.style.display = "block";
        showButton.innerText= "Ocultar comentarios";//fixme no funciona
   } else {
        prevComments.style.display = "none";
        formulario.style.display = "none";
        showButton.innerText = "Mostrar comentarios";
   }
    //alert("Hello! I am an alert box!");
}

// Palabras prohibidas
let commentbox = document.getElementById('comment');
commentbox.addEventListener("keypress", checkWords);

function checkWords() {
    let banned = ['coño','puta','gilipollas','cabrón'];
    //var my_textarea = document.getElementById('textarea').value;
    var pattern = /coño|puta|gilipollas|cabrón/ig;

    /*if (commentbox.match(pattern)) {
        commentbox = commentbox.replace(pattern, "****" );
        document.getElementById('comment').value = commentbox;
    }*/

    if (banned.some(word => commentbox.value.includes(word))) {
        commentbox = commentbox.replace(pattern, "****" );
        document.getElementById('comment').value = commentbox;
    }
}

// Verificar comentario --------------------------------------------
function verificar(){
    // Que los campos no están vacios
    let nom = document.forms["form"]["fname"].value;
    let mail = document.forms["form"]["femail"].value;
    let texto = document.forms["form"]["fcomment"].value;

    if (nom == "" || mail == "" || texto == "") {
        alert("Debes rellenar todos los campos");
        return false;
    }

    // Validar email
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail) == false){
        alert("Has escrito una dirección de correo inválida");
        return (false);
    }

    publicarComentario(); // Procedemos a publicar tras todas las comprobaciones


}

// Publicar comentario formateado -----------------------------------

const form = document.getElementById("form");
const commentSection = document.getElementById("commentSection");
//const commentContainer = document.getElementById('commentSection');

form.addEventListener("submit", publicarComentario);

function publicarComentario(){

    // Guardamos la fecha actual dd/mm/yy hh:mm
    let hoy = new Date ();
    let fecha = " " + hoy.toLocaleString();

    // Creamos el comentario
    const wrapper = document.createElement('div');
    const nombre = document.forms["form"]["name"].value;
    let texto = document.forms["form"]["comment"].value;

    wrapper.className = "comentario";
    const textbox = document.createElement('div');
    textbox.innerHTML = texto;
    document.forms["form"]["comment"].value = ""; // Borramos lo que haya escrito el usuario
    // Añadimos los elementos (nombre, fecha, hora...)
    wrapper.append(nombre, fecha, textbox);

    // Lo metemos en la sección de comentarios
    commentSection.appendChild(wrapper);
}

const commentContainer = document.getElementById('allComments');
document.getElementById('addComments').addEventListener('click', function () {
    addComment();
});

function addComment() {
    let commentText;
    const textBox = document.createElement('div');

    const wrapDiv = document.createElement('div');
    wrapDiv.className = 'wrapper';
    wrapDiv.style.marginLeft = 0;
    commentText = document.getElementById('newComment').value;
    document.getElementById('newComment').value = '';
    textBox.innerHTML = commentText;
    wrapDiv.append(textBox, replyButton, likeButton, deleteButton);
    commentContainer.appendChild(wrapDiv);

}