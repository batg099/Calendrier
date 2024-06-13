<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Méta-données pour définir le jeu de caractères et la mise à l'échelle -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titre de la page -->
    <title>Calendrier - Learneo</title>
    <!-- Liens vers les fichiers CSS et JavaScript externes -->
    <!-- 
    <link rel="stylesheet" type="text/css" media="screen and (min-width:600px)" href="sitebureau.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-width:600px)" href="filmmobile.css">
    -->
    <link rel="stylesheet" type="text/css" media="screen" href="learneo.css">
</head>
<body>
    
    <!-- En-tête de la page -->
    <header>
        <img id="logo" src="logo.png" alt="logo">
        <h1> Calendrier formation inter-entreprises </h1>
    </header>


    <!-- A ameliorer car horrible -->
    <form  method="post">
        <input  type="text" id="libre" name="libre"  placeholder="Recherche Libre" size="74" >
<?php
    // On ouvre le fichier
    $open = fopen("liste.csv","r");
    $menu = [];
    $departement = '';
    $calendrier = [];
    $i=0;
    // Tant qu'on trouve une ligne (hors ligne 0 et 1) dans notre fichier, on la prend 
    while ( ($data = fgetcsv($open,2000,";")) == true && $i>=0  ){
        // On considere que chaque element de la ligne est un element d'un tableau 
        $ligne = str_getcsv($data[0],";");
        if($i>=2){ 
            array_push($calendrier,["coco"]);

            $departement = $data[41];
            // On vérifie si le departement est deja present dans le menu
            if(in_array($departement,$menu) == false){
                array_push($menu,$departement);
            }
        }
        $i++;
    };
    print '<select name="resultat">';
    print '<option value="" disabled selected>--Sélectionnez une option--</option>';
    foreach($menu as $value){
        print '<option value="' . htmlspecialchars($value). '">' . htmlspecialchars($value)  . '</option>';
    }
    print '</select>';

?>
        <input  type="submit" value="Envoyer">
    </form>

    <h2 > <?php  
    if(isset($_POST["resultat"])){
        $resultat = $_POST["resultat"];
        echo htmlspecialchars($_POST["resultat"]); 
    }
        ?>
    </h2>

    <table>
        <tr>
            <th>Référence</th>
            <th>Intitulé de la formation</th>
            <th>Durée</th>
            <th>Mois en cours</th>
            <th>Mois + 1 </th>
            <th>Mois + 2</th>
        </tr>
                <?php  
                        $i=0;
                        $open = fopen("liste.csv","r");
                        $date = new DateTimeImmutable();
                        $mois = $date-> format("m");
                        // Tant qu'on trouve une ligne (hors ligne 0 et 1) dans notre fichier, on la prend 
                        while ( ($data = fgetcsv($open,2000,";")) == true && $i>=0  ){
                            // On considere que chaque element de la ligne est un element d'un tableau 
                            $ligne = str_getcsv($data[0],";");
                            if($i>=2){ 
                                $departement = $data[41];
                                // On vérifie si le departement est deja present dans le menu
                                if(isset($_POST["resultat"])){
                                    if($departement == $resultat){
                                        echo "<tr>";
                                        echo "<td>". $data[1] . "</td>";
                                        echo "<td>". $data[2] . "</td>";
                                        echo "<td>". $data[7] . " heures"."</td>";

                                        $mois_temp = $data[4];
                                        $mois_temp = explode("/",$mois_temp);
                                        $mois_temp = $mois_temp[1];
                                        if( $mois_temp == $mois){
                                            echo "<td>". $data[4] ."</td>";
                                            echo "<td>"."/ "."</td>";
                                            echo "<td>"."/ "."</td>";
                                        }
                                        else{
                                            echo "<td>"."/ "."</td>";
                                            if($mois_temp == ($mois+1) ){
                                                echo "<td>". $data[4] ."</td>";
                                                echo "<td>"."/ "."</td>";
                                                
                                            }
                                            else{
                                                echo "<td>"." /"."</td>";
                                                if($mois_temp == ($mois+2) ){
                                                    echo "<td>". $data[4] ."</td>";
                                                }
                                                else{
                                                    echo "<td>"." / "."</td>";
                                                }
                                            }
                                        }


                                        echo "</tr>";
                                    }
                                }
                            }
                            $i++;
                        }; 
                        fclose($open);
                ?>
   

        
    </table>
    


    

    
    <script src="site.js" ></script>
</body>

</html>



