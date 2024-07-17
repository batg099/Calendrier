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
        $dossierDestination = '/var/www/html/uploads/';
        $nomFichier = $_FILES["file"]["name"];
        $cheminDestination = $dossierDestination . $nomFichier;
        $extensionFichier = pathinfo($nomFichier, PATHINFO_EXTENSION);

        // VÃ©rifier si un fichier avec le mÃªme nom existe
        if (file_exists($cheminDestination)) {
            // Supprimer le fichier existant
            if (unlink($cheminDestination)) {
                echo "Le fichier existant $nomFichier a Ã©tÃ© supprimÃ© avec succÃ¨s.<br>";
            } else {
                echo "Une erreur s'est produite lors de la suppression du fichier existant.<br>";
            }
        }

        // VÃ©rifier si le fichier a Ã©tÃ© correctement uploadÃ©
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $cheminDestination)) {
            echo "Le fichier $nomFichier a Ã©tÃ© uploadÃ© avec succÃ¨s.<br>";

            // VÃ©rifier l'extension du fichier
            if ($extensionFichier == 'xlsx') {
                $output = [];
                $return_var = 0;
                exec("python3 /var/www/html/uploads/convert.py 2>&1", $output, $return_var);

                echo "Code de retour : $return_var<br>";
                echo "Sortie :<br>" . implode("<br>", $output);
            } else {
                echo "Le fichier uploadÃ© n'est pas de type .xlsx. Le script Python ne sera pas exÃ©cutÃ©.<br>";
            }
        } else {
            echo "Une erreur s'est produite lors de l'upload du fichier.";
        }
    } else {
        //echo "Aucun fichier n'a Ã©tÃ© uploadÃ©.";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="file">Upload du Calendrier (liste.csv) ou de la liste des formations (Produits.csv) :</label><br>
        <input type="file" id="file" name="file"><br><br>
        <input type="submit" value="Uploader le fichier">
    </form>
</body>
</html>

