<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploader un fichier</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
        $dossierDestination = '/opt/bitnami/apache/htdocs/';
        $nomFichier = $_FILES["file"]["name"];
        $cheminDestination = $dossierDestination . $nomFichier;

        // Vérifier si le fichier a été correctement uploadé
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $cheminDestination)) {
            echo "Le fichier $nomFichier a été uploadé avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'upload du fichier.";
        }
if ($_FILES['file']['name'] != "") {
    $path = $_FILES['file']['name'];
    $pathto = "/opt/bitnami/apache/htdocs/" . $path;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $pathto)) {
        echo "Le fichier $path a été téléchargé avec succès.";
    } else {
        echo "Une erreur s'est produite lors de l'upload du fichier. Code d'erreur : " . $_FILES['file']['error'];
    }
} else {
    die("Aucun fichier spécifié !");
}

    } else {
        echo "Aucun fichier n'a été uploadé.";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="file">Choisissez un fichier à uploader :</label><br>
        <input type="file" id="file" name="file"><br><br>
        <input type="submit" value="Uploader le fichier">
    </form>
</body>
</html>
