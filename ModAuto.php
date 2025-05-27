<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Auto</title>
    <link rel="stylesheet" href="static/stile_admin.css">
</head>

<body>
    <?php
    // Connessione al database
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "autonoleggio";
    $conn = new mysqli($host, $user, $password, $db);

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Recupera i dati dell'auto da modificare
    if (isset($_GET['cod_m'])) {
        $cod_m = $_GET['cod_m'];
        $stmt = $conn->prepare("SELECT * FROM macchine WHERE cod_m = ?");
        $stmt->bind_param("i", $cod_m);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "<p>Auto non trovata.</p>";
            exit();
        }
    } else {
        echo "<p>ID auto non specificato.</p>";
        exit();
    }

    // Aggiorna i dati nel database
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $marca = $_POST["marca"];
        $modello = $_POST["modello"];
        $anno = $_POST["anno"];
        $cv = $_POST["cv"];
        $prezzo_giornaliero = $_POST["prezzo_giornaliero"];
        $disponibilita = $_POST["disponibilita"];

        $stmt = $conn->prepare("UPDATE macchine SET marca = ?, modello = ?, anno = ?, cv = ?, prezzo_giornaliero = ?, disponibilita = ? WHERE cod_m = ?");
        $stmt->bind_param("ssiiisi", $marca, $modello, $anno, $cv, $prezzo_giornaliero, $disponibilita, $cod_m);

        if ($stmt->execute()) {
            echo "<p>Dati aggiornati con successo!</p>";
        } else {
            echo "<p>Errore durante l'aggiornamento: " . $stmt->error . "</p>";
        }
    }
    ?>

    <div class="admin-container">
        <div class="top-bar">
            <h1>Modifica Auto</h1>
            <a href="admin.php" class="btn">Torna alla Gestione Auto</a>
        </div>
        <br><br>
        <!-- Modulo per modificare i dati -->
        <form method="POST">
            <center>
                <label for="marca">Marca:</label><br>
                <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($row['marca']); ?>" required>
                <br><br>
                <label for="modello">Modello:</label><br>
                <input type="text" id="modello" name="modello" value="<?php echo htmlspecialchars($row['modello']); ?>" required>
                <br><br>
                <label for="anno">Anno:</label><br>
                <input type="number" id="anno" name="anno" value="<?php echo htmlspecialchars($row['anno']); ?>" required>
                <br><br>
                <label for="cv">Cavalli (CV):</label><br>
                <input type="number" id="cv" name="cv" value="<?php echo htmlspecialchars($row['cv']); ?>" required>
                <br><br>
                <label for="prezzo_giornaliero">Prezzo Giornaliero (€):</label><br>
                <input type="number" step="0.01" id="prezzo_giornaliero" name="prezzo_giornaliero" value="<?php echo htmlspecialchars($row['prezzo_giornaliero']); ?>" required>
                <br><br>
                <label for="disponibilita">Disponibilità:</label><br>
                <select id="disponibilita" name="disponibilita" required>
                    <option value="disponibile" <?php echo $row['disponibilita'] == 'disponibile' ? 'selected' : ''; ?>>Disponibile</option>
                    <option value="non disponibile" <?php echo $row['disponibilita'] == 'non disponibile' ? 'selected' : ''; ?>>Non Disponibile</option>
                </select>
                <br><br>
                <button type="submit" class="btn3">Salva Modifiche</button>
            </center>
        </form>
    </div>
</body>

</html>