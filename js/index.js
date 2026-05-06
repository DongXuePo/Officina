function getApiUrl(path) {
  return window.location.pathname.includes('/pages/') ? '../' + path : path;
}

async function loadProducts() {
  try {
    const response = await fetch(getApiUrl("api/getProducts.php"));
    const text = await response.text();

    let json;
    try {
      json = JSON.parse(text);
    } catch (parseError) {
      console.error("Invalid JSON response:", text);
      const container = document.getElementById("container");
      container.innerHTML = `<p style="color: red;">Errore: risposta API non valida. Controlla il server. ${parseError.message}</p>`;
      return;
    }

    if (json.status) {
      const container = document.getElementById("container");
      container.innerHTML = "";


      const path = window.location.pathname;
      let elementi = [];
      let title = "";
      
      if (path.includes("index.php") || path.includes("index.html")) {
        elementi = json.data.servizi;
        title = "Listino Servizi";
      } else if (path.includes("pezziRicambio.php")) {
        elementi = json.data.pezziRicambio;
        title = "Listino Pezzi di Ricambio";
      } else if (path.includes("accessori.php")) {
        elementi = json.data.accessori;
        title = "Listino Accessori";
      } else if (path.includes("officina.php")) {
        elementi = json.data.officine;
        title = "Officine";
      }
      


      const titleElement = document.createElement("h2");
      titleElement.textContent = title;
      container.appendChild(titleElement);

      if (elementi.length === 0) {
        const noProducts = document.createElement("p");
        noProducts.textContent = "Elemento non presente";
        container.appendChild(noProducts);
      } else {
        elementi.forEach((elemento) => {
          const card = document.createElement("div");
          card.style.border = "1px solid #ccc";
          card.style.margin = "10px";
          card.style.padding = "10px";

          let id = elemento.id_servizio || elemento.id_pezzo || elemento.id_accessorio;
          let valore = elemento.costo_orario || elemento.costo_unitario;
          let label = elemento.costo_orario ? "Costo orario: " : "Costo unitario: ";
          
          if (title === "Officine") {

            card.innerHTML = `
              <strong>ID: ${elemento.id_officina}</strong><br>
              ${elemento.denominazione}<br>
              ${elemento.indirizzo}<br>
              <hr>
              
            `;


          }else{
            card.innerHTML = `
              <strong>ID: ${id}</strong><br>
              ${elemento.descrizione }<br>
              ${label} ${valore}
              <hr>
            `;

          }

          

          container.appendChild(card);
        });
      }
    } else {
      const container = document.getElementById("container");
      container.innerHTML = `<p style="color: red;">Errore: ${json.message}</p>`;
    }
  } catch (error) {
    console.error("Error loading products:", error);
    const container = document.getElementById("container");
    container.innerHTML = `<p style="color: red;">Errore nel caricamento dei prodotti</p>`;
  }
}

window.addEventListener("load", () => loadProducts());