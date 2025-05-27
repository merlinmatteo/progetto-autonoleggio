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
            <h1>Gestione Parco Auto</h1>
            <a href="index.php" class="btn">Logout</a>
        </div>
        <center>
            <a href="AggAuto.php" class="btn2">➕ Aggiungi Nuova Auto</a>
            <a href="VisualizzaPrenot.php" class="btn2">📄 Visualizza Prenotazioni</a>
        </center>
        <br><br>
        <!-- Tabella auto -->
        <table class="auto-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Modello</th>
                    <th>Anno</th>
                    <th>Cilindrata</th>
                    <th>CV</th>
                    <th>Prezzo/giorno</th>
                    <th>Disponibilità</th>
                    <th>Descrizione</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $host = "localhost";
                $user = "root";
                $password = "";
                $db = "autonoleggio";

                $conn = new mysqli($host, $user, $password, $db);
                if ($conn->connect_error) {
                    die("Connessione fallita: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM macchine ORDER BY cod_m ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                            echo "<td>" . $row['cod_m'] . "</td>";
                            echo "<td>" . $row['marca'] . "</td>";
                            echo "<td>" . $row['modello'] . "</td>";
                            echo "<td>" . $row['anno'] . "</td>";
                            echo "<td>" . $row['cilindrata'] . "</td>";
                            echo "<td>" . $row['cv'] . "</td>";
                            echo "<td>€" . number_format($row['prezzo_giornaliero'], 2, ',', '.') . "</td>";
                            echo "<td>" . $row['descrizione'] . "</td>";
                            echo "<td>" . $row['disponibilita'] . "</td>";
                            echo "<td><a href='ModAuto.php?cod_m=" . $row['cod_m'] . "' class='btn3'>Modifica</a></td>";
                            echo "<td><a href='DeleteAuto.php?cod_m=" . $row['cod_m'] . "' class='btnE'>Elimina</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Nessuna auto trovata.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table> 
    </div>

</body>

</html>