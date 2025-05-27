<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Noleggio</title>
    <link rel="stylesheet" href="static/stile_index.css">
    <style>
        .products-container {
            flex: 3; /* Occupa il resto dello spazio disponibile */
            box-sizing: border-box; /* Include padding e bordo nella larghezza */
            display: grid; /* Usa Grid per disporre le card */
            gap: 20px;
            padding: 40px 20px 20px 20px; 
        }
        .products-grid {
            display: flex; /* Usa Flexbox per disporre le card */
            flex-wrap: wrap; /* Permette di andare a capo se lo spazio non basta */
            gap: 20px; /* Spaziatura tra le card */
            justify-content: center; /* Centra le card orizzontalmente */
           
        }
        .product-card {
            flex: 1 1 calc(25% - 20px); /* Ogni card occupa il 25% della larghezza meno lo spazio */
            max-width: calc(25% - 20px); /* Limita la larghezza massima */
            box-sizing: border-box; /* Include padding e bordo nella larghezza */
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .product-card img {
            max-width: 100%;
            height: 200px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        .product-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #000;
        }
        .product-desc {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .product-price {
            font-size: 16px;
            color: #000;
            margin-bottom: 10px;
        }
        .product-card a {
            display: inline-block;
            padding: 8px 12px;
            background-color: #000;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .container {
            display: flex; /* Usa Flexbox per disporre gli elementi in riga */
            gap: 20px; /* Spaziatura tra la sidebar e lo showroom */
            align-items: flex-start; /* Allinea gli elementi in alto */
        }
        .sidebar {
            flex: 1; /* Occupa una parte della larghezza */
            max-width: 300px; /* Limita la larghezza massima della sidebar */
            box-sizing: border-box; /* Include padding e bordo nella larghezza */
        }
        .navbar ul {
            display: flex; /* Usa Flexbox per disporre gli elementi in riga */
            justify-content: flex-end; /* Allinea gli elementi a destra */
            list-style: none; /* Rimuove i punti elenco */
            padding: 0; /* Rimuove il padding */
            margin: 0; /* Rimuove il margine */
        }

        .navbar ul li {
            margin-left: 20px; /* Aggiunge spazio tra gli elementi */
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <div class="logo">Merlin AutoNoleggio</div>
    </div>  

    <!-- Menu di navigazione -->
    <div class="navbar">
        <nav>
            <ul>
                <li>Effettua il Login per prenotare la tua auto !</li>
                <li><a href="login.php" class="nav-button">Login</a></li>
            </ul>
        </nav>
    </div>

    <!-- Layout principale -->
    <div class="container">
        <!-- Sidebar sinistra -->
        <div class="sidebar">
            <h2>News</h2>
            <p>🚗 Rimani aggiornato con le ultime novità del nostro autonoleggio! <br> Nuovi modelli in arrivo, offerte esclusive e aggiornamenti sui nostri servizi pensati per offrirti il massimo del comfort e della libertà su strada.</p>
            <br>
            <h2>Info</h2>
            <p>🔧 Scopri tutti i dettagli sui nostri servizi: dal noleggio giornaliero alle soluzioni su misura per ogni esigenza. <br> Il nostro team è sempre pronto a offrirti assistenza professionale e trasparenza totale in ogni fase del tuo viaggio.</p>
            ✅ Servizio garantito
            <br>✔️ Prenotazione semplice
            <br>☑️ Assistenza 24/7
            <br><br>
            <h2>Contatti</h2>
            <a href="mailto:autonoleggiomerlin@gmail.com">📧 autonoleggiomerlin@gmail.com</a>
            <a href="tel:+3453020920"><br>📞 +3453020920</a>
            <br>
            <p>📍 ci trovi qui!</p><br>
            <div style="width: 100%; height: 300px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d37649.69333171322!2d9.152660988719125!3d45.46315189883914!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4786c1493f1275e7%3A0x3cffcd13c6740e8d!2sMilano%20MI!5e0!3m2!1sit!2sit!4v1746519290066!5m2!1sit!2sit" 
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>

        <!-- Area pubblica -->
        <div class="products-container">
            <center><h1>Showroom</h1></center>
            <div class="products-grid">
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

                // Query per ottenere tutte le auto disponibili
                $sql = "SELECT * 
                        FROM macchine 
                        WHERE disponibilita = 'disponibile'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Percorso immagine
                        $imagePath = 'static/img/' . htmlspecialchars($row['cod_m']) . '.jpg';
                        if (!file_exists($imagePath)) {
                            $imagePath = 'static/img/default.jpg'; 
                        }

                        echo '<div class="product-card">';
                        echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row['modello']) . '">';
                        echo '<div class="product-name">' . htmlspecialchars($row['marca']) . '</div>';
                        echo '<div class="product-name">' . htmlspecialchars($row['modello']) . '</div>';
                        echo '<div class="product-desc">' . htmlspecialchars($row['anno']) . '</div>';
                        echo '<div class="product-desc">' . htmlspecialchars($row['cv']) . ' cv</div>';
                        echo '<div class="product-desc">' . htmlspecialchars($row['descrizione']) . ' </div>';
                        echo '<div class="product-price">' . number_format($row['prezzo_giornaliero'], 2, ',', '.') . ' €</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>Nessuna auto disponibile al momento.</p>";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>

</html>