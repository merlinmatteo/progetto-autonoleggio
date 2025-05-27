<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$conn = new mysqli("localhost", "root", "", "autonoleggio");
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * 
                                FROM prenotazioni 
                                WHERE email = ? 
                                ORDER BY data_inizio DESC");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Le mie Prenotazioni</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: linear-gradient(to right, #160707, #801e1e, #290d0d);
            color: white;
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #111;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #444;
        }

        th {
            background-color: #1a0000;
        }

        tr:nth-child(even) {
            background-color: #222;
        }

        a.btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #b71c1c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        a.btn:hover {
            background-color: #ff3333;
        }
    </style>
</head>
<body>

<h1>Le mie Prenotazioni</h1>

<table>
    <thead>
        <tr>
            <th>Marca</th>
            <th>Modello</th>
            <th>Cellulare</th>
            <th>Data Inizio</th>
            <th>Data Fine</th>
            <th>Metodo Pagamento</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['marca']}</td>";
                echo "<td>{$row['modello']}</td>";
                echo "<td>{$row['cellulare']}</td>";
                echo "<td>{$row['data_inizio']}</td>";
                echo "<td>{$row['data_fine']}</td>";
                echo "<td>{$row['metodo_pagamento']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Nessuna prenotazione trovata.</td></tr>";
        }
        ?>
    </tbody>
</table>

<center><a href="client.php" class="btn">⬅ Torna alla tua area</a></center>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
