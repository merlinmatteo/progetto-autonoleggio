<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferma</title>
    <style>
        body {
            background: linear-gradient(to right, #160707, #801e1e, #290d0d);
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
            padding: 40px;
        }

        .confirm-box {
            background-color: #111;
            border: 2px solid #800000;
            border-radius: 10px;
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.2);
        }

        .confirm-box h2 {
            color: #00ff66;
            margin-bottom: 15px;
        }

        .confirm-box p {
            font-size: 18px;
            line-height: 1.6;
        }

        .confirm-box a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #b71c1c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .confirm-box a:hover {
            background-color: #ff3333;
        }
    </style>
</head>
<body>
    
</body>
</html>

<?php
// Connessione al DB
$host = "localhost";
$user = "root";
$password = "";
$db = "autonoleggio";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Preleva i dati dal form
$marca = $_POST['marca'];
$modello = $_POST['modello'];
$email = $_POST['email'];
$cellulare = $_POST['cellulare'];
$data_inizio = $_POST['data_inizio'];
$data_fine = $_POST['data_fine'];
$metodo = $_POST['metodo_pagamento'];

// Validazione di base
if (empty($marca) || empty($modello) || empty($email) || empty($cellulare) || empty($data_inizio) || empty($data_fine) || empty($metodo)) {
    echo "<p style='color:red;'>⚠️ Tutti i campi sono obbligatori.</p>";
    exit;
}

// Query di inserimento nella tabella prenotazioni
$stmt = $conn->prepare("INSERT INTO prenotazioni (marca, modello, email, cellulare, data_inizio, data_fine, metodo_pagamento)
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $marca, $modello, $email, $cellulare, $data_inizio, $data_fine, $metodo);

if ($stmt->execute()) {
    // Aggiorna la disponibilità della macchina
    $updateStmt = $conn->prepare("UPDATE macchine SET disponibilita = 'non disponibile' WHERE marca = ? AND modello = ?");
    $updateStmt->bind_param("ss", $marca, $modello);

    if ($updateStmt->execute()) {
        echo "<div class='confirm-box'>";
        echo "<h2>✅ Prenotazione confermata!</h2>";
        echo "<p>Hai prenotato una <strong>$marca $modello</strong><br>dal <strong>$data_inizio</strong><br> al <strong>$data_fine</strong>.</p>";
        echo "<p>Riceverai presto conferma all'indirizzo: <strong>$email</strong></p>";
        echo "<a href='client.php'>Torna alla Home</a>";
        echo "</div>";
    } else {
        echo "<p style='color:red;'>❌ Errore durante l'aggiornamento della disponibilità: " . $updateStmt->error . "</p>";
    }

    $updateStmt->close();
} else {
    echo "<p style='color:red;'>❌ Errore durante la prenotazione: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();
?>
