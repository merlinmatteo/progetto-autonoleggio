<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione Account</title>
    <link rel="stylesheet" href="static/stile_registrazione.css">
</head>

<body>
    <div class="container">
        <center>
            <h2>Registrazione</h2>
        </center>
        <br>
        <form action="#" method="POST">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" required>

            <label for="cognome">Cognome</label>
            <input type="text" id="cognome" name="cognome" required>

            <label for="email">Email</label>
            <input type="text" id="email" name="email" required>

            <label for="pwd">Password</label>
            <input type="password" id="pwd" name="pwd" required>

            <label for="citta">Città</label>
            <input type="text" id="citta" name="citta" required>

            <label for="via">Via</label>
            <input type="text" id="via" name="via" required>

            <label for="numero">Numero</label>
            <input type="text" id="numero" name="numero" required>

            <label for="cap">CAP</label>
            <input type="text" id="cap" name="cap" required>

            <label for="cellulare">Cellulare</label>
            <input type="text" id="cellulare" name="cellulare" required>

            <button type="submit">Registrati</button>
            <button type="reset">Pulisci i campi</button>
        </form>
    </div>

    <?php
    session_start(); // Avvia la sessione
    
    // Connessione al database
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "autonoleggio";
    $connessione = new mysqli($host, $user, $password, $db);

    if ($connessione->connect_errno) {
        die("Connessione fallita: " . $connessione->connect_error);
    }

    // Gestione della registrazione
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];
        $hash_pwd = password_hash($pwd, PASSWORD_DEFAULT);  
        $citta = $_POST["citta"];
        $via = $_POST["via"];
        $numero = $_POST["numero"];
        $cap = $_POST["cap"];
        $cellulare = $_POST["cellulare"];

        // Query SQL per inserire i dati
        $stmt = $connessione->prepare("INSERT INTO utenti (email, pwd, nome, cognome, citta, via, numero, cap, cellulare) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $email, $hash_pwd, $nome, $cognome, $citta, $via, $numero, $cap, $cellulare);

        if ($stmt->execute()) {
            echo "Registrazione completata con successo!";
            // Salva i dati nella sessione
            $_SESSION['email'] = $email;
            $_SESSION['pwd'] = $hash_pwd;
            $_SESSION['nome'] = $nome;
            $_SESSION['cognome'] = $cognome;
            $_SESSION['citta'] = $citta;
            $_SESSION['via'] = $via;
            $_SESSION['numero'] = $numero;
            $_SESSION['cap'] = $cap;
            $_SESSION['cellulare'] = $cellulare;
            // Reindirizza a una pagina di successo o login
            header("Location: login.php");
            exit();
        } else {
            echo "Errore durante la registrazione: " . $stmt->error;
        }

        $stmt->close();
    }

    $connessione->close();
    ?>

    <!-- PER PORTARE LA PAGINA NEL PUNTO PIU ALTO ALL APERTURA -->
    <script>
        window.onload = function () {
            window.scrollTo(0, 0);
        };
    </script>

</body>

</html>