<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Harmony Fest - Commandes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.cdnfonts.com/css/silkstone"/>
    <link rel="stylesheet" href="CSS/Body2.css">
    <script src="JS/script.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
</head>
<body>
    <style>
        @import url('https://fonts.cdnfonts.com/css/silkstone');
    </style>
    <video autoplay loop muted playsinline id="videoBackground">
        <source src="Sources/shadergradient.webm" type="video/webm">
    </video>
    <header>
        <div class="banner-container">
            <img src="Sources/banner.jpg" alt="En-tête" class="banner">
            <div class="flou">
                <h1>Harmony Fest</h1>
            </div>
        </div>
    </header>

    <main>
        <nav>
            <ul>
              <li><a href="index.html"><button class="bn632-hover bn25">Home</button></a></li>
              <li><a href="programme.html"><button class="bn632-hover bn25">Programme</button></a></li>
              <li><a href="contact.html"><button class="bn632-hover bn25">Contact</button></a></li>
              <li id="authBtn" style="display: block;"><a href="authentification.html"><button class="bn632-hover bn25">Connexion</button></a></li>
              <li id="resBtn" style="display: none;"><a href="reservations.html"><button class="bn632-hover bn25">Réservation</button></a></li>
              <li id="cmdBtn" style="display: none;"><a href="commandes.php"><button class="bn632-hover bn25">Commandes</button></a></li>
              <li id="logoutBtn" style="display: none;"><a href="logout.php"><button class="bn632-hover bn25">Déconnexion</button></a></li>
            </ul>
        </nav>

        <section id="visitorCountSection">
            <div class="visitorCountContainer">
                <h4>Visiteurs actuellement sur le site</h4>
                <p id="visitorCount"></p>
            </div>
        </section>

        <section id="commandesSection">
            <div class="commandesContainer">
                <h2>Vos Commandes</h2>
                <div class="resultContainer">
                    <?php
                    session_start();
                    include 'db_connect.php';

                    $commandesContent = '<p>Veuillez vous <a href="authentification.php">connecter</a> pour voir vos commandes.</p>';

                    if (isset($_SESSION['userid'])) {
                        $userid = $_SESSION['userid'];

                        $sql = "SELECT r.* FROM reservations r
                                INNER JOIN reservation_user ru ON r.id = ru.reservation_id
                                WHERE ru.user_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $userid);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            echo '<ul>';
                            while ($row = $result->fetch_assoc()) {
                                $jours = [];
                                if ($row['vendredi']) $jours[] = 'Vendredi';
                                if ($row['samedi']) $jours[] = 'Samedi';
                                if ($row['dimanche']) $jours[] = 'Dimanche';
                                $joursStr = implode(', ', $jours);

                                echo '<li>';
                                echo 'Commande ID: ' . htmlspecialchars($row['id']);
                                echo ', Nom: ' . htmlspecialchars($row['nom']);
                                echo ', Type de pass: ' . htmlspecialchars($row['type_pass']);
                                echo ', Jours: ' . $joursStr;
                                echo ', Quantité: ' . htmlspecialchars($row['nombre_places']);
                                if (!empty($row['commentaire'])) {
                                    echo ', Commentaire: ' . htmlspecialchars($row['commentaire']);
                                }
                                echo '</li>';
                            }
                            echo '</ul>';
                        } else {
                            echo '<p>Aucune commande trouvée.</p>';
                        }
                    }
                    $conn->close();
                    ?>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <ul>
            <li class="item">
              <a href="https://instagram.com">
                <i class="fa-brands fa-instagram icon"></i>
              </a>
            </li>
            <li class="item">
              <a href="https://youtube.com">
                <i class="fa-brands fa-youtube icon"></i>
              </a>
            </li>
            <li class="item">
              <a href="https://twitter.com">
                <i class="fa-brands fa-x-twitter icon"></i>
              </a>
            </li>
            <li class="item">
              <a href="tel:+3378340176">
                <i class="fa-solid fa-phone icon"></i>
              </a>
            </li>
            <li class="item">
                <a href="mailto:bat60400@gmail.com">
                  <i class="fa-solid fa-envelope icon"></i>
                </a>
            </li>
        </ul>
    </footer>
    
</body>
</html>