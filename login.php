<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="static/stile_login.css">

</head>
<body>
    <form method="POST" action="login.php">
        <center>
            <h1>Login</h1>
        </center>
        Utente:
        <input type="text" name="email"><br>
        Password:
        <input type="password" name="pwd"><br>
        <center>
            <a href="index.php"><button type="button">Home</button></a>
            <button type="submit">Login</button>
            <a href="registrazione.php"><button type="button">Registrati</button></a>
        </center>
    </form>

    <?php

        if (!empty($_POST["email"]) && !empty($_POST["pwd"])) {
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];

            // Connessione al database
            $host = "localhost";
            $user = "root";
            $password = "";
            $db = "autonoleggio";
            $connessione = new mysqli($host, $user, $password, $db);

            if ($connessione->connect_errno) {
                echo "Connessione fallita: " . $connessione->connect_error . ".";
                exit();
            }

            $stmt = $connessione->prepare("SELECT email, pwd, ruolo, nome 
                                            FROM utenti 
                                            WHERE email=?");
            $stmt->bind_param("s", $email); 
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if (password_verify($pwd, $row["pwd"])) {
                    session_start();
                    $_SESSION["email"] = $row["email"];
                    if ($row["ruolo"] == "a") {
                        header("Location: admin.php");
                    } else{ 
                        header("Location: client.php");
                    }
                } else {
                    echo "<p style='color:red; text-align:center;'>❌ Password errata.</p>";
                }

                $stmt->close();
                $connessione->close();
            }else {
                echo "<p style='color:red; text-align:center;'>❌ Utente non trovato.</p>";
            }
        }
    ?>

</body>
</html>