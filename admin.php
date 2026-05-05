<?php
require_once __DIR__ . "/classes/AuthManager.php";
if (!isset($_SESSION)) session_start();
//if (!AuthManager::isAdmin()) {
  //  header('Location: ./loginDipendente.html');
    //exit;
//}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

</head>
<body>
    <?php require "config/header.php"; ?>
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
                const response = await fetch('api/getProducts.php', { credentials: 'same-origin' });
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

        function showMessage(id, msg, ok = true) {
            const el = document.getElementById(id);
            el.textContent = msg;
        }

        async function postForm(url, body) {
            const res = await fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                body: new URLSearchParams(body)
            });
            return res.json();
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadData();

            document.getElementById('addServizioForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const desc = document.getElementById('servizioDesc').value;
                const costo = document.getElementById('servizioCosto').value;
                const json = await postForm('api/addServizio.php', { descrizione: desc, costo_orario: costo });
                showMessage('servizioMessage', json.message, json.status);
                if (json.status) loadData();
            });

            document.getElementById('addAccessorioForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const desc = document.getElementById('accessorioDesc').value;
                const costo = document.getElementById('accessorioCosto').value;
                const json = await postForm('api/addAccessorio.php', { descrizione: desc, costo_unitario: costo });
                showMessage('accessorioMessage', json.message, json.status);
                if (json.status) loadData();
            });

            document.getElementById('addPezzoForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const desc = document.getElementById('pezzoDesc').value;
                const costo = document.getElementById('pezzoCosto').value;
                const json = await postForm('api/addPezzoRicambio.php', { descrizione: desc, costo_unitario: costo });
                showMessage('pezzoMessage', json.message, json.status);
                if (json.status) loadData();
            });

            document.getElementById('associaServizioForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const id_off = document.getElementById('officinaServizio').value;
                const id_serv = document.getElementById('servizioSelect').value;
                const json = await postForm('api/associaServizio.php', { id_officina: id_off, id_servizio: id_serv });
                showMessage('associaServizioMessage', json.message, json.status);
            });

            document.getElementById('associaAccessorioForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const id_off = document.getElementById('officinaAccessorio').value;
                const id_acc = document.getElementById('accessorioSelect').value;
                const quant = document.getElementById('quantitaAccessorio').value;
                const json = await postForm('api/associaAccessorio.php', { id_officina: id_off, id_accessorio: id_acc, quantita: quant });
                showMessage('associaAccessorioMessage', json.message, json.status);
            });

            document.getElementById('associaPezzoForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const id_off = document.getElementById('officinaPezzo').value;
                const id_pez = document.getElementById('pezzoSelect').value;
                const quant = document.getElementById('quantitaPezzo').value;
                const json = await postForm('api/associaPezzo.php', { id_officina: id_off, id_pezzo: id_pez, quantita: quant });
                showMessage('associaPezzoMessage', json.message, json.status);
            });

            document.getElementById('logoutButton').addEventListener('click', async () => {
                try {
                    const res = await fetch('api/logoutDipendente.php', { method: 'POST', credentials: 'same-origin' });
                    const json = await res.json();
                    window.location.href = './loginDipendente.html';
                } catch (e) {
                    console.error('Logout error', e);
                    window.location.href = './loginDipendente.html';
                }
            });
        });
    </script>
</body>