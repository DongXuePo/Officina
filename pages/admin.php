<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- <script>
        // Controllo autenticazione
        const dipendente = JSON.parse(localStorage.getItem('dipendente'));
        if (!dipendente) {
            window.location.href = './loginDipendente.html';
        }
    </script> -->
</head>
<body>
    <?php require "../config/header.php"; ?>
    <h2>Pannello Amministratore</h2>
    <button id="logoutButton">Logout</button>

    <div class="section">
        <h2>Aggiungi Servizio</h2>
        <form id="addServizioForm">
            <label for="servizioDesc">Descrizione:</label>
            <input type="text" id="servizioDesc" required>
            <label for="servizioCosto">Costo Orario:</label>
            <input type="number" id="servizioCosto" required>
            <button type="submit">Aggiungi Servizio</button>
        </form>
        <div id="servizioMessage"></div>
    </div>

    <div class="section">
        <h2>Aggiungi Accessorio</h2>
        <form id="addAccessorioForm">
            <label for="accessorioDesc">Descrizione:</label>
            <input type="text" id="accessorioDesc" required>
            <label for="accessorioCosto">Costo Unitario:</label>
            <input type="number" id="accessorioCosto"  required>
            <button type="submit">Aggiungi Accessorio</button>
        </form>
        <div id="accessorioMessage"></div>
    </div>

    <div class="section">
        <h2>Aggiungi Pezzo di Ricambio</h2>
        <form id="addPezzoForm">
            <label for="pezzoDesc">Descrizione:</label>
            <input type="text" id="pezzoDesc" required>
            <label for="pezzoCosto">Costo Unitario:</label>
            <input type="number" id="pezzoCosto" required>
            <button type="submit">Aggiungi Pezzo</button>
        </form>
        <div id="pezzoMessage"></div>
    </div>


    <br> <br>



    <div class="section">
        <h2>Associa Servizio a Officina</h2>
        <form id="associaServizioForm">
            <label for="officinaServizio">Officina:</label>
            <select id="officinaServizio" required></select>
            <label for="servizioSelect">Servizio:</label>
            <select id="servizioSelect" required></select>
            <button type="submit">Associa Servizio</button>
        </form>
        <div id="associaServizioMessage"></div>
    </div>



    <div class="section">
        <h2>Associa Accessorio a Officina</h2>
        <form id="associaAccessorioForm">
            <label for="officinaAccessorio">Officina:</label>
            <select id="officinaAccessorio" required></select>
            <label for="accessorioSelect">Accessorio:</label>
            <select id="accessorioSelect" required></select>
            <label for="quantitaAccessorio">Quantità:</label>
            <input type="number" id="quantitaAccessorio" min="1" required>
            <button type="submit">Associa Accessorio</button>
        </form>
        <div id="associaAccessorioMessage"></div>
    </div>

    <div class="section">
        <h2>Associa Pezzo a Officina</h2>
        <form id="associaPezzoForm">
            <label for="officinaPezzo">Officina:</label>
            <select id="officinaPezzo" required></select>
            <label for="pezzoSelect">Pezzo:</label>
            <select id="pezzoSelect" required></select>
            <label for="quantitaPezzo">Quantità:</label>
            <input type="number" id="quantitaPezzo" min="1" required>
            <button type="submit">Associa Pezzo</button>
        </form>
        <div id="associaPezzoMessage"></div>
    </div>

    <script>
        async function loadData() {
            try {
                const response = await fetch('../api/getProducts.php');
                const data = await response.json();

                if (data.status) {
                    populateSelect('servizioSelect', data.data.servizi, 'id_servizio');
                    populateSelect('accessorioSelect', data.data.accessori, 'id_accessorio');
                    populateSelect('pezzoSelect', data.data.pezziRicambio, 'id_pezzo');
                    populateSelect('officinaServizio', data.data.officine, 'id_officina', 'denominazione');
                    populateSelect('officinaAccessorio', data.data.officine, 'id_officina', 'denominazione');
                    populateSelect('officinaPezzo', data.data.officine, 'id_officina', 'denominazione');
                }
            } catch (error) {
                console.error('Errore nel caricamento dei dati:', error);
            }
        }

        function populateSelect(selectId, data, idField, descField = 'descrizione') {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Seleziona...</option>';
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item[idField];
                option.textContent = item[descField];
                select.appendChild(option);
            });
        }

    

        document.getElementById('logoutButton').addEventListener('click', () => {
            localStorage.removeItem('dipendente');
            window.location.href = './index.php';
        });
    </script>
</body>