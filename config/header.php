<?php
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$baseUrl = $scriptDir;
if (basename($scriptDir) === 'pages') {
    $baseUrl = dirname($scriptDir);
}
$baseUrl = rtrim($baseUrl, '/\\');

session_start();
$isDipendenteLogged = isset($_SESSION['dipendente']);
?>
<header>
    <h1>officina</h1>
    <nav>
        <a href="<?= $baseUrl ?>/index.php">Servizi</a>
        <a href="<?= $baseUrl ?>/pezziRicambio.php">Pezzi di ricambio</a>
        <a href="<?= $baseUrl ?>/accessori.php">Accessori</a>
        <a href="<?= $baseUrl ?>/officina.php">Officine</a>
        <a href="<?= $baseUrl ?>/admin.php">Admin</a>
        <?php if ($isDipendenteLogged): ?>
            <a href="<?= $baseUrl ?>/magazziniere.php">Magazziniere</a>
            <a href="#" onclick="logoutDipendente()">Logout Dipendente</a>
        <?php else: ?>
            <a href="<?= $baseUrl ?>/login.html">Login Cliente</a>
            <a href="<?= $baseUrl ?>/loginDipendente.html">Login Dipendente</a>
            <a href="<?= $baseUrl ?>/register.html">Registrati</a>
        <?php endif; ?>
    </nav>
    <hr>
</header>
<script>
function logoutDipendente() {
    fetch('<?= $baseUrl ?>/api/logoutDipendente.php')
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                location.reload();
            } else {
                alert('Errore logout');
            }
        });
}
</script>