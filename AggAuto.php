<?php
// connessione al DB
$host = "localhost";
$user = "root";
$password = "";
$db = "autonoleggio";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Gestione invio form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = $_POST["marca"];
    $modello = $_POST["modello"];
    $anno = $_POST["anno"];
    $cilindrata = $_POST["cilindrata"];
    $cv = $_POST["cv"];
    $prezzo = $_POST["prezzo_giornaliero"];
    $descrizione = $_POST["descrizione"];
    $disponibilita = $_POST["disponibilita"];

    $stmt = $conn->prepare("INSERT INTO macchine (marca, modello, anno, cilindrata, cv, prezzo_giornaliero, descrizione, disponibilita)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisdsss", $marca, $modello, $anno, $cilindrata, $cv, $prezzo, $descrizione, $disponibilita);

    if ($stmt->execute()) {
        echo "<p style='color:lime;'>Auto aggiunta con successo!</p>";
    } else {
        echo "<p style='color:red;'>Errore: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="static/stile_admin.css">
</head>

<body>

    <div class="admin-container">
        <div class="top-bar">
            <h1>Aggiungi Nuova Auto</h1>
            <a href="admin.php" class="btn">Torna alla Gestione Auto</a>
        </div>

        <form method="POST">
            <center>
                <label>Marca:</label><br>
                <input type="text" name="marca" required><br><br>

                <label>Modello:</label><br>
                <input type="text" name="modello" required><br><br>

                <label>Anno:</label><br>
                <input type="number" name="anno" required><br><br>

                <label>Cilindrata:</label><br>
                <input type="text" name="cilindrata" required><br><br>

                <label>Cavalli (CV):</label><br>
                <input type="number" name="cv" required><br><br>

                <label>Prezzo giornaliero (€):</label><br>
                <input type="number" step="0.50" name="prezzo_giornaliero" required><br><br>

                <label>Descrizione:</label><br>
                <textarea name="descrizione" rows="4" cols="50" required></textarea><br><br>

                <label>Disponibilità:</label><br>
                <select name="disponibilita">
                    <option value="disponibile">Disponibile</option>
                    <option value="non disponibile">Non disponibile</option>
                </select><br><br>

                <button type="submit" class="btn3">Aggiungi</button>
            </center>
        </form>
    </div>

</body>

</html>