function getApiUrl(path) {
  return window.location.pathname.includes('/pages/') ? '../' + path : path;
}

async function loadMagazzino() {
  try {
    const response = await fetch(getApiUrl("api/getMagazzinoPezzi.php"));
    const json = await response.json();

    if (json.status) {
      const container = document.getElementById("container");
      container.innerHTML = "";

      const titleElement = document.createElement("h2");
      titleElement.textContent = "Magazzino Pezzi di Ricambio";
      container.appendChild(titleElement);

      if (json.data.length === 0) {
        const noItems = document.createElement("p");
        noItems.textContent = "Nessun pezzo in magazzino";
        container.appendChild(noItems);
      } else {
        json.data.forEach((pezzo) => {
          const card = document.createElement("div");
          card.style.border = "1px solid #ccc";
          card.style.margin = "10px";
          card.style.padding = "10px";

          card.innerHTML = `
            <strong>ID: ${pezzo.id_pezzo}</strong><br>
            ${pezzo.descrizione}<br>
            Costo unitario: ${pezzo.costo_unitario}<br>
            Quantità: <span id="quantita-${pezzo.id_pezzo}">${pezzo.quantita}</span><br>
            <button onclick="addQuantita(${pezzo.id_pezzo})">Aggiungi Quantità</button>
            <button onclick="removeQuantita(${pezzo.id_pezzo})">Rimuovi Quantità</button>
            <hr>
          `;

          container.appendChild(card);
        });
      }
    } else {
      const container = document.getElementById("container");
      container.innerHTML = `<p style="color: red;">Errore: ${json.message}</p>`;
    }
  } catch (error) {
    console.error("Error loading magazzino:", error);
    const container = document.getElementById("container");
    container.innerHTML = `<p style="color: red;">Errore nel caricamento del magazzino</p>`;
  }
}

async function addQuantita(id_pezzo) {
  const quantita = prompt("Inserisci la quantità da aggiungere:");
  if (quantita && parseInt(quantita) > 0) {
    try {
      const formData = new FormData();
      formData.append('id_pezzo', id_pezzo);
      formData.append('quantita', quantita);

      const response = await fetch(getApiUrl("api/addQuantitaPezzo.php"), {
        method: 'POST',
        body: formData
      });
      const json = await response.json();
      if (json.status) {
        alert(json.message);
        loadMagazzino(); // Ricarica
      } else {
        alert("Errore: " + json.message);
      }
    } catch (error) {
      console.error("Error adding quantita:", error);
      alert("Errore nell'aggiunta");
    }
  }
}

async function removeQuantita(id_pezzo) {
  const quantita = prompt("Inserisci la quantità da rimuovere:");
  if (quantita && parseInt(quantita) > 0) {
    try {
      const formData = new FormData();
      formData.append('id_pezzo', id_pezzo);
      formData.append('quantita', quantita);

      const response = await fetch(getApiUrl("api/removeQuantitaPezzo.php"), {
        method: 'POST',
        body: formData
      });
      const json = await response.json();
      if (json.status) {
        alert(json.message);
        loadMagazzino(); // Ricarica
      } else {
        alert("Errore: " + json.message);
      }
    } catch (error) {
      console.error("Error removing quantita:", error);
      alert("Errore nella rimozione");
    }
  }
}

window.addEventListener("load", () => loadMagazzino());