<?php
include 'db_connect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $requete = $conn->prepare("SELECT id FROM users WHERE login = ?");
    $requete->bind_param("s", $login);
    $requete->execute();
    $resultat = $requete->get_result();

    if ($resultat->num_rows > 0) {
        echo "Ce login est déjà utilisé par un autre utilisateur.";
    } else {
        $requete = $conn->prepare("INSERT INTO users (login, nom, prenom, password) VALUES (?, ?, ?, ?)");
        $requete->bind_param("ssss", $login, $nom, $prenom, $password);

        if ($requete->execute()) {
            echo "Inscription réussie. Vous pouvez maintenant vous connecter.";
            header("Location: authentification.html");
            exit();
        } else {
            echo "Erreur : " . $requete->error;
        }
    }

    $requete->close();
}

$conn->close();
?>
