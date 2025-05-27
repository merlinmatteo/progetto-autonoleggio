<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "autonoleggio";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$sql = "SELECT * FROM prenotazioni ORDER BY cod_p DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Prenotazioni Registrate</title>
    <link rel="stylesheet" href="static/stile_admin.css">
</head>
<body>

    <div class="admin-container" >
        <div class="top-bar">
            <h1>Gestione Prenotazioni</h1>
            <a href="admin.php" class="btn">Torna ad Admin</a>
        </div>
        <table class="auto-table">
            <thead>
                <tr>
                    <th>Codice</th>
                    <th>Marca</th>
                    <th>Modello</th>
                    <th>Email Utente</th>
                    <th>Cellulare</th>
                    <th>Data Inizio</th>
                    <th>Data Fine</th>
                    <th>Metodo Pagamento</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['cod_p']}</td>";
                        echo "<td>{$row['marca']}</td>";
                        echo "<td>{$row['modello']}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "<td>{$row['cellulare']}</td>";
                        echo "<td>{$row['data_inizio']}</td>";
                        echo "<td>{$row['data_fine']}</td>";
                        echo "<td>{$row['metodo_pagamento']}</td>";
                        echo "<td>
                            <a href='DeletePrenot.php?cod_p={$row['cod_p']}' class='btnE' onclick=\"return confirm('Sei sicuro di voler eliminare questa prenotazione?');\">Elimina</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Nessuna prenotazione trovata.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>
