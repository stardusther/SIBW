let searchElement = [];
window.onload = initialize;

function initialize() {
  searchElement = document.getElementById("search-text");
  searchElement.addEventListener("keyup", async () => {
    const searchQuery = searchElement.value;
    if (searchQuery) {
      const url = new Request(
        `/search_products.php?search_query=${searchQuery}`
      );
      const response = await fetch(url);
      const responseJson = await response.json();
      generate(responseJson);
    } else {
      document.getElementById("results").innerHTML = "";
    }
  });
}

// funcion que reciba el json con los datos y genere los resultados
function generate(resultados) {
  document.getElementById("results").innerHTML = "";
  resultados.forEach((res, i) => {
    const div = document.createElement("div");
    div.setAttribute("class", "resultado");
    const { nombre } = res; // desectructurar objeto || es equivalente a const nombre = res['nombre'];
    const enlace = document.createElement("a");
    enlace.setAttribute("href", `/producto.php?prod=${res["id_prod"]}`);
    enlace.innerHTML = nombre;
    div.appendChild(enlace);
    document.getElementById("results").appendChild(div);
  });
}
