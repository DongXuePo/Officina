document.getElementById("registerButton").addEventListener("click", register);

function getApiUrl(path) {
  return window.location.pathname.includes('/pages/') ? '../' + path : path;
}

async function register() {
  const cognome = document.getElementById("cognomeInput").value;
  const nome = document.getElementById("nomeInput").value;
  const telefono = document.getElementById("telefonoInput").value;
  const email = document.getElementById("emailInput").value;
  const password = document.getElementById("passwordInput").value;

  if (!cognome || !password || !telefono || !nome || !email) {
    alert("tutti parametri richiesti");
    return;
  }

  const data = new URLSearchParams({
    cognome: cognome,
    nome: nome,
    telefono: telefono,
    password: password,
    email: email,
  });

  try {
    const response = await fetch(getApiUrl("api/register.php"), {
      method: "POST",
      body: data,
    });

    const contentType = response.headers.get('content-type') || '';
    let json;
    if (contentType.includes('application/json')) {
      json = await response.json();
    } else {
      const txt = await response.text();
      console.error('Non-JSON response from register:', txt);
      alert('Errore dal server: ' + txt);
      return;
    }

    if (json.status) {
      alert(json.message);
      location.href = "./verify.html";
    } else {
      alert(json.message);
    }
  } catch (error) {
    console.error("Error:", error);
    alert("errore: controlla la console del browser");
  }
}
  

