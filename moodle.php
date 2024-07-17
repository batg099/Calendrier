<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- MÃ©tadonnÃ©es pour dÃ©finir le jeu de caractÃ¨res et la mise Ã  l'Ã©chelle -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titre de la page -->
    <title>Calendrier - Learneo</title>
    <!-- Liens vers les fichiers CSS et JavaScript externes -->
    <link rel="stylesheet" type="text/css" media="screen" href="learneo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>

<table>
    <tr>
        <th>Username</th>
        <th>Cours</th>
        <th>Date</th>
    </tr>
        
<?php
require './config.php';
global $DB;

// ExÃ©cuter la requÃªte SQL pour rÃ©cupÃ©rer les donnÃ©es des utilisateurs
$users = $DB->get_records_sql('
    SELECT
        u.id AS userid,
        u.firstname,
        u.lastname,
        u.email,
        fb.id AS feedbackid,
        fb.name AS feedbackname,
        fb_sub.timemodified AS submissiontime
    FROM
        mdl_feedback_completed fb_sub
        JOIN mdl_user u ON fb_sub.userid = u.id
        JOIN mdl_feedback fb ON fb_sub.feedback = fb.id
    ORDER BY
        fb_sub.timemodified;');

// VÃ©rifier si des utilisateurs ont Ã©tÃ© trouvÃ©s
$nom = '';
if (!empty($users)) {
    foreach ($users as $user) {
        // VÃ©rifier si $user est un objet ou un tableau
        if (is_object($user)) {
            $firstname = $user->firstname;
            $lastname = $user->lastname;
            $feedback = $user->feedbackname;
            $submissiontime = $user->submissiontime;
        } elseif (is_array($user)) {
            $firstname = $user['firstname'];
            $lastname = $user['lastname'];
            $feedback = $user['feedbackname'];
            $submissiontime = $user['submissiontime'];
        } else {
            continue; // Si ce n'est ni un objet ni un tableau, passer Ã  l'utilisateur suivant
        }

        // Formater la date de soumission
        $formattedDate = date('d-m-Y H:i:s', $submissiontime);

        // Afficher le prÃ©nom, le nom de chaque utilisateur et la date de soumission
        echo "<tr>";
        echo "<td>" . $firstname . " " . $lastname . "</td>";
        echo "<td>" . $feedback . "</td>";
        echo "<td>" . $formattedDate . "</td>";
        echo "</tr>";

        // Ajouter Ã  la variable $nom
        $nom .= $firstname . ' ' . $lastname . ' | Cours : ' . $feedback . ' | Date de soumission : ' . $formattedDate . '\n';
    }
} else {
    echo "<tr><td colspan='3'>Aucun utilisateur trouvÃ©.</td></tr>";
}

// Envoyer l'email
mail('saidirayane345@gmail.com', 'utilisateurs', $nom);
?>
</table>
</body>
</html>
