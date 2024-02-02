<?php
include 'db_connect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["userid"])) {
        echo "Veuillez vous connecter pour effectuer une réservation.";
        exit();
    }

    $nom = $_POST["name"];
    $places = $_POST["quantity"];
    $pass = $_POST["passType"];
    $vendredi = isset($_POST["friday"]) ? 1 : 0;
    $samedi = isset($_POST["saturday"]) ? 1 : 0;
    $dimanche = isset($_POST["sunday"]) ? 1 : 0;
    $commentaire = $_POST["comments"];
    $user_id = $_SESSION["userid"];

    $requete = $conn->prepare("INSERT INTO reservations (nom, type_pass, vendredi, samedi, dimanche, nombre_places, commentaire) VALUES (?, ?, ?, ?, ?, ?, ?)");

    $requete->bind_param("ssiiiis", $nom, $pass, $vendredi, $samedi, $dimanche, $places, $commentaire);

    if ($requete->execute()) {
        echo "Nouvel enregistrement créé avec succès.";
        $reservation_id = $conn->insert_id;

        $requete_assoc = $conn->prepare("INSERT INTO reservation_user (user_id, reservation_id) VALUES (?, ?)");
        $requete_assoc->bind_param("ii", $user_id, $reservation_id);
        if ($requete_assoc->execute()) {
            echo "Réservation liée à l'utilisateur avec succès.";
        } else {
            echo "Erreur lors de la liaison : " . $requete_assoc->error;
        }
        $requete_assoc->close();

        header("Location: commandes.php");
        exit();
    } else {
        echo "Erreur : " . $requete->error;
    }

    $requete->close();
}

$conn->close();
?>
