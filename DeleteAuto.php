<?php
if (isset($_GET['cod_m']) && is_numeric($_GET['cod_m'])) {
    $cod_m = intval($_GET['cod_m']); // Assicura che l'ID sia un numero intero

    // Connessione al database
    $conn = new mysqli("localhost", "root", "", "autonoleggio");
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Query per eliminare l'auto
    $stmt = $conn->prepare("DELETE FROM macchine WHERE cod_m = ?");
    $stmt->bind_param("i", $cod_m);

    if ($stmt->execute()) {
        // Reindirizza alla pagina admin con un messaggio di successo
        header("Location: admin.php?success=1");
        exit;
    } else {
        echo "Errore durante l'eliminazione: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID auto non valido.";
}
?>