function getApiUrl(path) {
  return window.location.pathname.includes('/pages/') ? '../' + path : path;
}

window.addEventListener("load", () => {
  loadProductsData();
});


async function loadProductsData() {
  try {
    const response = await fetch(getApiUrl("api/getProducts.php"));
    const json = await response.json();

    if (json.status) {
      const serviziSelect = document.getElementById("servizi");
      json.data.servizi.forEach((servizio) => {
        const option = document.createElement("option");
        option.value = servizio.id_servizio;
        option.textContent = `${servizio.descrizione} - €${parseFloat(servizio.costo_orario).toFixed(2)}/h`;
        serviziSelect.appendChild(option);
      });


      const pezziSelect = document.getElementById("pezzi");
      json.data.pezziRicambio.forEach((pezzo) => {
        const option = document.createElement("option");
        option.value = pezzo.id_pezzo;
        option.textContent = `${pezzo.descrizione} - €${parseFloat(pezzo.costo_unitario).toFixed(2)}`;
        pezziSelect.appendChild(option);
      });


      const accessoriSelect = document.getElementById("accessori");
      json.data.accessori.forEach((accessorio) => {
        const option = document.createElement("option");
        option.value = accessorio.id_accessorio;
        option.textContent = `${accessorio.descrizione} - €${parseFloat(accessorio.costo_unitario).toFixed(2)}`;
        accessoriSelect.appendChild(option);
      });
    }
  } catch (error) {
    console.error("Errore nel caricamento dei dati:", error);
    showMessage("Errore nel caricamento dei dati", false);
  }
}


async function searchOfficine() {
  const servizio = document.getElementById("servizi").value;
  const pezzo = document.getElementById("pezzi").value;
  const accessorio = document.getElementById("accessori").value;


  if (!servizio && !pezzo && !accessorio) {
    showMessage("Seleziona almeno un servizio, pezzo o accessorio", false);
    return;
  }


  const resultsDiv = document.getElementById("results");
  resultsDiv.innerHTML = '<div class="loading"><div class="spinner"></div><p>Ricerca in corso...</p></div>';

  try {

    let url = "api/searchOfficina.php?";
    if (servizio) url += "servizio=" + servizio + "&";
    if (pezzo) url += "pezzo=" + pezzo + "&";
    if (accessorio) url += "accessorio=" + accessorio;

    const response = await fetch(url);
    const json = await response.json();

    resultsDiv.innerHTML = "";

    if (json.status && json.data.length > 0) {
      const title = document.createElement("div");
      title.className = "results-title";
      title.textContent = `${json.message}`;
      resultsDiv.appendChild(title);

      json.data.forEach((officina) => {
        const card = document.createElement("div");
        card.className = "officina-card";

        let html = `
          <div class="officina-header">
            <div class="officina-name">${officina.denominazione}</div>
            <div class="officina-address">${officina.indirizzo}</div>
          </div>
          <div class="officina-details">
        `;


        if (officina.servizi && officina.servizi.length > 0) {
          html += '<div class="detail-section">';
          html += '<div class="detail-title">Servizi Disponibili</div>';
          officina.servizi.forEach((s) => {
            html += `<div class="detail-item">${s.descrizione} - €${parseFloat(s.costo_orario).toFixed(2)}/h</div>`;
          });
          html += '</div>';
        }


        if (officina.pezzi && officina.pezzi.length > 0) {
          html += '<div class="detail-section">';
          html += '<div class="detail-title">Pezzi di Ricambio Disponibili</div>';
          officina.pezzi.forEach((p) => {
            html += `<div class="detail-item">${p.descrizione}<br/>Quantità: ${p.quantita} - €${parseFloat(p.costo_unitario).toFixed(2)}</div>`;
          });
          html += '</div>';
        }

        if (officina.accessori && officina.accessori.length > 0) {
          html += '<div class="detail-section">';
          html += '<div class="detail-title">Accessori Disponibili</div>';
          officina.accessori.forEach((a) => {
            html += `<div class="detail-item">${a.descrizione}<br/>Quantità: ${a.quantita} - €${parseFloat(a.costo_unitario).toFixed(2)}</div>`;
          });
          html += '</div>';
        }

        html += '</div>';
        card.innerHTML = html;
        resultsDiv.appendChild(card);
      });

      showMessage(`Ricerca completata: ${json.data.length} officina/e trovata/e`, true);
    } else {
      resultsDiv.innerHTML = `
        <div class="no-results">
          <p>${json.message}</p>
        </div>
      `;
      showMessage(json.message, false);
    }
  } catch (error) {
    console.error("Errore nella ricerca:", error);
    showMessage("Errore nella ricerca", false);
    resultsDiv.innerHTML = '<div class="error-message">Errore durante la ricerca. Riprova più tardi.</div>';
  }
}


function resetForm() {
  document.getElementById("servizi").value = "";
  document.getElementById("pezzi").value = "";
  document.getElementById("accessori").value = "";
  document.getElementById("results").innerHTML = "";
}


function showMessage(message, isSuccess) {
  console.log(isSuccess ? "✓ " + message : "✗ " + message);
}
