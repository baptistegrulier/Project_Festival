<?php
include 'db_connect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];
    $requete = $conn->prepare("SELECT id, password FROM users WHERE login = ?");
    $requete->bind_param("s", $login);
    $requete->execute();
    $resultat = $requete->get_result();

    if ($resultat->num_rows === 1) {
        $user = $resultat->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["userid"] = $user["id"];
            echo "Connexion réussie.";
            setcookie("loggedin", "true", time() + (86400 * 1), "/");
            header("Location: index.html");
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Utilisateur non trouvé.";
    }

    $requete->close();
}

$conn->close();
?>
