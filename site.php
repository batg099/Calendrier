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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    
    <!-- En-tête de la page -->
    <header>
        <img id="logo" src="logo.png" alt="logo">
        <h1> Calendrier formation inter-entreprises </h1>
    </header>


    <!-- A ameliorer car horrible -->
    <form  method="post">
        <div class="search">
            <span class="material-symbols-outlined"> search </span>
            <input  type="text" id="libre" name="libre"  placeholder="Recherche Libre" size="74" >
        
<?php
    // On ouvre le fichier
    $open = fopen("liste.csv","r");
    $menu = [];
    $departement = '';
    $calendrier = [];
    $libre ='';
    $resultat='';
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
    print '<option value="" disabled selected>--Département--</option>';
    foreach($menu as $value){
        if($value != "PREPARATION" && $value != "TESTS"){
            print '<option value="' . htmlspecialchars($value). '">' . htmlspecialchars($value)  . '</option>';
        }
    }
    print '</select>';

?>

        <input   class="button" type="submit" value="Envoyer">
        </div>
    </form>

    <h2 > <?php  
    if(isset($_POST["resultat"])){
        $resultat = $_POST["resultat"];
        echo htmlspecialchars($_POST["resultat"]); 
    }
    if(isset($_POST["libre"])){
        $libre = $_POST["libre"];
    }
        ?>
    </h2>

    <table>
        <tr>
            <th>Référence</th>
            <th>Intitulé de la formation</th>
            <th>Durée</th>
            <?php 
                    $limite = 0;
                    $date = new DateTimeImmutable();
                    // On prend le mois (en String) et on le transforme en Int
                    $mois = intval($date-> format("m"));
                    function getMonthName($monthNumber) {
                        $months = [
                            1 => 'Janvier',
                            2 => 'Février',
                            3 => 'Mars',
                            4 => 'Avril',
                            5 => 'Mai',
                            6 => 'Juin',
                            7 => 'Juillet',
                            8 => 'Août',
                            9 => 'Septembre',
                            10 => 'Octobre',
                            11 => 'Novembre',
                            13 => 'Décembre'
                        ];
                    
                        return $months[$monthNumber] ?? 'Mois invalide'; // Renvoie le mois ou "Mois invalide" si le chiffre n'est pas valide
                    }
                    while($limite <= 2){
                        echo "<th>".getMonthName($mois + $limite)."</th>";
                        $limite = $limite + 1;
                    }
            ?>
        </tr>
                <?php  
                        $i=0;
                        $open = fopen("liste.csv","r");
                        $test=[0,0,0,0];
                        $indice=0;
                        $numero = 0;
                        function tableau($data,$numero){
                            $date = new DateTimeImmutable();
                            $mois = intval($date-> format("m"));
                            /*
                            if($numero === 0){
                                if(in_array($data[41],$test) == false){
                                    echo "<tr>"."<td>"."/ "."</td>"."</tr>" ;
                                    array_push($test,$data[41]);
                                }
                            }
                            */
                            echo "<tr>";
                            echo "<td>". $data[1] . "</td>";
                            echo "<td>". $data[2] . "</td>";
                            echo "<td>". $data[7]." heures"."</td>";

                            $mois_temp = $data[3];
                            $mois_temp = explode("/",$mois_temp);
                            $mois_temp = $mois_temp[1];
                            if( $mois_temp == $mois){
                                echo "<td>". $data[3] ."</td>";
                                echo "<td>"."/ "."</td>";
                                echo "<td>"."/ "."</td>";
                            }
                            else{
                                echo "<td>"."/ "."</td>";
                                if($mois_temp == ($mois+1) ){
                                    echo "<td>". $data[3] ."</td>";
                                    echo "<td>"."/ "."</td>";
                                    
                                }
                                else{
                                    echo "<td>"." /"."</td>";
                                    if($mois_temp == ($mois+2) ){
                                        echo "<td>". $data[3] ."</td>";
                                    }
                                    else{
                                        echo "<td>"." / "."</td>";
                                    }
                                }
                            }
                            echo "</tr>";
                        }
                        function array_sort_by_column(&$arr, $col, $dir = SORT_ASC)
                        {
                                                                    $sort_col = array();
                                                                    foreach ($arr as $key => $row) {
                                                                        $sort_col[$key] = $row[$col];
                                                                    }
                                                                    array_multisort($sort_col, $dir, $arr);
                                                            }

                        $tab=[];
                        $tab_intitule=[];
                        // Tant qu'on trouve une ligne (hors ligne 0 et 1) dans notre fichier, on la prend 
                        while ( ($data = fgetcsv($open,2000,";")) == true && $i>=0  ){
                            if($i>0){
                                //if(in_array($data[1],$tab_intitule) == false){
                                    array_push($tab,$data);
                                    //array_push($tab_intitule,$data[1]);
                                //}
                                /*
                                else{
                                    foreach($data as $element){
                                        if(array_search($element,$data)!=3 ){
                                            $element="/";
                                        }
                                    }
                                    array_push($tab,$data);
                                }
                                */
                            }
                            // On considere que chaque element de la ligne est un element d'un tableau 
                            $i++;
                        }; 

                        
                            array_sort_by_column($tab, 41);

                            //Fonction qui sert à comparer les dates de debut dans notre dictionnaire
                            function cmp($a, $b){
                                $dateA = DateTime::createFromFormat('d/m/Y', $a[3]);
                                $dateB = DateTime::createFromFormat('d/m/Y', $b[3]);
                            
                                if ($dateA == $dateB) {
                                    return 0;
                                }
                            
                                return ($dateA < $dateB) ? -1 : 1;
                            }

                            foreach($tab as $data){
                                if (!isset($tabi[$data[41]])) {
                                    $tabi[$data[41]] = [];
                                }
                               //echo "I am pushing\n";print_r($tabi[$data[41]]);
                                array_push($tabi[$data[41]],$data);
                            }
                            
                            foreach($tabi as $cle => $valeur){
                                    if( $cle !="PREPARATION"){
                                        if(empty($libre)==true && empty($resultat)==true){
                                            $test[$cle]=1;
                                            if($cle !== 'AUTRES'){
                                                echo "</table>";
                                                echo "<h2 style='background-color:#cda4fb;'>".$valeur[0][41]."</h2>" ;
                                                echo "<table>";
                                            }
                                            // On trie le tableau associe a chaque cle en fonction des dates de debuts
                                            usort($valeur, "cmp");
                                            foreach($valeur as $ligne){
                                                //echo "Moshi Moshi".$valeur[0][41];
                                                if(stripos($ligne[2], "TEST") == false){
                                                    tableau($ligne,0);
                                                }
                                            }
                                        }
                                        else{
                                            usort($valeur, "cmp");
                                            foreach($valeur as $ligne){
                                                $departement = $ligne[41];
                                                if(isset($_POST["resultat"]) && empty($resultat)==false){
                                                    if($departement == $resultat){
                                                        tableau($ligne,1);
                                                    }
                                                }
                                                else if(isset($_POST["libre"]) && empty($libre)==false){
                                                    //echo "mon resultat_1 est".$libre;
                                                    //echo "mon resultat_2 est".$data[1];
                                                    if (stripos($ligne[2], $libre) !== false || stripos($ligne[1], $libre) !== false || stripos($departement, $ligne) !== false){
                                                        //echo "mon resultat_2 est".$data[1];
                                                        //On verifie que "Test" n'est pas dans l'intitule
                                                        if(stripos($ligne[1], "TEST") === false){
                                                            tableau($ligne,1);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                

                            }
                        
                        //print_r($tabi);
                        fclose($open);
                ?>
   

        
    </table>
    


    

    
    <script src="site.js" ></script>
</body>

</html>
