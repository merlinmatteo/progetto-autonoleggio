<?php
if (isset($_GET['cod_p'])) {
    $cod_p = $_GET['cod_p'];

    $conn = new mysqli("localhost", "root", "", "autonoleggio");
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM prenotazioni WHERE cod_p = ?");
    $stmt->bind_param("i", $cod_p);

    if ($stmt->execute()) {
        header("Location: VisualizzaPrenot.php?success=1");
        exit;
    } else {
        echo "Errore durante l'eliminazione: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID prenotazione non valido.";
}
?>