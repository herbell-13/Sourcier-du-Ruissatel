<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Nettoyage et sécurité des données
    function nettoyer($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $nom       = nettoyer($_POST["nom"] ?? "");
    $prenom    = nettoyer($_POST["prenom"] ?? "");
    $telephone = nettoyer($_POST["telephone"] ?? "");
    $email     = filter_var($_POST["email"] ?? "", FILTER_SANITIZE_EMAIL);
    $adresse   = nettoyer($_POST["adresse"] ?? "");
    $prestation= nettoyer($_POST["prestation"] ?? "");

    // Validation minimale
    if (empty($nom) || empty($prenom) || empty($telephone) || empty($email) || empty($adresse) || empty($prestation)) {
        echo "❌ Veuillez remplir tous les champs.";
        exit;
    }

    // Préparation de l'e-mail
    $to      = "herve13011@gmail.com";  // Remplacez par votre email
    $subject = "Nouvelle demande de prestation - Formulaire site web";
    $message = "Une nouvelle demande a été envoyée :\n\n"
             . "Nom       : $nom\n"
             . "Prénom    : $prenom\n"
             . "Téléphone : $telephone\n"
             . "Email     : $email\n"
             . "Adresse   : $adresse\n\n"
             . "Prestation demandée :\n$prestation";

    $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=utf-8";

    // Envoi de l'e-mail
    if (mail($to, $subject, $message, $headers)) {
        echo "✅ Merci ! Votre message a bien été envoyé.";
    } else {
        echo "❌ Une erreur est survenue lors de l'envoi. Veuillez réessayer plus tard.";
    }
} else {
    echo "❌ Accès non autorisé.";
}
?>