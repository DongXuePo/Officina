document.getElementById("verifyButton").addEventListener("click", verifyCode);

function getApiUrl(path) {
  return window.location.pathname.includes('/pages/') ? '../' + path : path;
}

async function verifyCode() {
  const code = document.getElementById("codeInput").value.trim();

  if (!code) {
    alert("Inserisci il codice di verifica ricevuto via email.");
    return;
  }

  const data = new URLSearchParams({
    code: code,
  });

  try {
    const response = await fetch(getApiUrl("api/verifyCode.php"), {
      method: "POST",
      body: data,
    });

    const contentType = response.headers.get('content-type') || '';
    let json;
    if (contentType.includes('application/json')) {
      json = await response.json();
    } else {
      const txt = await response.text();
      console.error('Non-JSON response from verifyCode:', txt);
      alert('Errore dal server: ' + txt);
      return;
    }

    if (json.status) {
      alert(json.message);
      location.href = "index.php";
    } else {
      alert(json.message);
    }
  } catch (error) {
    console.error("Error:", error);
    alert("Errore: controlla la console del browser");
  }
}
