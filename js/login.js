

function getApiUrl(path) {
  return window.location.pathname.includes('/pages/') ? '../' + path : path;
}

document.getElementById("loginButton").addEventListener("click", login);

async function login() {
  const cognome = document.getElementById("cognomeInput").value;
  const nome = document.getElementById("nomeInput").value;
  const password = document.getElementById("passwordInput").value;

  if (!cognome || !password || !nome ) {
    alert("Inserire parametri");
    return;
  }

  const data = new URLSearchParams({
    cognome: cognome,
    nome: nome,
    password: password,
  });

  try {
    const response = await fetch(getApiUrl("api/login.php"), {
      method: "POST",
      body: data,
    });
    let json = await response.json();

    if (json.status) {
      sessionStorage.setItem("cognome", cognome);
      sessionStorage.setItem("nome", nome);
      alert(json.message);
      location.href = "./index.php";
    } else {
      alert(json.message);
    }
  } catch (error) {
    console.error("Error:", error);
    alert("Errore login");
  }
}
