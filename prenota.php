<?php
$marca = isset($_GET['marca']) ? htmlspecialchars($_GET['marca']) : '';
$modello = isset($_GET['modello']) ? htmlspecialchars($_GET['modello']) : '';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Prenota Auto</title>
    <link rel="stylesheet" href="static/stile_registrazione.css">
</head>
<body>

<div class="admin-container">
    <center><h1>Prenotazione auto</h1></center>
    <br>
    <form action="ConfPrenot.php" method="POST">

        <!-- Marca e modello non modificabili -->
        <input type="hidden" name="marca" value="<?= $marca ?>">
        <input type="hidden" name="modello" value="<?= $modello ?>">

        <p><strong>Auto scelta:</strong> <?= $marca ?> <?= $modello ?></p>
        <br>
        <label>Email Cliente:</label>
        <input type="text" name="email" required>

        <label>Cellulare:</label>
        <input type="text" name="cellulare" required>

        <label>Data Inizio:</label>
        <input type="date" name="data_inizio" required>

        <label>Data Fine:</label>
        <input type="date" name="data_fine" required>

        <label>Metodo di Pagamento:</label>
        <select name="metodo_pagamento" required>
            <option value="">-- Seleziona --</option>
            <option value="Carta di Credito">Carta di Credito</option>
            <option value="PayPal">PayPal</option>
            <option value="Contanti">Contanti</option>
        </select>

        <div class="button-group">
            <button type="submit">Conferma Prenotazione</button>
            <a href="client.php" class="btn"><button>Annulla</button></a>
        </div>
    </form>
</div>

</body>
</html>